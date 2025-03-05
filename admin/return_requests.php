<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "olms");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve return requests from the database
$sql = "SELECT r.RequestId, u.RollNo, b.BookId, b.Title, b.Availability 
        FROM return_requests r
        JOIN user u ON r.RollNo = u.RollNo
        JOIN book b ON r.BookId = b.BookId";

$result = $conn->query($sql);
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
            <img src="images/logo.jpg" alt=""> MillionOLMS
        </div>
        <div class="search_bar">
            <input type="text" placeholder="Search" />
        </div>
        <div class="navbar_content">
            <i class="bi bi-grid"></i>
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

    <main class="main-content">
        <div class="re-btn">
            <button>Reserve Request</button>
            <button>Renew Request</button>
            <button style="background-color:bisque;">Return Request</button>
        </div>
        
        <!-- Dynamic Table -->
        <table>
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>User ID</th>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $serial = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$serial}</td>
                                <td>{$row['RollNo']}</td>
                                <td>{$row['BookId']}</td>
                                <td>{$row['Title']}</td>
                                <td>{$row['Availability']}</td>
                                <td>
                                    <form method='POST' action='handle_return.php'>
                                        <input type='hidden' name='request_id' value='{$row['RequestId']}'>
                                        <input type='hidden' name='book_id' value='{$row['BookId']}'>
                                        <button type='submit' name='accept'>Accept</button>
                                        <button type='submit' name='decline'>Decline</button>
                                    </form>
                                </td>
                              </tr>";
                        $serial++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No return requests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <div class="footer-content">
            <div><h3>Million Library</h3><p>OLMS</p></div>
            <div>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Terms and conditions</a></li>
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

    <p style="text-align: center;">&copy; 2024 Million Library. All rights reserved.</p>
</body>
</html>

<?php $conn->close(); ?>
