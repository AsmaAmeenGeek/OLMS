<?php
$conn = new mysqli("localhost", "root", "", "olms");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $book_id = $_POST['book_id'];

    if (isset($_POST['accept'])) {
        // Increase availability by 1
        $conn->query("UPDATE book SET Availability = Availability + 1 WHERE BookId = '$book_id'");
        // Remove return request
        $conn->query("DELETE FROM return_requests WHERE RequestId = '$request_id'");
        echo "<script>alert('Return request accepted!'); window.location.href='return_requests.php';</script>";
    }

    if (isset($_POST['decline'])) {
        // Simply remove request
        $conn->query("DELETE FROM return_requests WHERE RequestId = '$request_id'");
        echo "<script>alert('Return request declined!'); window.location.href='return_requests.php';</script>";
    }
}

$conn->close();
?>
