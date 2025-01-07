<?php
session_start();
require('dbconn.php');

// Ensure no accidental output disrupts styles
ob_end_clean();
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
      <img src="images/logo.jpg" alt="">MillionOLMS
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
              <i class='bx bx-chat'></i>
            </span>
            <span class="navlink">Messages</span>
          </a>
        </li>

        <li class="item">
          <a href="all_books.php" class="nav_link submenu_item">
            <span class="navlink_icon">
              <i class='bx bx-book'></i>
            </span>
            <span class="navlink">All Books</span>
          </a>
        </li>

        <li class="item">
          <a href="pre_borrowed_book.php" class="nav_link submenu_item">
            <span class="navlink_icon">
              <i class='bx bx-book'></i>
            </span>
            <span class="navlink">Previously Borrowed <br> Books</span>
          </a>
        </li>

        <li class="item">
          <a href="currently_reserved.html" class="nav_link submenu_item">
            <span class="navlink_icon">
              <i class='bx bxs-edit'></i>
            </span>
            <span class="navlink">Currently Reserved <br> Books</span>
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
      <img src="images/profile.jpg" alt="User Image" class="profile_image" />
      <?php
      // Ensure the session RollNo is set
      if (!isset($_SESSION['RollNo'])) {
        echo "<p>Error: User is not logged in. Please <a href='login.html'>log in</a>.</p>";
        exit;
      }

      $rollno = $_SESSION['RollNo'];
      $sql = "SELECT * FROM olms.user WHERE RollNo='$rollno'";
      $result = $conn->query($sql);

      if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['Name'];
        $category = $row['Category'];
        $email = $row['EmailId'];
        $mobno = $row['MobNo'];
      } else {
        echo "<p>Error: No user found with Roll No: $rollno</p>";
        $name = $category = $email = $mobno = "N/A";
      }
      ?>

      <h1 class="card-title">
        <center><?php echo htmlspecialchars($name); ?></center>
      </h1>
      <br>
      <p><b>Email ID: </b><?php echo htmlspecialchars($email); ?></p>
      <br>
      <p><b>Roll No: </B><?php echo htmlspecialchars($rollno); ?></p>
      <br>
      <p><b>Category: </b><?php echo htmlspecialchars($category); ?></p>
      <br>
      <p><b>Mobile number: </b><?php echo htmlspecialchars($mobno); ?></p>
      </b>

      <a href="edit_profile.php" class="edit_button">Edit Details</a>
    </div>
  </div>

  </div>
  </div>

  <footer>
    <div class="footer-content">
      <div>
        <h3>Million Library</h3>
        <p>OLMS</p>
      </div>
      <div>
        <ul>
          <li><a href="Help.html">About Us</a></li>
          <li><a href="Help.html">Contact Us</a></li>
          <li><a href="Help.html">Terms and conditions</a></li>
        </ul>
      </div>
      <div>
        <ul>
          <li><a href="Help.html">Plans</a></li>
          <li><a href="Help.html">FAQs</a></li>
          <li><a href="Help.html">Help</a></li>
        </ul>
      </div>
    </div>
  </footer>

  <p style="margin-left: 690px; margin-top: 20px;">&copy; 2024 Million Library. All rights reserved.</p>


  <script src="script.js"></script>
</body>

</html>