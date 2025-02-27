<?php
require('dbconn.php');

// Check if 'RollNo' is passed through GET
if (isset($_GET['RollNo'])) {
    $rollNo = $_GET['RollNo'];

    // SQL query to delete the student from the database
    $sql = "DELETE FROM olms.user WHERE RollNo = '$rollNo'";

    // Execute the query and check if the deletion is successful
    if ($conn->query($sql) === TRUE) {
        // Redirect to the manage student page with a success message
        header("Location: admin_manageStud.php?message=Student removed successfully");
    } else {
        // Redirect to the manage student page with an error message
        header("Location: admin_manageStud.php?message=Error removing student");
    }
}
?>


<?php
if (isset($_GET['message'])) {
    echo "<script>alert('".$_GET['message']."');</script>";
}
?>