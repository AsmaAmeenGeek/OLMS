<?php
// Include database connection
require('dbconn.php');

// Check if user is logged in
if (isset($_SESSION['RollNo'])) {

  // Handle message submission
  if (isset($_POST['submit'])) {
    $receiver = $_POST['rollNumber'];
    $message = $_POST['message'];
    // Set category with default value as 'general'
    $category = isset($_POST['category']) && in_array($_POST['category'], ['general', 'due']) ? $_POST['category'] : 'general';

     // Insert message using prepared statement for security
    $sql = $conn->prepare("INSERT INTO message (Sender, Receiver, Message, Date, Time, Category) VALUES ('admin', ?, ?, CURDATE(), CURTIME(), ?)");
    $sql->bind_param("sss", $receiver, $message, $category);
    $sql->execute();  // Execute once

    // Check if the message was inserted successfully
    if ($sql->affected_rows > 0) {  
      header("Location: message.php");
      exit();
    } else {
      echo "<script>alert('Error: Message not sent!');</script>";
    }
  }

  // Handle message deletion
  if (isset($_GET['delete'])) {
    $message_id = $_GET['delete'];
    $delete_sql = $conn->prepare("DELETE FROM message WHERE Message_id = ?");
    $delete_sql->bind_param("i", $message_id);
    // Show appropriate message for deletion success/failure
    if ($delete_sql->execute()) {
      echo "<script>alert('Message deleted successfully!');</script>";
    } else {
      echo "<script>alert('Error deleting message!');</script>";
    }
  }

  // Fetch user profile picture
  $rollno = $_SESSION['RollNo'];

  $userQuery = "SELECT * FROM olms.user WHERE RollNo=?";
  $userStmt = $conn->prepare($userQuery);
  $userStmt->bind_param("s", $rollno);
  $userStmt->execute();
  $userResult = $userStmt->get_result();

  // Set default profile picture if not found
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
    <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
    <title>Message</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <img src="images/logo.jpg" alt="">MillionOLMS
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
          <!-- Links to various sections -->
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

    <!-- Message form -->
    <div class="message-box">
      <h2>Send a Message
        <a href="message_list.php" class="list_icon">
          <i class='bx bx-list-ul'></i>
        </a>
      </h2>
      <form method="POST">
        <label for="rollNumber">Receiver Roll Number:</label>
        <input type="text" id="rollNumber" name="rollNumber" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <label for="category">Category:</label>
        <div class="category-container">
          <select id="category" name="category">
            <option value="general">General</option>
            <option value="due">Due</option>
          </select>
        </div>

        <button type="submit" name="submit" class="send-btn">Send</button>
      </form>

    </div>

    <script src="script.js"></script>
  </body>

  </html>

  <?php
} else {
  echo "<script>alert('Access Denied!'); window.location.href='home.php';</script>";
}
?>