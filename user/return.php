<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['bookid'])) {
    $bookid = intval($_GET['bookid']); // Convert to integer for security
    $rollno = $_SESSION['RollNo'];

    // Check if the book is issued to the user and hasn't been returned yet
    $checkQuery = "SELECT * FROM olms.record WHERE BookId = ? AND RollNo = ? AND Date_Return IS NULL";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("is", $bookid, $rollno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Book is issued, handle the return process
        $insertReturnQuery = "INSERT INTO olms.return (RollNo, BookId, Date_Returned) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertReturnQuery);
        $returnDate = date('Y-m-d H:i:s'); // Get current date and time

        $stmt->bind_param("sis", $rollno, $bookid, $returnDate);

        if ($stmt->execute()) {
            // Book returned successfully, now update the status in the `record` table
            $updateRecordQuery = "UPDATE olms.record SET Date_Return = ? WHERE BookId = ? AND RollNo = ? AND Date_Return IS NULL";
            $stmt = $conn->prepare($updateRecordQuery);
            $stmt->bind_param("sis", $returnDate, $bookid, $rollno);

            if ($stmt->execute()) {
                echo "<script type='text/javascript'>
                        alert('Book returned successfully!');
                        window.location.href='pre_borrowed_book.php';
                      </script>";
            } else {
                echo "<script type='text/javascript'>
                        alert('Error updating record! Try again.');
                        window.location.href='pre_borrowed_book.php';
                      </script>";
            }
        } else {
            echo "<script type='text/javascript'>
                    alert('Error inserting return record! Try again.');
                    window.location.href='pre_borrowed_book.php';
                  </script>";
        }
    } else {
        echo "<script type='text/javascript'>
                alert('No active record found for this book under your account!');
                window.location.href='pre_borrowed_book.php';
              </script>";
    }
} else {
    echo "<script type='text/javascript'>
            alert('Invalid Request!');
            window.location.href='pre_borrowed_book.php';
          </script>";
}
?>
