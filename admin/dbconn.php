<?php
session_start();
$dbservername = "127.0.0.1";
$dbusername = "root";
$dbpassword = "asr@712jmn100";
$db="olms";
// Create connection
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword,$db);
// Check connection
if (!$conn) {
    echo "Connected unsuccessfully";
    die("Connection failed: " . mysqli_connect_error());
}