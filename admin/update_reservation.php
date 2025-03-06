<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action === 'approve') {
        $sql = "UPDATE olms.reservation SET Status = 'Approved' WHERE id = ?";
    } elseif ($action === 'cancel') {
        $sql = "UPDATE olms.reservation SET Status = 'Cancelled' WHERE id = ?";
    } else {
        header("Location: reserve_request.php?error=Invalid Action");
        exit();
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: reserve_request.php?success=Request Updated");
    } else {
        header("Location: reserve_request.php?error=Update Failed");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: reserve_request.php?error=Invalid Request");
    exit();
}
?>
