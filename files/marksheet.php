<?php
$student_array = array();
$subjects = array();
$class = '';

function getScore($studentId = 0, $subjectId = 0) {
    global $student_array, $subjects;
    foreach($student_array as $index => $student) {
        if($studentId == $student['studentId']) {
            foreach($subjects as $key => $subject) {
                if($subject['subjectId'] == $subjectId) {
                    return isset($student['marks']) && isset($student['marks'][$key]) ? $student['marks'][$key]['score'] : -4;
                }
            }
            return 0;
        }
    }
    return 0;
}

function addScore($studentId = 0, $score = 0, $subjectId = 0) {
    global $student_array;
    $x = getStudentRecord($studentId);
    if(isset($student_array[$x]['marks'])) {
       $student_array[$x]['marks'][] = array(
            'subjectId' => $subjectId,
            'score' => $score
        );
    }
    else {
        $student_array[$x]['marks'] = array(
            array(
                'subjectId' => $subjectId,
                'score' => $score
            )
        );
    }
}
function getStudentRecord($studentId = 0) {
    global $student_array;
    foreach($student_array as $key => $student) {
        if($student['studentId'] == $studentId) return $key;
    }
    return -1;
}

if(isset($_GET['classId'])) {
    $classId = $_GET['classId'];
        
    // saving the marksheet
    if(isset($_POST['save_scores'])) {
        $studentIds = $_POST['studentId'];
        $subjectIds = $_POST['subjectId'];
        $scores = $_POST['scores'];
        foreach($scores as $index => $score) {
            $subjectId  = $subjectIds[$index];
            $studentId  = $studentIds[$index];
            $score      = $scores[$index];
            $db->query("INSERT INTO `marks` (`studentId`, `classId`, `subjectId`, `score`) values('$studentId', '$classId', '$subjectId', '$score') on duplicate key update `studentId` = values(`studentId`), `classId` = values(`classId`), `subjectId`=values(`subjectId`), `score`=values(`score`)");
        }
    }

    $q = $db->query("SELECT * FROM classes where id = '$classId'");
    $d = $q->fetch_assoc();
    $class = $d['class'];
    // get all student records
    $q = $db->query("SELECT s.id, u.id as userid, u.fname, u.lname FROM `user` as u join student as s on s.userid=u.id order by u.fname asc, u.lname asc");
    while($row = $q->fetch_assoc()) {
        $student_array[] = array(
            'studentId' => $row['id'],
            'name' => $row['fname'] .' ' . $row['lname']
        );
    }

    // subjects
    $q = $db->query("SELECT * from subjects order by `subject` asc");
    while($row = $q->fetch_assoc()) {
        $subjects[] = array(
            'subject' => $row['subject'],
            'subjectId' => $row['id']
        );
    }

    // store all scores as well
    $q = $db->query("SELECT * FROM marks");
    while($row = $q->fetch_assoc()) {
        addScore($row['studentId'], $row['score'], $row['subjectId']);
    }
}
?>
<div class="wd mx-auto">
    <div class="flex" style="padding: 5px; margin-bottom: 20px;">
        <?php
        $q = $db->query("SELECT * FROM classes");
        while($d = $q->fetch_assoc()) {
            ?>
            <a href="./?nav=marksheet&classId=<?=$d['id']?>" style="background-color: #3a7; margin-right: 5px;padding: 5px;color: #fff;border-radius: 3px;"><?=$d['class']?></a>
            <?php
        }
        ?>
    </div>
    <?php
    if(isset($_GET['classId'])) {
        ?>
        <div>
            <p style="font-size: 25px; margin-bottom: 10px;"><?=$class?> Marksheet</p>
        </div>
        <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
            <table cellspacing="0" cellpadding="5" class="or_table">
                <tr>
                    <th></th>
                    <?php
                    foreach($subjects as $subject) {
                        ?>
                        <th><?=$subject['subject']?></th>
                        <?php
                    }
                    ?>
                </tr>
                <?php
                foreach($student_array as $student) {
                    // print_r($student);
                    $studentId = $student['studentId'];
                    ?>
                    <tr>
                        <td><?=$student['name']?></td>
                        <?php
                        foreach($subjects as $subject) {
                            $subjectId = $subject['subjectId'];
                            $score = getScore($studentId, $subjectId);
                            ?>
                            <td>
                                <input type="text" name="scores[]" value="<?=$score?>" style="border: none; margin: -5px; padding: 5px; width: 100%;" />
                                <input type="hidden" name="subjectId[]" value="<?=$subject['subjectId']?>">
                                <input type="hidden" name="studentId[]" value="<?=$student['studentId']?>">
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <button type="submit" style="background-color: #2e8560; border: none; margin-top: 10px; color: #fff; padding: 6px 10px; border-radius: 4px;" name="save_scores">save</button>
        </form>
        <?php
    }
    // echo '<pre>';
    // print_r($student_array);
    // echo '</pre>';
    ?>
</div>