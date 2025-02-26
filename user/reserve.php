<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    echo "<script>alert('You must log in first!'); window.location.href='login.php';</script>";
    exit();
}

if (isset($_GET['BookId'])) {
    $bookId = $_GET['BookId'];
    $rollNo = $_SESSION['RollNo'];

    // Check if the user already reserved this book
    $checkSql = "SELECT * FROM olms.reservation WHERE RollNo = ? AND BookId = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("si", $rollNo, $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('You have already reserved this book!'); window.location.href='currently_reserved.php';</script>";
    } else {
        // Reserve the book
        $reserveSql = "INSERT INTO olms.reservation (RollNo, BookId, Status) VALUES (?, ?, 'Pending')";
        $stmt = $conn->prepare($reserveSql);
        $stmt->bind_param("si", $rollNo, $bookId);

        if ($stmt->execute()) {
            echo "<script>alert('Book reserved successfully!'); window.location.href='currently_reserved.php';</script>";
        } else {
            echo "<script>alert('Reservation failed. Try again!'); window.location.href='bookdetails.php?BookId=$bookId';</script>";
        }
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='all_books.php';</script>";
}
?>
