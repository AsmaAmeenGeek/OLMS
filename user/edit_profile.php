<?php
ob_start();
require('dbconn.php');
session_start();
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
                    <a href="book_details.html" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bxs-user-detail'></i>
                        </span>
                        <span class="navlink">All Books</span>
                    </a>
                </li>

                <li class="item">
                    <a href="pre_borrowed_book.html" class="nav_link submenu_item">
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
                    <a href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bx-log-out-circle'></i>
                        </span>
                        <span class="navlink">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="edit-section">
        <h2>Edit Details</h2>
        <img src="images/profile.jpg" alt="User Image" class="profile_image1" />

        <?php
        $rollno = $_SESSION['RollNo'];
        $sql = "SELECT * FROM LMS.user WHERE RollNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $rollno);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $name = $row['Name'];
        $category = $row['Category'];
        $email = $row['EmailId'];
        $mobno = $row['MobNo'];
        $pswd = $row['Password'];
        ?>

        <form action="edit_profile.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" placeholder="Enter your name" name="Name" value="<?php echo htmlspecialchars($name); ?>">

            <label for="Category"><b>Category:</b></label>
            <select name="Category">
                <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                <option value="GEN">GEN</option>
                <option value="OBC">OBC</option>
                <option value="SC">SC</option>
                <option value="ST">ST</option>
            </select>

            <label for="email">E-mail ID:</label>
            <input type="email" id="email" placeholder="Enter your email" name="EmailId" value="<?php echo htmlspecialchars($email); ?>">

            <label for="mobile">Mobile number:</label>
            <input type="tel" id="mobile" placeholder="Enter your mobile number" name="MobNo" value="<?php echo htmlspecialchars($mobno); ?>">

            <label for="password">New Password:</label>
            <input type="password" id="password" placeholder="Enter new password" name="Password">

            <button type="submit" name="submit" class="save-btn">Save</button>
        </form>
    </section>

    <footer>
        <div class="footer-content">
            <div>
                <h3>Million Library</h3>
                <p>OLMS</p>
            </div>
            <div>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Terms and conditions</a></li>
                </ul>
            </div>
            <div>
                <ul>
                    <li><a href="#">Plans</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
            </div>
        </div>
        <p>&copy; 2024 Million Library. All rights reserved.</p>
    </footer>

    <?php
    if (isset($_POST['submit'])) {
        $name = $_POST['Name'];
        $category = $_POST['Category'];
        $email = $_POST['EmailId'];
        $mobno = $_POST['MobNo'];
        $pswd = !empty($_POST['Password']) ? password_hash($_POST['Password'], PASSWORD_BCRYPT) : $row['Password'];

        $sql1 = "UPDATE LMS.user SET Name = ?, Category = ?, EmailId = ?, MobNo = ?, Password = ? WHERE RollNo = ?";
        $stmt = $conn->prepare($sql1);
        $stmt->bind_param("ssssss", $name, $category, $email, $mobno, $pswd, $rollno);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Profile updated successfully!');
                    window.location.href = 'profile.php';
                  </script>";
            exit();
        } else {
            echo "<p class='error'>Error updating profile: " . $conn->error . "</p>";
        }
    }
    ob_end_flush(); // End output buffering
    ?>
</body>

</html>
