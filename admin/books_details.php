<?php
require('dbconn.php');//connect the database connection file

if (!isset($_SESSION['RollNo'])) {// check if the user is logged in by verifying if the session variable 'RollNo' exists
    header("Location: index.php");
    exit();
}

if (isset($_GET['BookId'])) { // check if book Id is passed in the URL query string by GET request parameter
    $bookId = $_GET['BookId']; //retrieve the book id from the URL and store it in a variable
    $sql = "SELECT * FROM olms.book WHERE BookId = ?"; // prepare the SQL query to fetch book details by book id
    $stmt = $conn->prepare($sql); //prepare query, used prepare and bind methods to prevent sql injection
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { //if matching book is find 
        $book = $result->fetch_assoc(); //fetch book details

        $rollno = $_SESSION['RollNo']; // get the logged in user's roll no from session 

        $userQuery = "SELECT * FROM olms.user WHERE RollNo=?"; //prepare sql query to fetch user details
        $userStmt = $conn->prepare($userQuery);
        $userStmt->bind_param("s", $rollno);
        $userStmt->execute();
        $userResult = $userStmt->get_result();

        if ($userResult && $userResult->num_rows > 0) { //if user detail found
            $userRow = $userResult->fetch_assoc(); // fetch detail
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
            <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
            <title>Book Details</title>
            <link rel="stylesheet" href="style.css" />
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



            <!-- Book details Page -->
            <main class="main-content">
                <div class="content">
                    <div class="book-details">
                        <h1>Book Details</h1>
                        <?php
                        $x = $_GET['BookId']; // Using book id from the GET parameter
                        $sql = "SELECT * FROM OLMS.book WHERE BookId = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $x);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) { //check any book details found
                            $row = $result->fetch_assoc();
                            $bookid = $row['BookId'];
                            $name = $row['Title'];
                            $publisher = $row['Publisher'];
                            $year = $row['Year'];
                            $avail = $row['Availability'];

                            echo "<p><strong>Book ID:</strong> $bookid</p>"; // display book details
                            echo "<p><strong>Title:</strong> $name</p>";

                            // Fetch authors
                            $sql1 = "SELECT * FROM OLMS.author WHERE BookId = ?";
                            $stmt1 = $conn->prepare($sql1); //prepare query for authors
                            $stmt1->bind_param("i", $bookid); //bind the book id as int
                            $stmt1->execute();
                            $authorResult = $stmt1->get_result();

                            echo "<p><strong>Author:</strong> ";
                            $authors = [];
                            while ($authorRow = $authorResult->fetch_assoc()) { // create loop through all related authors
                                $authors[] = $authorRow['Author']; // adding all authors to the array
                            }
                            echo implode(", ", $authors) . "</p>"; //show all users 

                            echo "<p><strong>Publisher:</strong> $publisher</p>"; //display publisher , year and availabilty
                            echo "<p><strong>Year:</strong> $year</p>";
                            echo "<p><strong>Availability:</strong> ";
                            echo $avail > 0 ? "$avail copies" : "Not Available";
                            echo "</p>";
                        } else {
                            echo "<p>Book details not found.</p>";
                        }
                        ?>
                        <div class="button-container">
                            <a href="admin_allBooks.php" class="btn-link">
                                <button class="go-back-btn">Go back</button>
                            </a>
                        </div>
                    </div>
                </div>
            </main>



            <script src="script.js"></script>
        </body>

        </html>

        <?php
    } else {
        echo "Book not found."; // display error message if no book id is provided / book is not found
    }
} else {
    echo "No BookId provided.";// display error message if book id is not passed in the URL
}
?>