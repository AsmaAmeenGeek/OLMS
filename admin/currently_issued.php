<?php
include 'dbconn.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rollno = $_SESSION['RollNo']; // Get logged-in user's RollNo

// Fetch approved reserved books for the logged-in user
$query = "SELECT r.RollNo, r.BookId, b.Title AS BookName, r.Date_Reserved AS AcceptDate, 
                 DATE_ADD(r.Date_Reserved, INTERVAL 14 DAY) AS DueDate
          FROM olms.reservation r
          JOIN olms.book b ON r.BookId = b.BookId
          WHERE r.RollNo = ? AND r.Status = 'Approved'"; 

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $rollno);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
    <title>currently reserved page</title>
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
