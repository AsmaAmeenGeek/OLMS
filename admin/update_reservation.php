<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    // Prepare the action based on the request
    if ($action === 'approve') {
        // Query to update the reservation status (Admin side)
        $sql = "UPDATE olms.reservation SET Status = 'Approved' WHERE id = ?";

        // Update the book status to 'Reserved' (Admin side)
        $updateBookStatus = "UPDATE olms.book SET Status = 'Reserved' WHERE BookId = (SELECT BookId FROM olms.reservation WHERE id = ?)";
        
        $message = "Reservation Approved Successfully!";
    } elseif ($action === 'cancel') {
        // Query to update the reservation status (Admin side)
        $sql = "UPDATE olms.reservation SET Status = 'Cancelled' WHERE id = ?";

        // Update the book status to 'Available' (Admin side)
        $updateBookStatus = "UPDATE olms.book SET Status = 'Available' WHERE BookId = (SELECT BookId FROM olms.reservation WHERE id = ?)";
        
        $message = "Reservation Cancelled Successfully!";
    } else {
        // Invalid action
        echo '<script>alert("Invalid Action!"); window.location.href="reserve_request.php";</script>';
        exit();
    }

    // Prepare the statement for updating the reservation status (Admin side)
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing query: ' . $conn->error);
    }

    // Bind the parameter (reservation ID)
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Update the book status
        if (isset($updateBookStatus)) {
            $stmtBook = $conn->prepare($updateBookStatus);
            if ($stmtBook === false) {
                die('Error preparing book status update: ' . $conn->error);
            }
            $stmtBook->bind_param("i", $id);
            if ($stmtBook->execute()) {
                $stmtBook->close();
            } else {
                die('Error updating book status: ' . $conn->error);
            }
        }

        // Alert the user with success message and reload the page
        echo '<script>alert("' . $message . '"); window.location.href="reserve_request.php";</script>';
    } else {
        // If the admin query fails
        echo '<script>alert("Error updating reservation!"); window.location.href="reserve_request.php";</script>';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Invalid request
    echo '<script>alert("Invalid Request!"); window.location.href="reserve_request.php";</script>';
    exit();
}
?>
