<?php
include 'dbconn.php';

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['RollNo']; // Get the user ID from the session

if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Prepare the SQL statement to delete the reservation
    $query = "DELETE FROM reservation WHERE id = ? AND RollNo = ?"; // Ensure the user owns the reservation
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("is", $reservation_id, $user_id);
    $stmt->execute();

    if ($stmt->error) {
        die("Execute Error: " . $stmt->error);
    }

    // Check if the reservation was deleted
    if ($stmt->affected_rows > 0) {
        // Successfully canceled the reservation
        echo "<script>alert('Reservation canceled successfully.');</script>";
    } else {
        // Reservation not found or not owned by the user
        echo "<script>alert('No reservation found or you do not have permission to cancel this reservation.');</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request.');</script>";
}

// Redirect back to currently reserved books page
header("Location: currently_reserved.php");
exit();
