<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['BookId'])) {
    $bookId = $_GET['BookId'];
    $rollNo = $_SESSION['RollNo'];

    // Check if the user already reserved this book
    $checkSql = "SELECT 1 FROM olms.reservation WHERE RollNo = ? AND BookId = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("si", $rollNo, $bookId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        echo "<script>alert('You have already reserved this book!'); window.location.href='currently_reserved.php';</script>";
        exit();
    }
    $stmt->close();

    // Reserve the book
    $reserveSql = "INSERT INTO olms.reservation (RollNo, BookId, Status) VALUES (?, ?, 'Pending')";
    $stmt = $conn->prepare($reserveSql);
    $stmt->bind_param("si", $rollNo, $bookId);
    
    if ($stmt->execute()) {
        echo "<script>alert('Reserve request sent successfully! Awaiting approval.'); window.location.href='currently_reserved.php';</script>";
    } else {
        echo "<script>alert('Reservation request failed. Please try again!'); window.location.href='books_details.php?BookId=$bookId';</script>";
    }
    
    $stmt->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='all_books.php';</script>";
}
$conn->close();
?>
