<?php
session_start();
include 'dbconn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];  // Assuming user is logged in
    $book_id = $_POST['book_id'];

    // Check if the user has already requested renewal for this book
    $check_query = "SELECT * FROM renew_requests WHERE user_id = ? AND book_id = ? AND status = 'pending'";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $book_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "You have already requested renewal for this book.";
    } else {
        // Insert new renewal request
        $insert_query = "INSERT INTO renew_requests (user_id, book_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, 'ii', $user_id, $book_id);
        mysqli_stmt_execute($stmt);

        echo "Renewal request submitted successfully.";
    }
}
?>
