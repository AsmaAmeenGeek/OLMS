<?php
include 'dbconn.php';

if (!isset($_SESSION['RollNo'])) {
  header("Location: index.php");
  exit();
}

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

            // Update both Date_Issue and DueDate
            $updateQuery = "UPDATE record 
                            SET Date_Issue = CURDATE(), DueDate = DATE_ADD(CURDATE(), INTERVAL 14 DAY)
                            WHERE RollNo = '$rollNo' AND BookId = '$bookId' AND Date_Return IS NULL";

            if (mysqli_query($conn, $updateQuery)) {
                // Delete the renewal request after approval
                $deleteQuery = "DELETE FROM renew WHERE id = '$requestId'";
                mysqli_query($conn, $deleteQuery);

                echo "<script>alert('Renewal Approved'); window.location.href='currently_issued.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error updating renewal request!');</script>";
            }
        }
    } elseif ($action == 'reject') {
        // Reject the renewal request (delete it)
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
    <title>Renew Request</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav class="navbar">
    <div class="logo_item">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      <img src="images/logo.jpg" alt="">MillionOLMS
    </div>

    <div class="navbar_content">
      <i class="bi bi-grid"></i>
      <i class='bx bx-sun' id="darkLight"></i>
      <img src="<?php echo ($ProfilePicture); ?>" alt="Profile Picture" class="profile"   id="profilePic" />
                <div class="profile-dropdown" id="profileDropdown">
                    <a href="profile.php">My Profile</a>
                    <a href="logout.php">Logout</a>
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
                <th>Roll No</th>
                <th>Book ID</th>
                <th>Book Title</th>
                <th>Action</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['RollNo']; ?></td>
                    <td><?php echo $row['BookId']; ?></td>
                    <td><?php echo $row['Title']; ?></td>
                    <td>
                        <a href="renew_request.php?action=approve&id=<?php echo $row['id']; ?>"
                            class="table_btn">Approve</a>
                        <a href="renew_request.php?action=reject&id=<?php echo $row['id']; ?>" class="table_btn">Reject</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No pending renewals.</td>
                    </tr>
                <?php endif; ?>
        </table><br>
        <a href="requests.php" class="table_btn">Back</a>
    </main>
    <script src="script.js"></script>
</body>

</html>