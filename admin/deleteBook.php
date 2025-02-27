<?php
require('dbconn.php');

// Check if 'BookId' is passed through GET
if (isset($_GET['BookId'])) {
    $bookId = $_GET['BookId'];

    // SQL query to delete the book from the database
    $sql = "DELETE FROM olms.book WHERE BookId = '$bookId'";

    // Execute the query and check if the deletion is successful
    if ($conn->query($sql) === TRUE) {
        // Redirect to the all books page with a success message
        header("Location: admin_allBooks.php?message=Book deleted successfully");
    } else {
        // Redirect to the all books page with an error message
        header("Location: admin_allBooks.php?message=Error deleting book");
    }
}
?>


<?php
if (isset($_GET['message'])) {
    echo "<script>alert('".$_GET['message']."');</script>";
}
?>
