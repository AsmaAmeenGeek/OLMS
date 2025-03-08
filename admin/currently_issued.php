<?php
include 'dbconn.php'; // Ensure database connection is included

$rollno = $_SESSION['RollNo']; // Get logged-in user's RollNo

// Fetch issued, renewed, reserved (accepted), and return request accepted books
$query = "SELECT r.BookId, b.Title, r.Date_Issue, r.DueDate, r.Renew_left, r.Status 
          FROM olms.record r
          JOIN olms.book b ON r.BookId = b.BookId
          WHERE r.RollNo = ? 
          AND r.Date_Return IS NULL
          AND r.Status IN ('Issued', 'Renewed', 'Reserved_Accepted', 'Return_Accepted')"; 

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $rollno);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Currently Issued Books</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to CSS file -->
</head>
<body>

<h2>Currently Issued Books</h2>

<?php if ($result->num_rows > 0) { ?>
    <table border="1">
        <tr>
            <th>Book ID</th>
            <th>Title</th>
            <th>Date Issued</th>
            <th>Due Date</th>
            <th>Renewals Left</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['BookId']; ?></td>
                <td><?php echo $row['Title']; ?></td>
                <td><?php echo $row['Date_Issue']; ?></td>
                <td><?php echo $row['DueDate']; ?></td>
                <td><?php echo $row['Renew_left']; ?></td>
                <td><?php echo $row['Status']; ?></td>
                <td>
                    <?php if ($row['Status'] == 'Issued' || $row['Status'] == 'Renewed') { ?>
                        <?php if ($row['Renew_left'] > 0) { ?>
                            <form action="renew_request.php" method="POST">
                                <input type="hidden" name="BookId" value="<?php echo $row['BookId']; ?>">
                                <button type="submit" name="renew">Renew</button>
                            </form>
                        <?php } else { echo "No renewals left"; } ?>
                    <?php } elseif ($row['Status'] == 'Reserved_Accepted') { ?>
                        <button disabled>Reserved</button>
                    <?php } elseif ($row['Status'] == 'Return_Accepted') { ?>
                        <button disabled>Return Approved</button>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p>No books are currently issued.</p>
<?php } ?>

</body>
</html>
