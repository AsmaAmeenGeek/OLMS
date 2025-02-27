<?php
require('dbconn.php');

if (isset($_GET['RollNo'])) {
    $rollNo = $_GET['RollNo'];

    // SQL Query
    $sql = "SELECT * FROM olms.user WHERE RollNo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $rollNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
            <title>OLMS</title>
            <link rel="stylesheet" href="style.css" />

            <script>
                // JavaScript function to confirm deletion
                function confirmDelete(rollNo) {
                    // Show confirmation popup
                    if (confirm("Do you really want to remove this student?")) {
                        // Redirect to the delete PHP script if clicks 'Yes'
                        window.location.href = 'deleteStudent.php?RollNo=' + rollNo;
                    } else {
                        // Do nothing if clicks 'Cancel'
                        return false;
                    }
                }
            </script>

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
                    <img src="images/profile.jpg" alt="" class="profile" />
                </div>
            </nav>

            <!-- sidebar -->
            <nav class="sidebar">
                <div class="menu_content">
                    <ul class="menu_items">
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
                            <a href="#" class="nav_link submenu_item">
                                <span class="navlink_icon">
                                    <i class='bx bx-right-indent'></i>
                                </span>
                                <span class="navlink">Reserve/Return<br>Requests</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="#" class="nav_link submenu_item">
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

            <!-- Student details Page -->
            <main class="main-content">
                <div class="content">
                    <div class="book-details">
                        <h1>Student Details</h1>
                        <?php
                        $x = $_GET['RollNo'];
                        $sql = "SELECT * FROM olms.user WHERE RollNo = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $x);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $rollNo = $row['RollNo'];
                            $name = $row['Name'];
                            $emailId = $row['EmailId'];
                            $mobNo = $row['MobNo'];

                            echo "<p><strong>Roll No:</strong> $rollNo</p>";
                            echo "<p><strong>Name:</strong> $name</p>";
                            echo "<p><strong>EmailId :</strong> $emailId</p>";
                            echo "<p><strong>MobNo:</strong> $mobNo</p>";
                        }
                        ?>
                        <div class="button-container">
                            <a href="admin_manageStud.php" class="btn-link">
                                <button class="go-back-btn">Go back</button>
                                <a href="javascript:void(0);" class="table_btn" onclick="confirmDelete('<?php echo $rollNo; ?>')">Remove Student</a>
                            </a>
                        </div>
                    </div>
                </div>
            </main>



            <script src="script.js"></script>
        </body>

        </html>

<?php
    } else {
        echo "Student not found.";
    }
} else {
    echo "No RollNo provided.";
}
