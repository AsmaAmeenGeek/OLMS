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
            <a href="#" class="nav_link submenu_item">
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


    <div class="span9">
      <div class="container1">
        <div class="container1_box">

          <h2>Update Details</h2>

          <?php
          $rollno = $_SESSION['RollNo'];
          $sql = "SELECT * FROM olms.user WHERE RollNo = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("s", $rollno);
          $stmt->execute();
          $result = $stmt->get_result();
          $row = $result->fetch_assoc();

          $name = $row['Name'];
          $email = $row['EmailId'];
          $mobno = $row['MobNo'];
          $pswd = $row['Password'];
          ?>

          <form class="form-horizontal row-fluid" action="editProfile.php?id=<?php echo $rollno ?>" method="post">
            <img src="images/profile.jpg" alt="User Image" class="profile_image" />

            <div class="control-group">
              <label class="control-label" for="name"><b>Name:</b></label>
              <div class="controls">
                <input type="text" id="Name" name="Name" value="<?php echo htmlspecialchars($name); ?>" class="span8" required>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="EmailId"><b>Email Id:</b></label>
              <div class="controls">
                <input type="email" id="EmailId" name="EmailId" value="<?php echo htmlspecialchars($email); ?>" class="span8" required>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="MobNo"><b>Mobile Number:</b></label>
              <div class="controls">
                <input type="text" id="MobNo" name="MobNo" value="<?php echo htmlspecialchars($mobno); ?>" class="span8" required>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="Password"><b>New Password (Enter the new password):</b></label>
              <div class="controls">
                <input type="password" id="Password" name="Password" class="span8">
              </div>
            </div>

            <div class="control-group">
              <div class="controls">
                <button type="submit" name="submit" class="btn">Save</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>




    <script src="script.js"></script>


    <?php
    if (isset($_POST['submit'])) {
      $name = $_POST['Name'];
      $email = $_POST['EmailId'];
      $mobno = $_POST['MobNo'];
      $new_password = $_POST['Password'];

      // Fetch existing user details
      $rollno = $_SESSION['RollNo'];
      $sql = "SELECT Password FROM olms.user WHERE RollNo = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $rollno);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();

      if (!$row) {
        echo "<script>alert('User not found!');</script>";
        exit();
      }

      // If password is provided, hash it. Otherwise, keep the old password.
      if (!empty($new_password)) {
        $pswd = password_hash($new_password, PASSWORD_BCRYPT);
      } else {
        $pswd = $row['Password'];
      }

      // Update user profile (without Category field)
      $sql1 = "UPDATE olms.user SET Name = ?, EmailId = ?, MobNo = ?, Password = ? WHERE RollNo = ?";
      $stmt = $conn->prepare($sql1);

      if ($stmt) {
        $stmt->bind_param("sssss", $name, $email, $mobno, $pswd, $rollno);
        if ($stmt->execute()) {
          echo "<script>
                alert('Profile updated successfully!');
                window.location.href = 'profile.php';
            </script>";
          exit();
        } else {
          echo "<p class='error'>Error updating profile: " . $stmt->error . "</p>";
        }
        $stmt->close();
      } else {
        echo "<p class='error'>Error preparing statement: " . $conn->error . "</p>";
      }
    }
    ?>


  </body>

  </html>


<?php } else {
  echo "<script type='text/javascript'>alert('Access Denied!!!')</script>";
} ?>