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
  <title>Library Books</title>
  <link rel="stylesheet" href="style.css" />

  <script>
    // JavaScript function to confirm deletion
    function confirmDelete(bookId) {
      // Show confirmation popup
      if (confirm("Do you really want to delete the book?")) {
        // Redirect to the delete PHP script if admin clicks 'Yes'
        window.location.href = 'deleteBook.php?BookId=' + bookId;
      } else {
        // Do nothing if user admin 'Cancel'
        return false;
      }
    }
  </script>

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

    <form method="POST" action="">
      <div class="search-bar">
        <label for="search">Search:</label>
        <input type="text" id="search" name="title" placeholder="Enter Name / ID of Book">
        <button type="submit" name="submit">Search</button>
      </div>
    </form>


    <?php
    if (isset($_POST['submit'])) {
      $s = $_POST['title']; // Get the search term from the form
      $sql = "SELECT * FROM olms.book WHERE BookId='$s' OR Title LIKE '%$s%'";
    } else {
      // Default query to show all books ordered by BookId
      $sql = "SELECT * FROM olms.book ORDER BY BookId ASC";
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
            <th>Book ID</th>
            <th>Book Name</th>
            <th>Availability</th>
            <th> </th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = $result->fetch_assoc()) {
            $bookid = $row['BookId'];
            $name = $row['Title'];
            $avail = $row['Availability'];
            ?>
            <tr>
              <td><?php echo $bookid ?></td>
              <td><?php echo $name ?></td>
              <td><b><?php
              if ($avail > 0)
                echo "<font color=\"green\">Available</font>";
              else
                echo "<font color=\"red\">Not Available</font>";
              ?></b></td>
              <td>
                <center>
                  <a href="books_details.php?BookId=<?php echo $bookid; ?>" class="table_btn">Details</a>
                  <a href="editBook.php?BookId=<?php echo $bookid; ?>" class="table_btn">Edit</a>
                  <a href="javascript:void(0);" class="table_btn" onclick="confirmDelete(<?php echo $bookid; ?>)">Delete</a>

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
  <script src="script.js"></script>
</body>

</html>