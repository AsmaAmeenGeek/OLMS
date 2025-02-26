<?php
 // Start the session
require('dbconn.php'); // Ensure database connection

if ($_SESSION['RollNo']) {
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $author1 = $_POST['author1'];
        $author2 = $_POST['author2'];
        $author3 = $_POST['author3'];
        $publisher = $_POST['publisher'];
        $year = $_POST['year'];
        $availability = $_POST['availability'];

        // Add the book into the database
        $sql1 = "INSERT INTO book (Title, Publisher, Year, Availability) 
                 VALUES ('$title', '$publisher', '$year', '$availability')";

        if ($conn->query($sql1) === TRUE) {
            $sql2 = "SELECT max(BookId) as x FROM book";
            $result = $conn->query($sql2);
            $row = $result->fetch_assoc();
            $x = $row['x'];

            $sql3 = "INSERT INTO author (BookId, Author) VALUES ('$x', '$author1')";
            $result = $conn->query($sql3);

            if (!empty($author2)) {
                $sql4 = "INSERT INTO author (BookId, Author) VALUES ('$x', '$author2')";
                $result = $conn->query($sql4);
            }
            if (!empty($author3)) {
                $sql5 = "INSERT INTO author (BookId, Author) VALUES ('$x', '$author3')";
                $result = $conn->query($sql5);
            }

            echo "<script type='text/javascript'>alert('Success')</script>";
        } else {
            echo $conn->error; // Show SQL error
            echo "<script type='text/javascript'>alert('Error')</script>";
        }
    }
} else {
    echo "<script type='text/javascript'>alert('Access Denied!!!')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
                    <a href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bxs-user-detail'></i>
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
                    <a href="#" class="nav_link submenu_item">
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
                <form class="form-horizontal row-fluid" method="POST" action="">
                    <h2>Add Book</h2>
                    <div class="control-group">
                        <label class="control-label" for="title"><b>Book Title:</b></label>
                        <div class="controls">
                            <input type="text" id="title" name="title" class="span8" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="Name"><b>Author:</b></label>
                        <div class="controls">
                            <input type="text" id="author1" name="author1" class="span8" required>
                        </div>
                        <div class="controls">
                            <input type="text" id="author2" name="author2" class="span8">
                        </div>
                        <div class="controls">
                            <input type="text" id="author3" name="author3" class="span8">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="publisher"><b>Publisher:</b></label>
                        <div class="controls">
                            <input type="text" id="publisher" name="publisher" class="span8" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="year"><b>Year:</b></label>
                        <div class="controls">
                            <input type="number" id="year" name="year" class="span8" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="availability"><b>Number of Copies:</b></label>
                        <div class="controls">
                            <input type="number" id="availability" name="availability" class="span8" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" name="submit" class="btn">Add Book</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>