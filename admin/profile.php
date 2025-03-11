<?php
require('dbconn.php'); //connect the database connection file

if (!isset($_SESSION['RollNo'])) { // check if the user is logged in by verifying if the session variable 'RollNo' exists
  header("Location: index.php");
  exit();
}

$rollno = $_SESSION['RollNo'];
$sql = "SELECT * FROM olms.user WHERE RollNo='$rollno'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $name = $row['Name']; //store user details in a variabl
  $email = $row['EmailId']; //""
  $mobno = $row['MobNo'];//""
  $ProfilePicture = !empty($row['ProfilePicture']) ? $row['ProfilePicture'] : 'images/profile.jpg';
} else {
  echo "<p>Error: No user found with Roll No: $rollno</p>";
  $name = $category = $email = $mobno = "N/A"; // assign null values if user not found
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
  <title>Profile</title>
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


  <!-- Profile Page -->
  <div class="profile_page">
    <div class="profile_box">
      <img src="<?php echo htmlspecialchars($ProfilePicture) . '?' . time(); ?>" alt="User Image"
        class="profile_image1" /> <!-- htmlspecialchars for prevent Xss attacks mean cross site scripting -->
      <h2 class="profile_name">
        <center><?php echo htmlspecialchars($name); ?></center>
      </h2>
      <p class="profile_email"><b>Email ID: </b><?php echo htmlspecialchars($email); ?></p>
      <p class="profile_mobileNumber"><b>Mobile Number: </b><?php echo htmlspecialchars($mobno); ?></p>
      <a href="editProfile.php" class="btn">Edit Details</a>
    </div>
  </div>




  <script src="script.js"></script>
</body>

</html>