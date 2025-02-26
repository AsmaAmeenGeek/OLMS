<?php
require('dbconn.php');
session_start(); // Ensure session is started

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script type='text/javascript'>alert('Invalid Book ID.')</script>";
    header("Refresh:0.01; url=currently_reserved.php", true, 303);
    exit();
}

$id = intval($_GET['id']); // Convert to integer to avoid SQL injection
$roll = $_SESSION['RollNo'];

// Check if a renewal request already exists
$check_sql = "SELECT * FROM olms.renew WHERE RollNo = ? AND BookId = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("si", $roll, $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script type='text/javascript'>alert('Request Already Sent.')</script>";
} else {
    // Insert new renewal request
    $sql = "INSERT INTO olms.renew (RollNo, BookId) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $roll, $id);

    if ($stmt->execute()) {
        echo "<script type='text/javascript'>alert('Request Sent to Admin.')</script>";
    } else {
        echo "<script type='text/javascript'>alert('Error in sending request.')</script>";
    }
}

// Redirect back to current books page
header("Refresh:0.01; url=currently_reserved.php", true, 303);
exit();
?>
