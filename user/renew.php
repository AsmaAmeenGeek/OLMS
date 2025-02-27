<?php
require('dbconn.php');
session_start();

if (!isset($_SESSION['RollNo'])) {
    echo "<script type='text/javascript'>alert('Access Denied!!!');window.location.href='index.php';</script>";
    exit();
}

if (isset($_GET['bookid'])) {
    $bookid = intval($_GET['bookid']); // Convert to integer for security
    $rollno = $_SESSION['RollNo'];

    // Check if a renewal request already exists
    $checkQuery = "SELECT * FROM olms.renew WHERE BookId = ? AND RollNo = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("is", $bookid, $rollno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script type='text/javascript'>alert('Renewal request already sent!');window.location.href='pre_borrowed_book.php';</script>";
    } else {
        // Insert new renewal request
        $insertQuery = "INSERT INTO olms.renew (BookId, RollNo) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("is", $bookid, $rollno);

        if ($stmt->execute()) {
            echo "<script type='text/javascript'>alert('Renewal request sent to admin.');window.location.href='pre_borrowed_book.php';</script>";
        } else {
            echo "<script type='text/javascript'>alert('Error sending renewal request.');window.location.href='pre_borrowed_book.php';</script>";
        }
    }
} else {
    echo "<script type='text/javascript'>alert('Invalid Request!');window.location.href='pre_borrowed_book.php';</script>";
}
?>