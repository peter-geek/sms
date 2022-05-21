<div class="wd mx-auto">
    <div class="flex">
        <?php
        
        if(isset($_GET['edit'])) {
            $studentId = $_GET['edit'];
            if(isset($_POST['save'])) {
                $dob = date('Y-m-d', strtotime($_POST['dob']));
                $parent_name = $_POST['parent_name'];
                $parent_contact = $_POST['parent_contact'];
                $class = $_POST['classId'];
                // $sql = "UPDATE student set `dob` = '$dob', parent_name = '$parent_name', parent_contact = '$parent_contact' where userid = '$studentId'";
                $sql = "INSERT INTO student (userid, dob, parent_name, parent_contact, class) values ('$studentId', '$dob', '$parent_name', '$parent_contact', '$class') on duplicate key update dob=values(`dob`), parent_name=values(`parent_name`), parent_contact=values(`parent_contact`), class=values(`class`)";
                // echo $sql;
                $db->query($sql) or die($db->error);
                ?>
                <script> window.location = './?nav=students'; </script>
                <?php
            }
            // the user table
            $q = $db->query("SELECT u.fname, u.lname, u.email, s.dob, s.class, s.parent_name, s.parent_contact FROM user as u left join student as s on u.id = s.userid where u.id = '$studentId'");
            $student_record = $q->fetch_assoc();
            ?>
            <form class="user" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" class="flex-shrink-0" style="width: 250px;">
                <p class="label">Name</p>
                <input type="text" name="fname" placeholder="e.g Peter" value="<?= $student_record['fname'] . ' ' . $student_record['lname'] ?>" style="opacity: 0.4;" required readonly>

                <p class="label">DOB</p>
                <input type="date" name="dob" value="<?= date('Y-m-d', strtotime($student_record['dob'])) ?>" required>
                
                <p class="label">class</p>
                <select name="classId">
                    <?php
                    $q = $db->query("SELECT * FROM classes order by class asc");
                    while($d = $q->fetch_assoc()) {
                        ?>
                        <option value="<?=$d['id']?>" <?=$d['id'] == $student_record['class'] ? 'selected="true"' : '' ?>><?=$d['class']?></option>
                        <?php
                    }
                    ?>
                </select>

                <p class="label">Parent Name</p>
                <input type="text" name="parent_name" value="<?= $student_record['parent_name'] ?>" required>

                <p class="label">Parent Contact</p>
                <input type="text" name="parent_contact" value="<?= $student_record['parent_contact'] ?>" required>
                
                <input type="hidden" name="studentId" value="<?= $studentId ?>">
                <button type="submit" name="save">submit</button>
            </form>
            <?php
        }
        ?>
        <div class="flex-grow">
            <p style="font-size: 25px; padding: 10px 0 6px 0;">Find Student</p>
            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST" class="searchbar flex">
                <div class="flex-grow" style="padding: 3px 5px;border: 1px solid #ffe3d0;margin-right: 5px;border-radius: 3px;">
                    <input type="text" name="query" class="txt" placeholder="Search by name or email ...">
                </div>
                <button type="submit" name="search" class="searchbtn">search</button>
            </form>
            <div style="margin-top: 20px">
                <table cellspacing="0" cellpadding="5" class="or_table">
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>CLASS</th>
                        <th style="width: 10px;"></th>
                    </tr>
                    <?php
                    $sql = "SELECT u.id, concat(u.fname,' ', u.lname) as name, u.email, s.dob, c.class, s.parent_name, s.parent_contact FROM user as u left join student as s on u.id = s.userid left join classes as c on c.id = s.class where u.acc_type = 'student'";
                    if(isset($_POST['search'])) {
                        $query = $_POST['query'];
                        $sql = "SELECT u.id, concat(u.fname,' ', u.lname) as name, u.email, s.dob, c.class, s.parent_name, s.parent_contact FROM user as u left join student as s on u.id = s.userid left join classes as c on c.id = s.class where u.acc_type = 'student' and (u.fname like '%$query%' or u.lname like '%$query%')";
                    }
                    // echo $sql;
                    $q = $db->query($sql) or die($db->error);
                    while($d = $q->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?=$d['id']?></td>
                            <td><?=$d['name']?></td>
                            <td><?=$d['email']?></td>
                            <td><?=$d['class']?></td>
                            <td>
                                <a href="./?nav=students&edit=<?= $d['id'] ?>" class="ic ic_rounded ic_green f-jc-ic"><?= $svg['edit'] ?></a>
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