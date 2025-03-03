<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['bookid'])) {
    $bookid = intval($_GET['bookid']); // Convert to integer for security
    $rollno = $_SESSION['RollNo'];

    // Check if the book is issued to the user and hasn't been returned yet
    $checkQuery = "SELECT * FROM olms.record WHERE BookId = ? AND RollNo = ? AND Date_Return IS NULL";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("is", $bookid, $rollno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Set return date as today
        $returnDate = date('Y-m-d');
        $updateQuery = "UPDATE olms.record SET Date_Return = ? WHERE BookId = ? AND RollNo = ? AND Date_Return IS NULL";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sis", $returnDate, $bookid, $rollno);

        if ($stmt->execute()) {
            echo "<script type='text/javascript'>alert('Book returned successfully!');window.location.href='pre_borrowed_book.php';</script>";
        } else {
            echo "<script type='text/javascript'>alert('Error returning book! Try again.');window.location.href='pre_borrowed_book.php';</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('No active record found for this book under your account!');window.location.href='pre_borrowed_book.php';</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Invalid Request!');window.location.href='pre_borrowed_book.php';</script>";
}

?>