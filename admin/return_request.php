<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

// Handle approve or reject actions
if (isset($_GET['action']) && isset($_GET['id']) && in_array($_GET['action'], ['approve', 'reject'])) {
    $requestId = intval($_GET['id']);
    $action = $_GET['action'];

    $status = ($action == 'approve') ? 'Accepted' : 'Declined';

    $updateQuery = "UPDATE olms.requests SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $status, $requestId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Book Return " . ucfirst($action) . " Successfully!";
    } else {
        $_SESSION['message'] = "Error processing request!";
    }
    header("Location: return_request.php");
    exit();
}

// Fetch all pending return requests
$query = "SELECT id, book_id, book_name, user_id, status FROM olms.requests WHERE status = 'Pending'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Fetch profile
$rollno = $_SESSION['RollNo'];
$userQuery = "SELECT ProfilePicture FROM olms.user WHERE RollNo=?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("s", $rollno);
$userStmt->execute();
$userResult = $userStmt->get_result();
$ProfilePicture = ($userResult->num_rows > 0) ? $userResult->fetch_assoc()['ProfilePicture'] : 'images/profile.jpg';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
    <title>requests</title>
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

    <main class="main-content">
        <h2>Return Requests</h2>

        <?php if (isset($_SESSION['message'])) { ?>
            <p style="color: green;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php } ?>

        <table border="1">
            <tr>
                <th>Request ID</th>
                <th>Book ID</th>
                <th>Book Name</th>
                <th>User ID</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <button onclick="confirmAction('approve', <?php echo $row['id']; ?>)">Approve</button>
                        <button onclick="confirmAction('reject', <?php echo $row['id']; ?>)">Reject</button>
                    </td>
                </tr>
            <?php } ?>
        </table><br>

        <a href="requests.php" class="table_btn">Back</a>
    </main>
</body>

</html>
