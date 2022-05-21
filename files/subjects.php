<div class="mx-auto" style="max-width: 750px;">
    <div class="flex">
        <?php
        if(isset($_GET['edit'])) {
            $subjectId = $_GET['edit'];
            $subject = '';
            $classId = 0;
            if(isset($_POST['save'])) {
                $subject = $_POST['subject'];
                $classId = $_POST['classId'];
                $subjectId = $subjectId > 0 ? $subjectId : 'NULL';
                $sql = "INSERT INTO subjects (id, `subject`, classId) values($subjectId, '$subject', '$classId') on duplicate key update `subject`=values(`subject`), `classId`=values(`classId`)";
                // echo $sql;
                $db->query($sql) or die($db->error);
                ?>
                <!-- <script> window.location = './?nav=subjects&edit=0'; </script> -->
                <?php
            }
            // the user table
            $sql = "SELECT s.id, s.subject, s.classId from classes as c left join subjects as s on s.classId = c.id where s.id = '$subjectId'";
            $q = $db->query($sql) or die($db->error);
            if($q->num_rows > 0) {
                $record = $q->fetch_assoc();
                $subject = $record['subject'];
                $classId = $record['classId'];
            }
            ?>
            <form class="user" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" class="flex-shrink-0" style="width: 250px;">
                <p class="label">Subject</p>
                <input type="text" name="subject" placeholder="e.g Science" value="<?= $subject ?>" required>

                <p class="label">class</p>
                <select name="classId">
                    <?php
                    $q = $db->query("SELECT * FROM classes order by class asc");
                    while($d = $q->fetch_assoc()) {
                        ?>
                        <option value="<?=$d['id']?>" <?=$d['id'] == $classId ? 'selected="true"' : '' ?>><?=$d['class']?></option>
                        <?php
                    }
                    ?>
                </select>
                
                <input type="hidden" name="subjectId" value="<?= $subjectId ?>">
                <button type="submit" name="save">submit</button>
            </form>
            <?php
        }
        ?>
        <div class="flex-grow">
            <div class="flex items-center">
                <p class="flex-grow" style="font-size: 25px; padding: 10px 0 6px 0;">Subjects</p>
                <a href="./?nav=subjects&edit=0" style="background-color: #2e8560; color: #fff; padding: 6px 10px; border-radius: 4px; display: <?=isset($_GET['edit']) ? 'none' : 'block'?>">New subject</a>
            </div>
            <div style="margin-top: 20px">
                <table cellspacing="0" cellpadding="5" class="or_table">
                    <tr>
                        <th>ID</th>
                        <th>SUBJECT</th>
                        <th>CLASS</th>
                        <th style="width: 10px;"></th>
                    </tr>
                    <?php
                    $sql = "SELECT s.id, s.subject, c.class FROM subjects as s join classes as c on c.id = s.classId order by s.subject asc";
                    // echo $sql;
                    $q = $db->query($sql);
                    while($d = $q->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?=$d['id']?></td>
                            <td><?=$d['subject']?></td>
                            <td><?=$d['class']?></td>
                            <td>
                                <a href="./?nav=subjects&edit=<?= $d['id'] ?>" class="ic ic_rounded ic_green f-jc-ic"><?= $svg['edit'] ?></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>