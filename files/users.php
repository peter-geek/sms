<div class="h-full wd mx-auto">
    <div class="rc flex justify-center items-center flex-col">
        <div style="width: 100%;">
            <div class="flex-row flex">
                <div class="flex-shrink-0" style="width: 300px;">
                    <?php
                    $fname = '';
                    $lname = '';
                    $email = '';
                    $password = '';
                    $acc_type = '';
                    $user_id = 0;
                    $error = '';
                    if (isset($_POST['fname'])) {
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $email = $_POST['email'];
                        $acc_type = $_POST['acc_type'];
                        $password = trim($_POST['password']);
                        $user_id = $_POST['user_id'];
                        // name email password acc_type
                        $encrypted_pass = password_hash($password, PASSWORD_DEFAULT);

                        if ($user_id == 0) {
                            if ($password != '') {
                                // check if user exists
                                $q = $db->query("SELECT * FROM user where email = '$email'");
                                if ($q->num_rows == 0) {
                                    $sql = "INSERT INTO user (`fname`, `lname`, `email`, `password`, `acc_type`) values('$fname', '$lname', '$email', '$encrypted_pass', '$acc_type')";
                                    $db->query($sql) or die($db->error);
                                    $fname = '';
                                    $lname = '';
                                    $email = '';
                                    $password = '';
                                    $acc_type = '';
                                    $user_id = 0;
                                    $error = '';
                                } else $error = 'Account already exists.';
                            } else $error = 'Password is required.';
                        } else {
                            $sql = "UPDATE user set `fname` = '$fname', `lname` = '$lname', `email` = '$email', `password` = '$encrypted_pass', `acc_type` = '$acc_type' where id = '$user_id'";
                            if ($password == '') {
                                $sql = "UPDATE user set `fname` = '$fname', `lname` = '$lname', `email` = '$email', `acc_type` = '$acc_type' where id = '$user_id'";
                            }
                            $db->query($sql) or die($db->error);
                    ?>
                            <script>
                                window.location = './';
                            </script>
                        <?php
                        }
                    } else if (isset($_GET['edit'])) {
                        $user_id = $_GET['edit'];
                        $q = $db->query("SELECT * FROM user where id = '$user_id'") or die($db->error);
                        $d = $q->fetch_assoc();
                        $fname = $d['fname'];
                        $lname = $d['lname'];
                        $email = $d['email'];
                        $acc_type = $d['acc_type'];
                    } else if (isset($_GET['delete'])) {
                        $user_id = $_GET['delete'];
                        $db->query("DELETE FROM user where id = '$user_id'");
                        ?>
                        <script>
                            window.location = './';
                        </script>
                    <?php
                    }
                    ?>
                    <form class="user" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                        <p class="label">First name</p>
                        <input type="text" name="fname" placeholder="e.g Peter" value="<?= $fname ?>" required>
                        <p class="label">Last name</p>
                        <input type="text" name="lname" placeholder="e.g Mukiibi" value="<?= $lname ?>" required>
                        <p class="label">Email address</p>
                        <input type="email" name="email" placeholder="e.g admin@example.com" value="<?= $email ?>" required>
                        <p class="label">Account type</p>
                        <select name="acc_type">
                            <option value="student" <?= $acc_type == 'student' ? 'selected="true"' : '' ?>>Student</option>
                            <option value="teacher" <?= $acc_type == 'student' ? 'selected="true"' : '' ?>>Teacher</option>
                            <option value="admin" <?= $acc_type == 'student' ? 'selected="true"' : '' ?>>Admin</option>
                        </select>
                        <p class="label">Password</p>
                        <input type="password" name="password" placeholder="e.g 87T%^RF">
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <button type="submit">submit</button>
                        <p class="form_error"><?= $error ?></p>
                    </form>
                </div>
                <div class="flex-grow">
                    <p style="font-size: 23px; padding: 15px 0;">User list</p>
                    <table cellspacing="0" cellpadding="5" class="or_table">
                        <tr class="thead">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Account type</th>
                            <th style="width: 10px;"></th>
                            <th style="width: 10px;"></th>
                        </tr>
                        <?php
                        $q = $db->query("SELECT * FROM user order by fname asc");
                        while ($d = $q->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?= $d['fname'] . ' ' . $d['lname'] ?></td>
                                <td><?= $d['email'] ?></td>
                                <td><?= strtolower($d['acc_type']) ?></td>
                                <td>
                                    <a href="./?nav=users&edit=<?= $d['id'] ?>" class="ic ic_rounded ic_green f-jc-ic"><?= $svg['edit'] ?></a>
                                </td>
                                <td>
                                    <a href="./?nav=users&delete=<?= $d['id'] ?>" class="ic ic_rounded ic_red f-jc-ic"><?= $svg['delete'] ?></a>
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
</div>