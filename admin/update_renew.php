<?php
// Start the session to manage user messages and authentication
session_start();
require('dbconn.php'); // Include the database connection file

// Check if an action is provided (either accept or reject)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $requestId = $_GET['id'];

    // Validate the 'action' to ensure it's either 'accept' or 'reject'
    if (!in_array($action, ['accept', 'reject'])) {
        $_SESSION['message'] = "Invalid action!";
        $_SESSION['message_type'] = 'error';
        header("Location: renew_request.php");
        exit();
    }

    // Validate that the ID is an integer
    if (!filter_var($requestId, FILTER_VALIDATE_INT)) {
        $_SESSION['message'] = "Invalid request ID!";
        $_SESSION['message_type'] = 'error';
        header("Location: renew_request.php");
        exit();
    }

    try {
        // Get the book ID and RollNo associated with this renew request
        $query = "SELECT BookId, RollNo FROM olms.`renew` WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        // Check if the renew request exists
        if (!$row) {
            $_SESSION['message'] = "renew request not found!";
            $_SESSION['message_type'] = 'error';
            header("Location: renew_request.php");
            exit();
        }

        $bookId = $row['BookId'];
        $rollNo = $row['RollNo'];

        // Process the 'accept' action
        if ($action == 'accept') {
            // Update the renew request status to 'Accepted'
            $updateQuery = "UPDATE olms.`renew` SET status = 'Accepted' WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("i", $requestId);
            $stmt->execute();
            $stmt->close();

            // Increase the book's availability by 1
            $updateBookQuery = "UPDATE olms.book SET Availability = Availability - 1 WHERE BookId = ?";
            $stmt = $conn->prepare($updateBookQuery);
            $stmt->bind_param("i", $bookId);
            $stmt->execute();
            $stmt->close();

            // Update the record table to mark the book as renewed
            $updateRecordQuery = "UPDATE olms.record 
                                  SET Date_renew = CURDATE() 
                                  WHERE RollNo = ? AND BookId = ? AND Date_renew IS NULL";
            $stmt = $conn->prepare($updateRecordQuery);
            $stmt->bind_param("si", $rollNo, $bookId);
            $stmt->execute();
            $stmt->close();

            $_SESSION['message'] = "renew request accepted, book availability updated!";
            $_SESSION['message_type'] = 'success';
        } 
        // Process the 'reject' action
        elseif ($action == 'reject') {
            // Update the renew request status to 'Declined'
            $updateQuery = "UPDATE olms.`renew` SET status = 'Declined' WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("i", $requestId);
            $stmt->execute();
            $stmt->close();

            $_SESSION['message'] = "renew Request rejected!";
            $_SESSION['message_type'] = 'error';
        }

        // Redirect back to the renew request page after action is performed
        header("Location: renew_request.php");
        exit();
    } catch (Exception $e) {
        // Log the error and show a general error message
        error_log("Error executing query: " . $e->getMessage());
        // Display a generic error message for the user
        $_SESSION['message'] = "An error occurred while processing the request.";
        $_SESSION['message_type'] = 'error';
        header("Location: renew_request.php");
        exit();
    }
}
?>
