<?php
session_start(); // accept session usage in this file
$user_data = isset($_SESSION['sms_user']) ? $_SESSION['user'] : null; // store user data in an array
chdir('./files'); // change working directory / folder to "files"
$file = 'login.php';
if (is_array($user_data)) $file = 'dashboard.php';

require 'head.php'; // Every page shall have contents in this file
require $file;
require 'footer.php'; // contents in this file complement head.php