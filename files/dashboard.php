<div class="flex flex-col h-full">
    <div style="border-bottom: 1px solid #f60;">
        <div class="wd mx-auto flex items-center">
            <p style="font-size: 14px; font-weight: bold;">LAMERA PRIMARY SCHOOL</p>
            <nav class="flex-grow flex">
                <a href="./?nav=stats" class="active">Stats</a>
                <a href="./?nav=students">Students</a>
                <a href="./?nav-teachers">Teachers</a>
                <a href="./?nav=users">Users</a>
                <a href="./?logout">Logout</a>
            </nav>
        </div>
    </div>
    <div class="flex-grow" style="overflow-y: auto;">
        <div class="h-full wd mx-auto">
            <div class="rc flex justify-center items-center flex-col">
                <div style="width: 100%;">
                    <div class="flex-row flex">
                        <div class="flex-shrink-0" style="width: 300px;">
                            <form class="user" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                                <p class="label">First name</p>
                                <input type="text" name="fname" placeholder="e.g Peter" required>
                                <p class="label">Last name</p>
                                <input type="text" name="lname" placeholder="e.g Mukiibi" required>
                                <p class="label">Email address</p>
                                <input type="email" name="email" placeholder="e.g admin@example.com" required>
                                <p class="label">Account type</p>
                                <select name="acc_type">
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <p class="label">Password</p>
                                <input type="password" name="password" placeholder="e.g 87T%^RF" required>
                                <input type="hidden" name="user_id" value="0">
                                <button type="submit">submit</button>
                                <div>
                                    <?php
                                    if (isset($_POST['fname'])) {
                                        $fname = $_POST['fname'];
                                        $lname = $_POST['lname'];
                                        $email = $_POST['email'];
                                        $acc_type = $_POST['acc_type'];
                                        $password = $_POST['password'];
                                        $user_id = $_POST['user_id'];
                                        // name email password acc_type
                                        $encrypted_pass = password_hash($password, PASSWORD_DEFAULT);

                                        $sql = "INSERT INTO user (`fname`, `lname`, `email`, `password`, `acc_type`) values('$fname', '$lname', '$email', '$encrypted_pass', '$acc_type')";
                                        if ($user_id > 0) {
                                            $sql = "UPDATE user set `fname` = '$fname', `lname` = '$lname', `email` = '$email', `password` = '$encrypted_pass', `acc_type` where id = '$user_id'";
                                        }
                                        $db->query($sql) or die($db->error);
                                    }
                                    ?>
                                </div>
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
                                            <a href="#" class="ic ic_rounded ic_green f-jc-ic"><?= $svg['edit'] ?></a>
                                        </td>
                                        <td>
                                            <a href="#" class="ic ic_rounded ic_red f-jc-ic"><?= $svg['delete'] ?></a>
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
    </div>
</div>