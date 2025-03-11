<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

$rollno = $_SESSION['RollNo'];

// Fetch user details for profile picture and other info
$userQuery = "SELECT * FROM olms.user WHERE RollNo=?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("s", $rollno);
$userStmt->execute();
$userResult = $userStmt->get_result();

if ($userResult && $userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $ProfilePicture = !empty($userRow['ProfilePicture']) ? $userRow['ProfilePicture'] : 'images/profile.jpg';
} else {
    $ProfilePicture = 'images/profile.jpg'; // Default picture if none found
}

// Fetch previously borrowed and reserved books
$query = "(SELECT record.BookId, book.Title, record.Date_Issue, record.Date_Return, 'Borrowed' AS Status
          FROM olms.record 
          JOIN olms.book ON book.Bookid = record.BookId 
          WHERE record.RollNo = ? AND record.Date_Issue IS NOT NULL AND record.Date_Return IS NOT NULL)
          UNION
          (SELECT reservation.BookId, book.Title, reservation.Date_Reserved AS Date_Issue, NULL AS Date_Return, reservation.Status
          FROM olms.reservation
          JOIN olms.book ON book.Bookid = reservation.BookId
          WHERE reservation.RollNo = ? AND reservation.Status IN ('Approved', 'Cancelled'))";

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $rollno, $rollno);
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
    <title>My Borrowing History</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!-- navbar -->
    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <img src="images/logo.jpg" alt="">MillionOLMS
        </div>

        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            <i class='bx bx-sun' id="darkLight"></i>
            <img src="<?php echo $ProfilePicture; ?>" alt="Profile Picture" class="profile" id="profilePic" />
            <div class="profile-dropdown" id="profileDropdown">
                <a href="profile.php">My Profile</a>
                <a href="logout.php">Logout</a>
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

    <main class="main-content">
        <h2>Previously Borrowed Books</h2>
        <table id="booksTable">
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Issued Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo ($row['BookId']); ?></td>
                            <td><?php echo ($row['Title']); ?></td>
                            <td><?php echo ($row['Date_Issue']); ?></td>
                            <td>
                                <?php
                                if ($row['Date_Return']) {
                                    echo $row['Date_Return'];
                                } else {
                                    $return_date = date('Y-m-d', strtotime($row['Date_Issue'] . ' +14 days'));
                                    echo $return_date;
                                }
                                ?>
                            </td>

                            <td><?php echo ($row['Status']); ?></td>
                            <td>
                                <a href="renew.php?bookid=<?php echo ($row['BookId']); ?>" class="table_btn">Renew</a>
                                <a href="return.php?bookid=<?php echo ($row['BookId']); ?>" class="table_btn">Return</a>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>No Borrowed Books Found</td></tr>";
                } ?>
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
                    <li><a href="Help.php">About Us</a></li>
                    <li><a href="Help.php">Contact Us</a></li>
                    <li><a href="Help.php">Terms and conditions</a></li>
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
    <script src="script.js"></script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>