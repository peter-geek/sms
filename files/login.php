<div class="flex items-center justify-center h-full">
    <form class="login" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
        <p style="padding: 10px; text-align: center; font-size: 21px;">User login</p>
        <div style="margin: 0 20px;">
            <p class="h">Your email</p>
            <input type="text" name="email" placeholder="Email">
            <p class="h">Enter password</p>
            <input type="password" name="password" placeholder="Password">
            <button type="submit" name="login">login</button>
            <?php
            if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $query = $db->query("SELECT * FROM user where email = '$email'");
                if ($query->num_rows == 0) {
                    // num_rows counts the number of rows returned by the query
                    echo "Account does not exist";
                } else {
                    $result = $query->fetch_assoc(); // this will store the returned result into an associative array
                    if (password_verify($password, $result['password'])) {
                        // password verify compares to see if the provided password verifies what we already have in the database

                        $_SESSION['sms_user'] = $result; // storing the returned record in a session variable
            ?>
                        <script>
                            window.location = './'; // using javascript to redirect user
                        </script>
            <?php

                    } else {
                        echo "Wrong password";
                    }
                }
            }
            ?>
        </div>
    </form>
</div>