<?php
// Include database connection
require('dbconn.php');

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

// Check if 'action' and 'id' parameters are provided via GET request
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action']; // Get the action parameter (approve or cancel)
    $id = $_GET['id']; // Get the reservation ID

    // Fetch the BookId associated with the reservation
    $bookQuery = "SELECT BookId FROM olms.reservation WHERE id = ?";
    $bookStmt = $conn->prepare($bookQuery);
    $bookStmt->bind_param("i", $id);
    $bookStmt->execute();
    $bookResult = $bookStmt->get_result();
    $bookRow = $bookResult->fetch_assoc();

     // If no matching reservation found, alert and redirect
    if (!$bookRow) {
        echo '<script>alert("Invalid Reservation ID!"); window.location.href="reserve_request.php";</script>';
        exit();
    }
    // Extract BookId from the fetched data
    $bookId = $bookRow['BookId'];

    // Handle 'approve' and 'cancel' actions
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
        // Handle invalid actions
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

        // Show success message and redirect
        echo '<script>alert("' . $message . '"); window.location.href="reserve_request.php";</script>';
    } else {
        // Error message if reservation update fails
        echo '<script>alert("Error updating reservation!"); window.location.href="reserve_request.php";</script>';
    }

    // Close statements and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid requests (e.g., missing parameters)
    echo '<script>alert("Invalid Request!"); window.location.href="reserve_request.php";</script>';
    exit();
}
?>
