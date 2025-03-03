<?php
require('dbconn.php');
?>

<?php
if (!isset($_SESSION['RollNo'])) {
  header("Location: index.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
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

  <main class="main-content">

    <form method="POST" action="">
      <div class="search-bar">
        <label for="search">Search:</label>
        <input type="text" id="search" name="title" placeholder="Enter Name / Roll No. of Student">
        <button type="submit" name="submit">Search</button>
      </div>
    </form>


    <?php
    $s = ""; // Define $s before checking if the form is submitted

    if (isset($_POST['submit'])) {
      $s = $_POST['title']; 
      $sql = "SELECT * FROM olms.user WHERE RollNo ='$s' OR Name LIKE '%$s%'";
    } else {
      // Default query for students (no user input)
      $sql = "SELECT * FROM olms.user WHERE Type='Student'";
    }


    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);

    if (!$rowcount) {
      echo "<br><center><h2><b><i>No Results</i></b></h2></center>";
    } else {
      // Display the search results in a table
    ?>
      <table>
        <thead>
          <tr>
            <th>Roll No.</th>
            <th>Name</th>
            <th>Email ID</th>
            <th> </th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = $result->fetch_assoc()) {
            $rollNo = $row['RollNo'];
            $name = $row['Name'];
            $emailId = $row['EmailId'];
          ?>
            <tr>
              <td><?php echo $rollNo ?></td>
              <td><?php echo $name ?></td>
              <td><?php echo $emailId ?></td>
              <td>
                <center>
                  <a href="stu_details.php?RollNo=<?php echo $rollNo; ?>" class="table_btn">View</a>
                </center>
              </td>
            </tr>
        <?php }
        } ?>
        </tbody>
      </table>
  </main>
  </div>
  </div>
</body>

</html>