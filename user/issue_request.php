<?php
require('dbconn.php');

$id = $_GET['id'];

$roll = $_SESSION['RollNo'];

// Check if the record already exists
$check_sql = "SELECT * FROM olms.record WHERE RollNo = ? AND BookId = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ss", $roll, $id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Record already exists
    echo "<script type='text/javascript'>alert('Request Already Sent.')</script>";
    header("Refresh:0.01; url=all_books.php", true, 303);
} else {
    // Record does not exist, insert new record
    $sql = "INSERT INTO olms.record (RollNo, BookId, Time) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $roll, $id);

    if ($stmt->execute()) {
        echo "<script type='text/javascript'>alert('Request Sent to Admin.')</script>";
        header("Refresh:0.01; url=all_books.php", true, 303);
    } else {
        echo "<script type='text/javascript'>alert('An error occurred. Please try again later.')</script>";
        header("Refresh:0.01; url=all_books.php", true, 303);
    }
    $stmt->close();
}

$check_stmt->close();
?>