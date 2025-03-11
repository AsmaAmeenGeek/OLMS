<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT r.RollNo AS UserID, r.BookId, b.Title AS BookName, r.Date_Reserved AS IssuedDate 
          FROM reservation r 
          JOIN book b ON r.BookId = b.BookId 
          WHERE r.Status = 'Approved'";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}


$rollno = $_SESSION['RollNo'];
$userQuery = "SELECT ProfilePicture FROM olms.user WHERE RollNo = ?";
$userStmt = $conn->prepare($userQuery);
if ($userStmt) {
    $userStmt->bind_param("s", $rollno);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $userRow = $userResult->fetch_assoc();
    $ProfilePicture = !empty($userRow['ProfilePicture']) ? htmlspecialchars($userRow['ProfilePicture']) : 'images/profile.jpg';
} else {
    $ProfilePicture = 'images/profile.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
    <title>Issued Books</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
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
            <img src="<?php echo ($ProfilePicture); ?>" alt="Profile Picture" class="profile" />
        </div>
    </nav>

    <!-- sidebar -->
    <nav class="sidebar">
        <div class="menu_content">
            <ul class="menu_items">
                <div class="menu_title menu_dahsboard"></div>
                <!-- start -->
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
                    <a href="admin_manageStud.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bxs-user-detail'></i>
                        </span>
                        <span class="navlink">Manage Students</span>
                    </a>
                </li>

                <li class="item">
                    <a href="admin_allBooks.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-book'></i>
                        </span>
                        <span class="navlink">All Books</span>
                    </a>
                </li>

                <li class="item">


                    <a href="addBook.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bxs-edit'></i>
                        </span>
                        <span class="navlink">Add Books</span>
                    </a>
                </li>

                <li class="item">
                    <a href="requests.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-right-indent'></i>
                        </span>
                        <span class="navlink">Reserve/Return<br>Requests</span>
                    </a>
                </li>

                <li class="item">
                    <a href="currently_issued.php" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-list-ul'></i>
                        </span>
                        <span class="navlink">Currently Issued<br>Books</span>
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

<body>

<main class="main-content">
<h2>Currently Issued Books</h2>
<table border="1">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Book ID</th>
            <th>Book Name</th>
            <th>Issued Date</th>
            <th>Return Date</th>
            <th>Overdue Fine (Rs.)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            // Splitting date and time
            $date_part = date('Y-m-d', strtotime($row['IssuedDate']));
            $time_part = date('H:i:s', strtotime($row['IssuedDate']));
            
            // Formatting issued date with added space
            $issued_date = $date_part . " &nbsp;&nbsp; " . $time_part;
            
            $return_date = date('Y-m-d', strtotime($row['IssuedDate'] . ' +14 days'));
            $current_date = date('Y-m-d');

            $due_fund = "-"; // Default value if not overdue
            $row_class = ""; 

            if ($current_date > $return_date) {
                $days_late = (strtotime($current_date) - strtotime($return_date)) / (60 * 60 * 24);
                $due_fund = 120 + ($days_late * 10);
                $row_class = "style='color: red; font-weight: bold;'"; // Highlighting overdue books
            }

            echo "<tr $row_class>
                    <td>{$row['UserID']}</td>
                    <td>{$row['BookId']}</td>
                    <td>{$row['BookName']}</td>
                    <td>{$issued_date}</td>
                    <td>{$return_date}</td>
                    <td>{$due_fund}</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

</main>



</body>
</html>