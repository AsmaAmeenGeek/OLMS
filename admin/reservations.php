<?php
session_start();
$dbservername = "127.0.0.1";
$dbusername = "root";
$dbpassword = "";
$dbname = "olms";

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch reservations
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT r.id, r.RollNo, b.BookId, b.Title, b.Availability 
            FROM reservation r
            JOIN book b ON r.BookId = b.BookId
            WHERE r.Status = 'Pending'";
    $result = $conn->query($sql);
    $reservations = [];

    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}

// Accept reservation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accept'])) {
    $reservationId = $_POST['id'];
    $rollNo = $_POST['rollNo'];
    $bookId = $_POST['bookId'];

    // Insert into accepted reservations table
    $insertSql = "INSERT INTO accepted_reservations (RollNo, BookId) VALUES ('$rollNo', '$bookId')";
    $conn->query($insertSql);

    // Update reservation status
    $updateSql = "UPDATE reservation SET Status = 'Approved' WHERE id = '$reservationId'";
    $conn->query($updateSql);

    header("Location: reservations.php"); // Refresh page
}

// Decline reservation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['decline'])) {
    $reservationId = $_POST['id'];

    // Update reservation status to Cancelled
    $updateSql = "UPDATE reservation SET Status = 'Cancelled' WHERE id = '$reservationId'";
    $conn->query($updateSql);

    header("Location: reservations.php"); // Refresh page
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>OLMS</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <img src="images/logo.jpg" alt="">MillionOLMS
        </div>
        <div class="search_bar">
            <input type="text" placeholder="Search" />
        </div>
        <div class="navbar_content">
            <i class='bx bx-sun' id="darkLight"></i>
            <img src="images/profile.jpg" alt="" class="profile" />
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

    <!-- Main Content -->
    <main class="main-content">
        <div class="re-btn">
            <button style="background-color:bisque;">Reserve Request</button>
            <button>Renew Request</button>
            <button>Return Request</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Availability</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($reservations as $reservation) {
                    echo "<tr>
                        <td>{$count}</td>
                        <td>{$reservation['BookId']}</td>
                        <td>{$reservation['Title']}</td>
                        <td>{$reservation['Availability']}</td>
                        <td>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='{$reservation['id']}'>
                                <input type='hidden' name='rollNo' value='{$reservation['RollNo']}'>
                                <input type='hidden' name='bookId' value='{$reservation['BookId']}'>
                                <button type='submit' name='accept'>Accept</button>
                            </form>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='{$reservation['id']}'>
                                <button type='submit' name='decline'>Decline</button>
                            </form>
                        </td>
                    </tr>";
                    $count++;
                }
                ?>
            </tbody>
        </table>
    </main>

    <!-- Footer -->
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

    <p style="margin-left: 690px; margin-top: 20px;">&copy; 2024 Million Library. All rights reserved.</p>
</body>

</html>
