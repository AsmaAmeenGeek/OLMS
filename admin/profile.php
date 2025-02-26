<?php
require('dbconn.php');
?>

<?php
if ($_SESSION['RollNo']) {
  ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>OLMS</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <img src="images/logo.jpg" alt=""></i>MillionOLMS
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
          <div class="menu_title menu_dahsboard"></div>
          <!-- start -->
          <li class="item">
            <a href="home.html" class="nav_link submenu_item">
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
                <i class='bx bx-chat' ></i>
              </span>
              <span class="navlink">Messages</span>
            </a>
          </li>
          
           <li class="item">
            <a href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class='bx bxs-user-detail' ></i>
              </span>
              <span class="navlink">Manage Students</span>
            </a>
          </li>
          
           <li class="item">
            <a href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class='bx bx-book'></i>
              </span>
              <span class="navlink">All Books</span>
            </a>
          </li>
          
           <li class="item">

            <a href="#" class="nav_link submenu_item">

            <a href="addBook.html" class="nav_link submenu_item">
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
                <i class='bx bx-log-out-circle' ></i>
              </span>
              <span class="navlink">Logout</span>
            </a>
          </li>

        </ul>

        

        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Expand</span>
            <i class='bx bx-log-in' ></i>
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
      
      <?php
        $rollno = $_SESSION['RollNo'];
        $sql = "select * from olms.user where RollNo='$rollno'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $name = $row['Name'];
        $category = $row['Category'];
        $email = $row['EmailId'];
        $mobno = $row['MobNo'];
        ?>

        <img src="images/profile.jpg" alt="User Image" class="profile_image" />
        <h2 class="profile_name"><center><?php echo $name ?></center></h2>
        <p class="profile_email">
        <p><b>Email ID: </b><?php echo $email ?></p>
        <p class="profile_mobileNumber">
        <p><b>Mobile Number: </b><?php echo $mobno ?></p>

        <a href="editProfile.html" class="btn">Edit Details</a>


    </div>
  </div>
  

    
    
    <script src="script.js"></script>
  </body>
</html>

<?php } else {
  echo "<script type='text/javascript'>alert('Access Denied!!!')</script>";
} ?>