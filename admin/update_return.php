<?php
session_start();
require('dbconn.php');

// Check if an action is provided (either accept or reject)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $requestId = $_GET['id'];

    // Validate the 'action' to ensure it's either 'accept' or 'reject'
    if (!in_array($action, ['accept', 'reject'])) {
        $_SESSION['message'] = "Invalid action!";
        $_SESSION['message_type'] = 'error';
        header("Location: return_request.php");
        exit();
    }

    // Validate that the ID is an integer
    if (!filter_var($requestId, FILTER_VALIDATE_INT)) {
        $_SESSION['message'] = "Invalid request ID!";
        $_SESSION['message_type'] = 'error';
        header("Location: return_request.php");
        exit();
    }

    try {
        // Get the book ID and RollNo associated with this return request
        $query = "SELECT BookId, RollNo FROM olms.`return` WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (!$row) {
            $_SESSION['message'] = "Return request not found!";
            $_SESSION['message_type'] = 'error';
            header("Location: return_request.php");
            exit();
        }

        $bookId = $row['BookId'];
        $rollNo = $row['RollNo'];

        if ($action == 'accept') {
            // Update the return request status to 'Accepted'
            $updateQuery = "UPDATE olms.`return` SET status = 'Accepted' WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("i", $requestId);
            $stmt->execute();
            $stmt->close();

            // Increase the book's availability by 1
            $updateBookQuery = "UPDATE olms.book SET Availability = Availability + 1 WHERE BookId = ?";
            $stmt = $conn->prepare($updateBookQuery);
            $stmt->bind_param("i", $bookId);
            $stmt->execute();
            $stmt->close();

            // Update the record table to mark the book as returned
            $updateRecordQuery = "UPDATE olms.record 
                                  SET Date_Return = CURDATE() 
                                  WHERE RollNo = ? AND BookId = ? AND Date_Return IS NULL";
            $stmt = $conn->prepare($updateRecordQuery);
            $stmt->bind_param("si", $rollNo, $bookId);
            $stmt->execute();
            $stmt->close();

            $_SESSION['message'] = "Return request accepted, book availability updated!";
            $_SESSION['message_type'] = 'success';
        } elseif ($action == 'reject') {
            // Update the return request status to 'Declined'
            $updateQuery = "UPDATE olms.`return` SET status = 'Declined' WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("i", $requestId);
            $stmt->execute();
            $stmt->close();

            $_SESSION['message'] = "Return Request rejected!";
            $_SESSION['message_type'] = 'error';
        }

        // Redirect back to the return request page after action is performed
        header("Location: return_request.php");
        exit();
    } catch (Exception $e) {
        // Log the error and show a general error message
        error_log("Error executing query: " . $e->getMessage());
        $_SESSION['message'] = "An error occurred while processing the request.";
        $_SESSION['message_type'] = 'error';
        header("Location: return_request.php");
        exit();
    }
}
?>
