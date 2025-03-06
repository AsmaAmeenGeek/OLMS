<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
  header("Location: index.php");
  exit();
}

// Handle approve or reject actions
if (isset($_GET['action']) && isset($_GET['id'])) {
  $requestId = intval($_GET['id']);
  $action = $_GET['action'];

  if ($action == 'approve') {
    // Fetch book details and update issue period
    $query = "SELECT * FROM olms.renew WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
      $bookId = $row['BookId'];
      $rollNo = $row['RollNo'];

      // Update issue date and due date (assuming a 14-day renewal period)
      $updateQuery = "UPDATE olms.issue SET IssueDate = CURDATE(), DueDate = DATE_ADD(CURDATE(), INTERVAL 14 DAY) WHERE BookId = ? AND RollNo = ?";
      $stmt = $conn->prepare($updateQuery);
      $stmt->bind_param("is", $bookId, $rollNo);
      $stmt->execute();

      // Delete request after approval
      $deleteQuery = "DELETE FROM olms.renew WHERE id = ?";
      $stmt = $conn->prepare($deleteQuery);
      $stmt->bind_param("i", $requestId);
      $stmt->execute();

      echo "<script>alert('Renewal Approved'); window.location.href='admin_renew_requests.php';</script>";
    }
  } elseif ($action == 'reject') {
    // Delete request if rejected
    $deleteQuery = "DELETE FROM olms.renew WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();

    echo "<script>alert('Renewal Rejected'); window.location.href='admin_renew_requests.php';</script>";
  }
}

// Fetch all pending renewal requests
$query = "SELECT r.id, r.BookId, r.RollNo, b.Title 
          FROM olms.renew r
          JOIN olms.book b ON r.BookId = b.BookId";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Fetch profile change
$rollno = $_SESSION['RollNo'];
$sql = "SELECT * FROM olms.user WHERE RollNo='$rollno'";
$result_profile = $conn->query($sql); // Use a different variable

if ($result_profile && $result_profile->num_rows > 0) {
  $row_profile = $result_profile->fetch_assoc();
  $name = $row_profile['Name'];
  $email = $row_profile['EmailId'];
  $mobno = $row_profile['MobNo'];
  $ProfilePicture = !empty($row_profile['ProfilePicture']) ? $row_profile['ProfilePicture'] : 'images/default.jpg';
} else {
  echo "<p>Error: No user found with Roll No: $rollno</p>";
  $name = $email = $mobno = "N/A";
  $ProfilePicture = 'images/default.jpg';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
  <title>renew</title>
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
    <table border="1">
      <tr>
        <th>Request ID</th>
        <th>Book ID</th>
        <th>Book Title</th>
        <th>User Roll No</th>
        <th>Action</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['BookId']; ?></td>
          <td><?php echo $row['Title']; ?></td>
          <td><?php echo $row['RollNo']; ?></td>
          <td>
            <a href="admin_renew_requests.php?action=approve&id=<?php echo $row['id']; ?>" class="table_btn">Approve</a>
            <a href="admin_renew_requests.php?action=reject&id=<?php echo $row['id']; ?>" class="table_btn">Reject</a>
          </td>
        </tr>
      <?php } ?>
    </table>
  </main>
</body>

</html>