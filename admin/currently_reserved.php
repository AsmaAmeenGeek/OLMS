<?php
// Connect to the database
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password (empty)
$dbname = "olms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch currently reserved books
$sql = "SELECT ar.RollNo, ar.BookId, b.Title AS BookName, ar.AcceptDate, 
        DATE_ADD(ar.AcceptDate, INTERVAL 14 DAY) AS DueDate 
        FROM accepted_reservations ar 
        JOIN book b ON ar.BookId = b.BookId";

$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Currently Reserved Books</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <img src="images/logo.jpg" alt="">MillionOLMS
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

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="menu_content">
            <ul class="menu_items">
                <li class="item"><a href="home.html" class="nav_link"><i class="bx bx-home-alt"></i> Home</a></li>
                <li class="item"><a href="profile.php" class="nav_link"><i class='bx bx-user-circle'></i> My Profile</a></li>
                <li class="item"><a href="message.php" class="nav_link"><i class='bx bx-chat'></i> Messages</a></li>
                <li class="item"><a href="all_books.php" class="nav_link"><i class='bx bx-book'></i> All Books</a></li>
                <li class="item"><a href="pre_borrowed_book.php" class="nav_link"><i class='bx bx-book'></i> Previously Borrowed Books</a></li>
                <li class="item"><a href="currently_reserved.html" class="nav_link"><i class='bx bxs-edit'></i> Currently Reserved Books</a></li>
                <li class="item"><a href="logout.php" class="nav_link"><i class='bx bx-log-out-circle'></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <div class="search-bar">
            <label for="search">Search:</label>
            <input type="text" id="search" placeholder="Enter Name / ID of Book">
            <button type="button">Search</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Roll No</th>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Issued Date</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['RollNo']}</td>
                                <td>{$row['BookId']}</td>
                                <td>{$row['BookName']}</td>
                                <td>{$row['AcceptDate']}</td>
                                <td>{$row['DueDate']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No currently reserved books</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <div class="footer-content">
            <div>
                <h3>Million Library</h3>
                <p>OLMS</p>
            </div>
            <div>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Terms and Conditions</a></li>
                </ul>
            </div>
            <div>
                <ul>
                    <li><a href="#">Plans</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>
</html>
