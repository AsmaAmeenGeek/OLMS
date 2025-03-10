<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
  header("Location: index.php");
  exit();
}

$rollno = $_SESSION['RollNo'];
$sql = "SELECT * FROM olms.user WHERE RollNo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $rollno);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $name = $row['Name'];
  $email = $row['EmailId'];
  $mobno = $row['MobNo'];
  $ProfilePicture = !empty($row['ProfilePicture']) ? $row['ProfilePicture'] : 'images/profile.jpg';
} else {
  echo "<p>Error: No user found.</p>";
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $newName = $_POST['Name'];
  $newEmail = $_POST['EmailId'];
  $newMobno = $_POST['MobNo'];
  $newPassword = $_POST['Password'];

  // Handle Profile Image Upload
  if (!empty($_FILES['profile_image']['name'])) {
    $file_name = basename($_FILES["profile_image"]["name"]);
    $targetDir = "../Assets/profile/";
    $targetFile = $targetDir . $file_name;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedTypes = array("jpg", "jpeg", "png", "gif");

    if (in_array($imageFileType, $allowedTypes)) {
      if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
        $ProfilePicture = $targetFile;
      } else {
        echo "<p>Error uploading file.</p>";
      }
    } else {
      echo "<p>Only JPG, JPEG, PNG, and GIF files are allowed.</p>";
    }
  }

  // Update user details
  $updateQuery = "UPDATE olms.user SET Name=?, EmailId=?, MobNo=?, ProfilePicture=? WHERE RollNo=?";
  $stmt = $conn->prepare($updateQuery);
  $stmt->bind_param("sssss", $newName, $newEmail, $newMobno, $ProfilePicture, $rollno);

  if ($stmt->execute() === TRUE) {
    $_SESSION['success'] = "Profile updated successfully!";
    header("Location: profile.php");
    exit;
  } else {
    echo "<p>Error updating profile: " . $stmt->error . "</p>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
  <title>Edit Profile</title>
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

  <section class="edit-section">
    <h2>Update Profile</h2>

    <img src="<?php echo $ProfilePicture . '?' . time(); ?>" alt="User Image" class="profile_image1" />

    <form action="editProfile.php" method="post" enctype="multipart/form-data">
      <label for="name">Name:</label>
      <input type="text" id="name" placeholder="Enter your name" name="Name" value="<?php echo ($name); ?>">

      <label for="email">E-mail ID:</label>
      <input type="email" id="email" placeholder="Enter your email" name="EmailId" value="<?php echo ($email); ?>">

      <label for="mobile">Mobile number:</label>
      <input type="tel" id="mobile" placeholder="Enter your mobile number" name="MobNo" value="<?php echo ($mobno); ?>">

      <label for="profile_image">Upload New Profile Image:</label>
      <input type="file" name="profile_image" accept="image/*">

      <label for="password">New Password:</label>
      <input type="password" id="password" placeholder="Enter new password" name="Password">

      <button type="submit" name="submit" class="table_btn">Save</button>
    </form>
  </section>

  <script src="script.js"></script>
</body>

</html>