<?php
require('dbconn.php');


if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['BookId'])) {
    $bookId = $_GET['BookId'];
    $rollNo = $_SESSION['RollNo'];

    // Check if the user has an existing reservation
    $checkSql = "SELECT Status FROM olms.reservation WHERE RollNo = ? AND BookId = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("si", $rollNo, $bookId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($status);
    
    if ($stmt->fetch()) {
        if ($status === 'Pending') {
            $stmt->close();
            header("Location: currently_reserved.php?error=already_requested");
            exit();
        } elseif ($status === 'Accepted') {
            $stmt->close();
            header("Location: currently_reserved.php?error=already_approved");
            exit();
        } elseif ($status === 'Rejected') {
            // Allow re-submission if previously rejected
            $stmt->close();
            $deleteSql = "DELETE FROM olms.reservation WHERE RollNo = ? AND BookId = ?";
            $stmt = $conn->prepare($deleteSql);
            $stmt->bind_param("si", $rollNo, $bookId);
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt->close();
            header("Location: currently_reserved.php?error=unknown_status");
            exit();
        }
    } 
    $stmt->close();

    // Reserve the book with 'Pending' status and PDF locked (UnlockPDF = 0)
    $reserveSql = "INSERT INTO olms.reservation (RollNo, BookId, Status, UnlockPDF) VALUES (?, ?, 'Pending', 0)";
    $stmt = $conn->prepare($reserveSql);
    $stmt->bind_param("si", $rollNo, $bookId);

    if ($stmt->execute()) {
        header("Location: currently_reserved.php?success=reserved");
    } else {
        header("Location: books_details.php?BookId=$bookId&error=reservation_failed");
    }

    $stmt->close();
} else {
    header("Location: all_books.php?error=invalid_request");
}

$conn->close();
?>
