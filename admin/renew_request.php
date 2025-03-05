<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "olms";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch renewal requests
$query = "SELECT rr.RollNo, rr.BookId, b.Title, b.Availability 
          FROM renew_requests rr 
          JOIN book b ON rr.BookId = b.BookId 
          WHERE rr.status = 'pending'";
$result = mysqli_query($conn, $query);

// Handle accept/decline actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $action = $_POST['action'];
    
    if ($action == 'accept') {
        $update_query = "UPDATE renew_requests SET status = 'accepted' WHERE user_id = ? AND book_id = ?";
    } else {
        $update_query = "UPDATE renew_requests SET status = 'declined' WHERE user_id = ? AND book_id = ?";
    }
    
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $book_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: renew_request.php?success=" . ($action == 'accept' ? 'accepted' : 'declined'));
        exit();
    } else {
        echo "<script>alert('Error processing request.'); window.location.href='renew_request.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Renew Requests - OLMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <img src="images/logo.jpg" alt=""> MillionOLMS
        </div>
        <div class="search_bar">
            <input type="text" placeholder="Search">
        </div>
        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            <i class='bx bx-sun' id="darkLight"></i>
            <img src="images/profile.jpg" alt="" class="profile">
        </div>
    </nav>

    <nav class="sidebar">
        <div class="menu_content">
            <ul class="menu_items">
                <li class="item"><a href="home.html" class="nav_link"><i class="bx bx-home-alt"></i>Home</a></li>
                <li class="item"><a href="profile.php" class="nav_link"><i class='bx bx-user-circle'></i>My Profile</a></li>
                <li class="item"><a href="message.php" class="nav_link"><i class='bx bx-chat'></i>Messages</a></li>
                <li class="item"><a href="all_books.php" class="nav_link"><i class='bx bx-book'></i>All Books</a></li>
                <li class="item"><a href="pre_borrowed_book.php" class="nav_link"><i class='bx bx-book'></i>Previously Borrowed Books</a></li>
                <li class="item"><a href="currently_reserved.php" class="nav_link"><i class='bx bx-bookmark'></i>Currently Reserved</a></li>
                <li class="item"><a href="logout.php" class="nav_link"><i class='bx bx-log-out-circle'></i>Logout</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <div class="re-btn">
            <button onclick="window.location.href='reserve_request.php'">Reserve Request</button>
            <button style="background-color:bisque;">Renew Request</button>
            <button onclick="window.location.href='return_request.php'">Return Request</button>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <p style="color: green; text-align: center;">
                Renew request <?php echo $_GET['success']; ?> successfully.
            </p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Availability</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['bookname']); ?></td>
                    <td><?php echo htmlspecialchars($row['availability']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                            <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                            <button type="submit" name="action" value="accept" style="background-color: green; color: white;">Accept</button>
                            <button type="submit" name="action" value="decline" style="background-color: red; color: white;">Decline</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>

    <footer>
        <div class="footer-content">
            <h3>Million Library</h3>
            <p>OLMS</p>
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Terms and Conditions</a></li>
                <li><a href="#">Plans</a></li>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Help</a></li>
            </ul>
        </div>
    </footer>
    <p style="text-align: center;">&copy; 2024 Million Library. All rights reserved.</p>
    <script src="script.js"></script>
</body>
</html>
