<?php
require('dbconn.php');

// Check if user is logged in
if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

$rollno = $_SESSION['RollNo'];

// Fetch user details for profile picture
$userQuery = "SELECT * FROM olms.user WHERE RollNo = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("s", $rollno);
$userStmt->execute();
$userResult = $userStmt->get_result();

if ($userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $ProfilePicture = !empty($userRow['ProfilePicture']) ? $userRow['ProfilePicture'] : 'images/default.jpg';
} else {
    $ProfilePicture = 'images/default.jpg';
}

// Fetch due messages sent to the logged-in user
$sql = "SELECT * FROM olms.message WHERE Receiver = ? AND Category = 'due' ORDER BY Date DESC, Time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $rollno);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
    <title>OLMS</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!-- navbar -->
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
            <img src="<?php echo($ProfilePicture); ?>" alt="Profile Picture" class="profile" />
        </div>
    </nav>

    <!-- sidebar -->
    <nav class="sidebar">
        <div class="menu_content">
            <div class="menu_items">
                <div class="menu_title menu_dahsboard"></div>

                <li class="item">
                    <a href="home.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class="bx bx-home-alt"></i>
                        </span>
                        <span class="navlink">Home</span>
                    </a>
                </li>

                <li class="item">
                    <a href="profile.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-user-circle'></i>
                        </span>
                        <span class="navlink">My Profile</span>
                    </a>
                </li>

                <li class="item">
                    <a href="message.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-chat'></i>
                        </span>
                        <span class="navlink">Messages</span>
                    </a>
                </li>

                <li class="item">
                    <a href="all_books.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-book'></i>
                        </span>
                        <span class="navlink">All Books</span>
                    </a>
                </li>

                <li class="item">
                    <a href="pre_borrowed_book.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-book-add'></i> 
                        </span>
                        <span class="navlink">Previously Borrowed <br> Books</span>
                    </a>
                </li>

                <li class="item">
                    <a href="currently_reserved.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bxs-edit'></i>
                        </span>
                        <span class="navlink">Currently Reserved <br> Books</span>
                    </a>
                </li>

                <li class="item">
                    <a href="logout.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-log-out-circle'></i>
                        </span>
                        <span class="navlink">Logout</span>
                    </a>
                </li>

                </ul>

                <!-- Sidebar Open / Close -->
                <div class="bottom_content">
                    <div class="bottom expand_sidebar">
                        <span> Expand</span>
                        <i class='bx bx-log-in'></i>
                    </div>
                    <div class="bottom collapse_sidebar">
                        <span> Collapse</span>
                        <i class='bx bx-log-out'></i>
                    </div>
                </div>
            </div>
    </nav>

    <!-- Due Messages Content -->
    <main class="message_content">
        <section class="message-section">
            <h2>Due Messages</h2>

            <table class="message-table">
                <thead>
                    <tr>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo ($row['Message']); ?></td>
                                <td><?php echo ($row['Date']); ?></td>
                                <td><?php echo ($row['Time']); ?></td>
                                <td><?php echo ($row['Category']); ?></td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='4'>No due messages found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="message.php" class="table_btn">Back</a>
        </section>
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
                    <li><a href="Help.php">About Us</a></li>
                    <li><a href="Help.php">Contact Us</a></li>
                    <li><a href="Help.php">Terms and Conditions</a></li>
                </ul>
            </div>
            <div>
                <ul>
                    <li><a href="Help.php">Plans</a></li>
                    <li><a href="Help.php">FAQs</a></li>
                    <li><a href="Help.php">Help</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <p class="site-name">&copy; 2024 Million Library. All rights reserved.</p>

</body>

</html>