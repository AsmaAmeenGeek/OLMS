<?php
require('dbconn.php'); //connect the database connection file

if (!isset($_SESSION['RollNo'])) { // check if the user is logged in by verifying if the session variable 'RollNo' exists
  header("Location: index.php");  // if the 'RollNo' is not set, redirect the user to the login page (index.php)
  exit();
}

$rollno = $_SESSION['RollNo']; // retrieve the RollNo from the session

$userQuery = "SELECT * FROM olms.user WHERE RollNo=?"; // SQL query to fetch user details from the user table where the RollNo matches
$userStmt = $conn->prepare($userQuery); // prepare the SQL query to prevent SQL injection attacks
$userStmt->bind_param("s", $rollno); // bind the RollNo to the prepared statement as a string parameter
$userStmt->execute(); //execute the query
$userResult = $userStmt->get_result(); // get the result

if ($userResult && $userResult->num_rows > 0) { // checking if a matching user is found
  $userRow = $userResult->fetch_assoc(); // Fetch the user data
  $ProfilePicture = !empty($userRow['ProfilePicture']) ? $userRow['ProfilePicture'] : 'images/profile.jpg'; // check if the user has uploaded a profile pic if not set the defailt profile pic
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
  <title>Dashboard</title>
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
      <img src="<?php echo ($ProfilePicture); ?>" alt="Profile Picture" class="profile" id="profilePic" />
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

  <!-- Main Section -->
  <section class="home_content">
    <!-- Banner -->
    <img src="images/bg.jpg" class="banner"></div>

    <!-- About Section -->
    <div class="about-library">
      <h2>Welcome to the Million Library Admin Portal!</h2>
      <p>As the backbone of our library management system, you play a crucial
        role in maintaining smooth operations and ensuring a seamless
        experience for our users. From managing book inventories and handling
        user requests to overseeing reservations and renewals, this platform
        puts everything you need at your fingertips. Our system is designed
        to simplify administrative tasks, allowing you to focus on what
        matters most—enhancing the library experience. We’re thrilled to
        have you as part of our team, working together to foster a vibrant,
        accessible library for everyone. Let's keep the world of books running
        efficiently and effectively!</p>
    </div>
  </section>
  </div>


  <p class="site-name">&copy; 2024 Million Library. All rights reserved.</p>

  <script src="script.js"></script>
</body>

</html>