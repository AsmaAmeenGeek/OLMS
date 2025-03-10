<?php
require('dbconn.php');

// Check if an action is provided (either accept or reject)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $requestId = $_GET['id'];

    // Validate the 'action' to ensure it's either 'accept' or 'reject'
    if (!in_array($action, ['accept', 'reject'])) {
        // If the action is invalid, redirect with an error message
        $_SESSION['message'] = "Invalid action!";
        $_SESSION['message_type'] = 'error';
        header("Location: return_request.php");
        exit();
    }

    // Validate that the ID is an integer
    if (!filter_var($requestId, FILTER_VALIDATE_INT)) {
        // If the ID is not valid, redirect with an error message
        $_SESSION['message'] = "Invalid request ID!";
        $_SESSION['message_type'] = 'error';
        header("Location: return_request.php");
        exit();
    }

    try {
        if ($action == 'accept') {
            // Update the status to 'Accepted'
            $updateQuery = "UPDATE olms.`return` SET status = 'Accepted' WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("i", $requestId);
            $stmt->execute();
            $stmt->close();
            $_SESSION['message'] = "Return request accepted successfully!";
            $_SESSION['message_type'] = 'success';  // Optional: for styling success messages
        } elseif ($action == 'reject') {
            // Update the status to 'Declined'
            $updateQuery = "UPDATE olms.`return` SET status = 'Declined' WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("i", $requestId);
            $stmt->execute();
            $stmt->close();
            $_SESSION['message'] = "Return request rejected!";
            $_SESSION['message_type'] = 'error';  // Optional: for styling error messages
        }

        // Redirect back to the return request page after action is performed
        header("Location: return_request.php");
        exit();
    } catch (Exception $e) {
        // If an error occurs, log the error and show a general error message
        error_log("Error executing query: " . $e->getMessage());
        $_SESSION['message'] = "An error occurred while processing the request.";
        $_SESSION['message_type'] = 'error';
        header("Location: return_request.php");
        exit();
    }
}
?>
