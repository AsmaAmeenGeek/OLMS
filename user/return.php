<?php
require('dbconn.php');

// Ensure the user is logged in
if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

// Get the book ID from the URL parameter
if (isset($_GET['bookid'])) {
    $bookId = $_GET['bookid'];
    $userRollNo = $_SESSION['RollNo'];

    // Insert the return request into the database
    $insertQuery = "INSERT INTO olms.return (RollNo, BookId, status) VALUES (?, ?, 'Pending')";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("si", $userRollNo, $bookId);

    if ($insertStmt->execute()) {
        $_SESSION['message'] = "Return request submitted successfully!";
    } else {
        $_SESSION['message'] = "Error submitting return request.";
    }

    // Redirect back to the previously borrowed books page
    header("Location: pre_borrowed_book.php");
    exit();
} else {
    // If no book ID is passed
    $_SESSION['message'] = "No book selected for return.";
    header("Location: pre_borrowed_book.php");
    exit();
}
?>
