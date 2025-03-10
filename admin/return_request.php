<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

// Check if an action is provided (either accept or reject)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $requestId = $_GET['id'];

    if ($action == 'accept') {
        // Update the status to 'Accepted'
        $updateQuery = "UPDATE olms.`return` SET status = 'Accepted' WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $stmt->close();
        $_SESSION['message'] = "Return request accepted successfully!";
        $_SESSION['message_type'] = 'success'; // Optional: You can use this for styling (success or error)
    } elseif ($action == 'reject') {
        // Update the status to 'Declined'
        $updateQuery = "UPDATE olms.`return` SET status = 'Declined' WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $stmt->close();
        $_SESSION['message'] = "Return request rejected!";
        $_SESSION['message_type'] = 'error'; // Optional: You can use this for styling (success or error)
    }

    // Redirect back to the return request page after action is performed
    header("Location: return_request.php");
    exit();
}

// Fetch the return requests from the database
$query = "SELECT `return`.id, `return`.RollNo, `return`.BookId, `return`.Date_Returned, `return`.status, book.Title
          FROM olms.`return`
          JOIN olms.book AS book ON `return`.BookId = book.BookId
          ORDER BY `return`.id DESC";
$result = $conn->query($query);

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
    <title>Return Requests</title>
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


    <?php if (isset($_SESSION['message'])): ?>
        <script type="text/javascript">
            // Display the alert message
            alert("<?php echo $_SESSION['message']; ?>");
        </script>
        <?php 
        // Unset the message after displaying the alert to avoid it showing again
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        ?>
    <?php endif; ?>

    <main class="main-content">
    <h1>Return Requests</h1>
    <table>
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Roll No</th>
                <th>Book Title</th>
                <th>Date Returned</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['RollNo']; ?></td>
                    <td><?php echo $row['Title']; ?></td>
                    <td><?php echo $row['Date_Returned']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending'): ?>
                            <a href="update_return.php?action=accept&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to accept this request?')" class="table_btn">Accept</a>
                            <a href="update_return.php?action=reject&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to reject this request?')" class="table_btn">Reject</a>
                        <?php else: ?>
                            <span>Processed</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </main>
</body>
</html>
