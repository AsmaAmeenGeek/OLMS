<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    // Fetch the BookId associated with the reservation
    $bookQuery = "SELECT BookId FROM olms.reservation WHERE id = ?";
    $bookStmt = $conn->prepare($bookQuery);
    $bookStmt->bind_param("i", $id);
    $bookStmt->execute();
    $bookResult = $bookStmt->get_result();
    $bookRow = $bookResult->fetch_assoc();

    if (!$bookRow) {
        echo '<script>alert("Invalid Reservation ID!"); window.location.href="reserve_request.php";</script>';
        exit();
    }

    $bookId = $bookRow['BookId'];

    if ($action === 'approve') {
        // Update the reservation status to 'Approved'
        $sql = "UPDATE olms.reservation SET Status = 'Approved' WHERE id = ?";
        
        // Decrease book availability (if greater than 0)
        $updateAvailability = "UPDATE olms.book SET Availability = Availability - 1, Status = 'Reserved' 
                               WHERE BookId = ? AND Availability > 0";

        $message = "Reservations Approved Successfully!";
    } elseif ($action === 'cancel') {
        // Update the reservation status to 'Cancelled'
        $sql = "UPDATE olms.reservation SET Status = 'Cancelled' WHERE id = ?";
        
        // Ensure the book status remains 'Available' if it was reserved but not issued
        $updateAvailability = "UPDATE olms.book SET Status = 'Available' WHERE BookId = ?";

        $message = "Reservation Cancelled Successfully!";
    } else {
        echo '<script>alert("Invalid Action!"); window.location.href="reserve_request.php";</script>';
        exit();
    }

    // Execute the reservation status update
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Update book availability
        $stmtBook = $conn->prepare($updateAvailability);
        $stmtBook->bind_param("s", $bookId);
        if ($stmtBook->execute()) {
            $stmtBook->close();
        } else {
            die('Error updating book availability: ' . $conn->error);
        }

        // Success message
        echo '<script>alert("' . $message . '"); window.location.href="reserve_request.php";</script>';
    } else {
        echo '<script>alert("Error updating reservation!"); window.location.href="reserve_request.php";</script>';
    }

    // Close statements and connection
    $stmt->close();
    $conn->close();
} else {
    echo '<script>alert("Invalid Request!"); window.location.href="reserve_request.php";</script>';
    exit();
}
?>
