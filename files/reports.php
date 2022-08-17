<div class="wd mx-auto">
    <p style="font-size: 20px; padding: 10px 0;">Print report cards</p>
    <div class="flex" style="padding: 5px; margin-bottom: 20px;">
        <?php
        $q = $db->query("SELECT * FROM classes");
        while($d = $q->fetch_assoc()) {
            ?>
            <a href="./?nav=reports&printreport=<?=$d['id']?>" style="background-color: #3a7; margin-right: 5px;padding: 5px;color: #fff;border-radius: 3px;"><?=$d['class']?></a>
            <?php
        }
        ?>
    </div>
    <hr>
    <?php
    if(isset($_GET['printreport'])) {
        $classId = $_GET['printreport'];
        $sql = "SELECT s.id, u.fname, u.lname, c.class FROM student as s join user as u on u.id=s.userid join classes as c on c.id = s.class WHERE s.class = '$classId'";
        // echo $sql;
        $q = $db->query($sql) or die($db->error);
        while($student = $q->fetch_assoc()) {
            $studentId = $student['id'];
            // echo $student['fname'].'<br>';
            ?>
            <main>
                <div class="heading">
                        <h1>BLANK REPORT CARD</h1>
                        <form action="#">
                            <label for="">Name: <?=$student['fname'] . ' '. $student['lname']?></label>
                            <input type="text"><br>
                            <label for="">Class: <?=$student['class']?></label>
                            <input type="text"><br>
                            <label style="color:black;" for="">Section:</label>
                            <input type="text"><br>
                            <label for="">Teacher:</label>
                            <input type="text">
                            <div class="ltable_section">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Total days of School</th>
                                        <th>Days Attended</th>
                                        <th>Days Absent</th>
                                    </tr>
                                </thead>
                            </table>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Subjects</th>
                                        <th>Marks</th>
                                        <th>Grades</th>
                                        <th>Curriculum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                
                <?php
            // return subjects from the database
            $sql = "SELECT id, `subject` FROM subjects WHERE classId = '$classId'";
            $q2 = $db->query($sql);
            while($subject = $q2->fetch_assoc()) {
                $subjectId = $subject['id'];
                // echo "<br>Name: " . $student['fname'] . ", subject = ". $subject['subject'];
                $sql = "SELECT * FROM marks where classId = '$classId' and subjectId = '$subjectId' and studentId = '$studentId'";
                // Getting the marks for this subject for this specific student
                $q3 = $db->query($sql);
                $d3 = $q3->fetch_assoc();
                ?>
                <tr>
                    <td><?=$subject['subject']?></td>
                    <td><?=$d3['score']?></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
                </table>
                <textarea name="" id="" cols="55" rows="7">comments</textarea>
                <label class="last" for="">Teacher's signature</label>
                <input type="text">
                <label for="">Parents's signature</label>
                <input type="text">
            </form>
            </div>
            </div>
            </main>
            <?php
        }
    }
    ?>
</div>