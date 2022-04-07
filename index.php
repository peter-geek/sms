<?php
session_start(); // accept session usage in this file
if (isset($_GET['logout'])) {
    // we are literally destroying the existence of the whole array.
    unset($_SESSION['sms_user']);
}

foreach (glob("./assets/vectors/*.svg") as $vector) {
    $info = pathinfo($vector);
    if (is_numeric($info['filename'])) continue;
    // echo "$vector<br>";
    $svg[$info['filename']] = file_get_contents($vector);
}

// Below, we want to store the user data in a global variable called $user_data only if the user is logged in
$user_data = isset($_SESSION['sms_user']) ? $_SESSION['sms_user'] : null; // store user data in an array
// chdir('./files'); // change working directory / folder to "files"
include('./files/database.php'); // import the database connection
$file = './files/login.php';
if (is_array($user_data)) $file = './files/dashboard.php';

require './files/head.php'; // Every page shall have contents in this file
require $file;
require './files/footer.php'; // contents in this file complement head.php
