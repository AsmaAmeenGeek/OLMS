<?php
require('dbconn.php');

if ($_SESSION['RollNo']) {
  // Handle delete request
  if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM message WHERE Message_id = $id";
    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Message deleted successfully!'); window.location.href='message_list.php';</script>";
    } else {
      echo "<script>alert('Error deleting message: " . $conn->error . "');</script>";
    }
  }

  // Handle update request
  if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $updatedMessage = $conn->real_escape_string($_POST['updatedMessage']);

    $sql = "UPDATE message SET Message = '$updatedMessage' WHERE Message_id = $id";
    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Message updated successfully!'); window.location.href='message_list.php';</script>";
    } else {
      echo "<script>alert('Error updating message: " . $conn->error . "');</script>";
    }
  }

  $rollno = $_SESSION['RollNo'];

  $userQuery = "SELECT * FROM olms.user WHERE RollNo=?";
  $userStmt = $conn->prepare($userQuery);
  $userStmt->bind_param("s", $rollno);
  $userStmt->execute();
  $userResult = $userStmt->get_result();

  if ($userResult && $userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $ProfilePicture = !empty($userRow['ProfilePicture']) ? $userRow['ProfilePicture'] : 'images/profile.jpg';
  } else {
    $ProfilePicture = 'images/profile.jpg';
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>Message History</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <img src="images/logo.jpg" alt=""></i>MillionOLMS
      </div>

      <div class="navbar_content">
        <i class="bi bi-grid"></i>
        <i class='bx bx-sun' id="darkLight"></i>
        <img src="<?php echo ($ProfilePicture); ?>" alt="Profile Picture" class="profile"  id="profilePic" />
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

    <div class="main-content">
      <h2>Message List</h2>
      <table border="1">
        <thead>
          <tr>
            <th>Roll Number</th>
            <th>Message</th>
            <th>Date</th>
            <th>Time</th>
            <th>Category</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM message ORDER BY Date DESC, Time DESC";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $categoryClass = ($row['Category'] === 'due') ? 'due-message' : 'general-message';
              echo "<tr>
                            <td>{$row['Receiver']}</td>
                            <td id='message_{$row['Message_id']}'>{$row['Message']}</td>
                            <td>{$row['Date']}</td>
                            <td>{$row['Time']}</td>
                            <td class='{$categoryClass}'>" . ucfirst($row['Category']) . "</td>
                            <td>
                                <button class='edit-btn' onclick='editMessage({$row['Message_id']})'>Update</button>
                                <a href='message_list.php?delete={$row['Message_id']}' onclick='return confirm(\"Are you sure you want to delete this message?\")'>
                                    <button class='delete-btn'>Delete</button>
                                </a>
                            </td>
                          </tr>";
            }

          } else {
            echo "<tr><td colspan='5'>No messages found.</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <a href="message.php" class="table_btn">Back</a>
    </div>
    <script src="script.js"></script>
  </body>

  </html>

  <?php
} else {
  echo "<script>alert('Access Denied!!!'); window.location.href='index.php';</script>";
}
?>