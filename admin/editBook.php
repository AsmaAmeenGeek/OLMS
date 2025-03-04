<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
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
    <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
    <title>Edit Book Details</title>
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
            <a href="#" class="nav_link submenu_item">
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

          <h2>Update Book Details</h2>

          <?php
          $bookId = $_GET['BookId'];
          $sql = "SELECT * FROM olms.book WHERE BookId = '$bookId'";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          $name = $row['Title'];
          $publisher = $row['Publisher'];
          $year = $row['Year'];
          $avail = $row['Availability'];
          ?>

          <form class="form-horizontal row-fluid" action="editBook.php?BookId=<?php echo $bookId; ?>" method="post">

            <div class="control-group">
              <b>
                <label class="control-label" for="Title">Book Title:</label>
              </b>
              <div class="controls">
                <input type="text" id="Title" name="Title" value="<?php echo htmlspecialchars($name) ?>" class="span8">
              </div>
            </div>

            <div class="control-group">
              <b>
                <label class="control-label" for="Publisher">Publisher:</label>
              </b>
              <div class="controls">
                <input type="text" id="Publisher" name="Publisher" value="<?php echo htmlspecialchars($publisher) ?>" class="span8">
              </div>
            </div>

            <div class="control-group">
              <b>
                <label class="control-label" for="Year">Year:</label>
              </b>
              <div class="controls">
                <input type="text" id="Year" name="Year" value="<?php echo htmlspecialchars($year) ?>" class="span8">
              </div>
            </div>

            <div class="control-group">
              <b>
                <label class="control-label" for="Availability">Availability:</label>
              </b>
              <div class="controls">
                <input type="text" id="Availability" name="Availability" value="<?php echo htmlspecialchars($avail) ?>" class="span8">
              </div>
            </div>

            <div class="control-group">
              <div class="controls">
                <button type="submit" name="submit" class="btn">Update Details</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <script src="script.js"></script>

      <?php
      if (isset($_POST['submit'])) {
        $bookId = $_GET['BookId'];
        $name = $_POST['Title'];
        $publisher = $_POST['Publisher'];
        $year = $_POST['Year'];
        $avail = $_POST['Availability'];

        $sql1 = "UPDATE book SET Title=?, Publisher=?, Year=?, Availability=? WHERE BookId=?";
        $stmt = $conn->prepare($sql1);
        $stmt->bind_param("sssii", $name, $publisher, $year, $avail, $bookId);

        // Execute the prepared statement
        if ($stmt->execute()) {
          echo "<script>
                alert('Book Details updated successfully!');
                window.location.href = 'admin_allBooks.php';
            </script>";
          exit(); 
        } else {
          echo "<script type='text/javascript'>alert('Error')</script>";
        }
      }
      ?>
  </body>

  </html>

  <?php
$userStmt->close();
$conn->close();
?>