<?php
require('dbconn.php'); // Connect the database connection file

if (!isset($_SESSION['RollNo'])) { // Check if the user is logged in by verifying if the session variable 'RollNo' exists
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
  <title>Edit Book</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <!-- Navbar -->
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
    </div>
  </nav>

  <!-- Sidebar -->
  <nav class="sidebar">
    <div class="menu_content">
      <ul class="menu_items">
        <!-- Menu Items -->
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
            <span class="navlink">Reserve/Return Requests</span>
          </a>
        </li>

        <li class="item">
          <a href="currently_issued.php" class="nav_link submenu_item">
            <span class="navlink_icon">
              <i class='bx bx-list-ul'></i>
            </span>
            <span class="navlink">Currently Issued Books</span>
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
        $name = $row['Title'];  // assign book details to variables
        $publisher = $row['Publisher'];
        $year = $row['Year'];
        $avail = $row['Availability'];
        $PDF_Link = $row['PDF_Link'];  // Fetch current PDF path
        ?>

        <form class="form-horizontal row-fluid" action="editBook.php?BookId=<?php echo $bookId; ?>" method="post" enctype="multipart/form-data">
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

          <!-- PDF File Upload -->
          <div class="control-group">
            <b>
              <label class="control-label" for="pdfFile">Upload PDF:</label>
            </b>
            <div class="controls">
              <input type="file" id="pdfFile" name="pdfFile" class="span8" accept=".pdf">
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
    if (isset($_POST['submit'])) { // Check if the form is submitted
      $bookId = $_GET['BookId']; // Get updated book details from the form
      $name = $_POST['Title'];
      $publisher = $_POST['Publisher'];
      $year = $_POST['Year'];
      $avail = $_POST['Availability'];

      // Handle PDF upload
      $PDF_Link = null;
      if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] == 0) {
        $pdfName = $_FILES['pdfFile']['name'];
        $pdfTmpName = $_FILES['pdfFile']['tmp_name'];
        $pdfSize = $_FILES['pdfFile']['size'];
        $pdfExt = pathinfo($pdfName, PATHINFO_EXTENSION);

        // Validate PDF file type and size
        if ($pdfExt === 'pdf' && $pdfSize <= 10 * 1024 * 1024) {  // Max size 10MB
          $pdfNewName = "book_{$bookId}_" . time() . ".pdf"; // Unique name
          $pdfUploadDir = 'uploads/pdfs/';  // Directory to store PDFs
          if (!file_exists($pdfUploadDir)) {
            mkdir($pdfUploadDir, 0777, true);  // Create directory if it doesn't exist
          }

          $PDF_Link = $pdfUploadDir . $pdfNewName;
          move_uploaded_file($pdfTmpName, $PDF_Link);
        } else {
          echo "<script type='text/javascript'>alert('Invalid PDF file. Please upload a PDF file smaller than 10MB.');</script>";
        }
      } else {
        // If no new file is uploaded, keep the current file path
        $PDF_Link = $row['PDF_Link'];
      }

      // Update the book details including PDF path
      $sql1 = "UPDATE olms.book SET Title=?, Publisher=?, Year=?, Availability=?, PDF_Link=? WHERE BookId=?";
      $stmt = $conn->prepare($sql1);
      $stmt->bind_param("sssisi", $name, $publisher, $year, $avail, $PDF_Link, $bookId);

      // Execute the prepared statement
      if ($stmt->execute()) {
        echo "<script>
                alert('Book Details updated successfully!');
                window.location.href = 'admin_allBooks.php';
            </script>";
        exit();
      } else {
        echo "<script type='text/javascript'>alert('Error updating book details.');</script>";
      }
    }
    ?>
</body>

</html>

<?php
$userStmt->close();
$conn->close();
?>
