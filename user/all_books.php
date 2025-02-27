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
    $ProfilePicture = !empty($userRow['ProfilePicture']) ? $userRow['ProfilePicture'] : 'images/default.jpg';
} else {
    $ProfilePicture = 'images/default.jpg'; // Default picture if none found
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>OLMS</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!-- navbar -->
    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <img src="images/logo.jpg" alt="">MillionOLMS
        </div>

        <div class="search_bar">
            <input type="text" placeholder="Search" />
        </div>

        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            <i class='bx bx-sun' id="darkLight"></i>
            <img src="<?php echo htmlspecialchars($ProfilePicture); ?>" alt="Profile Picture" class="profile" />
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
                            <i class='bx bx-book'></i>
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

    <main class="main-content">

        <form method="POST" action="">
            <div class="search-bar">
                <label for="search">Search:</label>
                <input type="text" id="search" name="title" placeholder="Enter Name / ID of Book">
                <button type="submit" name="submit">Search</button>
            </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $s = $_POST['title']; // Get the search term from the form
            $sql = "SELECT * FROM olms.book WHERE BookId='$s' OR Title LIKE '%$s%'";
        } else {
            // Default query to show all books ordered by BookId
            $sql = "SELECT * FROM olms.book ORDER BY BookId ASC";
        }

        $result = $conn->query($sql);
        $rowcount = mysqli_num_rows($result);

        if (!$rowcount) {
            echo "<br><center><h2><b><i>No Results</i></b></h2></center>";
        } else {
            // Display the search results in a table
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Book Name</th>
                        <th>Availability</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        $bookid = $row['BookId'];
                        $name = $row['Title'];
                        $avail = $row['Availability'];
                        ?>
                        <tr>
                            <td><?php echo $bookid ?></td>
                            <td><?php echo $name ?></td>
                            <td><b><?php
                            if ($avail > 0)
                                echo "<font color=\"green\">Available</font>";
                            else
                                echo "<font color=\"red\">Not Available</font>";
                            ?></b></td>
                            <td>
                                <center>
                                    <a href="books_details.php?BookId=<?php echo $bookid; ?>" class="table_btn">Details</a>
                                    <a href="reserve.php?BookId=<?= $bookid ?>" class="table_btn">Reserve book
                                    </a>
                                </center>
                            </td>
                        </tr>
                    <?php }
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