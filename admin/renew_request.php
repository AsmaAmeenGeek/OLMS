<?php
include 'dbconn.php'; // Include your database connection file

// Handle approve or reject renewal request
if (isset($_GET['action']) && isset($_GET['id'])) {
    $requestId = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'approve') {
        // Fetch renewal request details
        $query = "SELECT BookId, RollNo FROM renew WHERE id = '$requestId'";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            $bookId = $row['BookId'];
            $rollNo = $row['RollNo'];

            // Update issue table with new issue date and due date
            $issueDate = date('Y-m-d');
            $dueDate = date('Y-m-d', strtotime('+14 days')); // Set new due date (14 days after issue)

            $updateQuery = "UPDATE record SET Date_Issue = '$issueDate', DueDate = '$dueDate' 
                            WHERE RollNo = '$rollNo' AND BookId = '$bookId' AND Date_Return IS NULL";
            if (mysqli_query($conn, $updateQuery)) {
                // Delete the renewal request after approval
                $deleteQuery = "DELETE FROM renew WHERE id = '$requestId'";
                mysqli_query($conn, $deleteQuery);
                // Redirect to currently_issued.php after success
                echo "<script>alert('Renewal Approved'); window.location.href='currently_issued.php';</script>";
                exit(); // Ensure no further code is executed
            } else {
                echo "<script>alert('Error updating record!');</script>";
            }
        }
    } elseif ($action == 'reject') {
        // Reject the renewal request (delete the request)
        $deleteQuery = "DELETE FROM renew WHERE id = '$requestId'";
        mysqli_query($conn, $deleteQuery);
        echo "<script>alert('Renewal Rejected'); window.location.href='renew_request.php';</script>";
    }
}

// Fetch all pending renewal requests
$query = "SELECT r.id, r.BookId, r.RollNo, b.Title 
          FROM renew r
          JOIN book b ON r.BookId = b.BookId";
$result = mysqli_query($conn, $query);

// Fetch user profile efficiently
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
    <title>Renewal Requests</title>
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
    <h2>Renewal Requests</h2>
    <table>
        <tr>
            <th>Request ID</th>
            <th>Book ID</th>
            <th>Book Title</th>
            <th>User Roll No</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
        <td><?php echo $row['RollNo']; ?></td>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['BookId']; ?></td>
            <td><?php echo $row['Title']; ?></td>
            
            <td>
                <a href="renew_request.php?action=approve&id=<?php echo $row['id']; ?>">
                    <button type="button">Approve</button>
                </a>
                <a href="renew_request.php?action=reject&id=<?php echo $row['id']; ?>">
                    <button type="button" class="reject">Reject</button>
                </a>
            </td>
        </tr>
        <?php } ?>
    </table><br>
    <a href="requests.php" class="table_btn">Back</a>
    </main>
</body>
</html>