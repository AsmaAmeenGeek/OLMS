<?php
require('dbconn.php');

$rollno = $_SESSION['RollNo'];

// Fetch user details for profile picture
$userQuery = "SELECT * FROM olms.user WHERE RollNo=?";
$userStmt = $conn->prepare($userQuery); // Prepare the SQL statement
$userStmt->bind_param("s", $rollno); // Bind the parameter for RollNo
$userStmt->execute();
$userResult = $userStmt->get_result();

if ($userResult && $userResult->num_rows > 0) { // If a user is found
    $userRow = $userResult->fetch_assoc();
    $ProfilePicture = !empty($userRow['ProfilePicture']) ? $userRow['ProfilePicture'] : 'images/profile.jpg';
} else {
    // If no user is found, set a default profile picture
    $ProfilePicture = 'images/profile.jpg';
}

// Fetch book details
if (isset($_GET['BookId'])) {
    $bookId = $_GET['BookId'];
    $sql = "SELECT * FROM olms.book WHERE BookId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <!-- Boxicons CSS -->
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
                    <img src="<?php echo ($ProfilePicture); ?>" alt="Profile Picture" class="profile" id="profilePic" />
                    <div class="profile-dropdown" id="profileDropdown">
                        <a href="profile.php">My Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
            </nav>

            <!-- sidebar -->
            <nav class="sidebar">
                <div class="menu_content">
                    <div class="menu_items">
                        <div class="menu_title menu_dahsboard"></div>

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
                                    <i class='bx bx-book-add'></i>
                                </span>
                                <span class="navlink">Previously Borrowed <br> Books</span>
                            </a>
                        </li>

                        <li class="item">
                            <a href="currently_reserved.php" class="nav_link submenu_item">
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
                <div class="content">
                    <div class="book-details">
                        <h1>Book Details</h1>
                        <p><strong>Book ID:</strong> <?php echo $book['BookId']; ?></p>
                        <p><strong>Title:</strong> <?php echo $book['Title']; ?></p>

                        <?php
                        // Fetch authors
                        $authorQuery = "SELECT * FROM OLMS.author WHERE BookId = ?";
                        $authorStmt = $conn->prepare($authorQuery);
                        $authorStmt->bind_param("i", $bookId);
                        $authorStmt->execute();
                        $authorResult = $authorStmt->get_result();
                        $authors = [];
                        while ($authorRow = $authorResult->fetch_assoc()) {
                            $authors[] = $authorRow['Author'];
                        }
                        echo "<p><strong>Author:</strong> " . implode(", ", $authors) . "</p>";
                        ?>

                        <p><strong>Publisher:</strong> <?php echo $book['Publisher']; ?></p>
                        <p><strong>Year:</strong> <?php echo $book['Year']; ?></p>
                        <p><strong>Availability:</strong>
                            <?php echo $book['Availability'] > 0 ? $book['Availability'] . " copies" : "Not Available"; ?>
                        </p>

                        <!-- PDF Access Section -->
                        <?php
                        // Check if the user has an approved reservation and UnlockPDF is 1
                        $reservationQuery = "SELECT * FROM reservation WHERE RollNo = ? AND BookId = ? AND UnlockPDF = 1";
                        $reservationStmt = $conn->prepare($reservationQuery);
                        $reservationStmt->bind_param("si", $rollno, $bookId);
                        $reservationStmt->execute();
                        $reservationResult = $reservationStmt->get_result();

                        if ($reservationResult->num_rows > 0) {
                            // User has an approved reservation and PDF is unlocked, allow PDF access
                            if (!empty($book['PDF_Link'])) {
                                echo "<p><strong>Book PDF:</strong> <a href='" . $book['PDF_Link'] . "' target='_blank'>View PDF</a></p>";
                            } else {
                                echo "<p><strong>Book PDF:</strong> Not available</p>";
                            }
                        } else {
                            // PDF is locked
                            echo "<p><strong>Book PDF:</strong> <span style='color: red;'>Access Locked (Reserve to Unlock)</span></p>";
                        }
                        ?>

                        <div class="button-container">
                            <a href="all_books.php" class="btn-link">
                                <button class="table_btn">Go back</button>
                            </a>
                        </div>
                    </div>
                </div>
            </main>

            <footer>
                <div class="footer-content">
                    <div>
                        <h3>Million Library</h3>
                        <p>OLMS</p>
                    </div>
                    <div>
                        <ul>
                            <li><a href="Help.php">About Us</a></li>
                            <li><a href="Help.php">Contact Us</a></li>
                            <li><a href="Help.php">Terms and conditions</a></li>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <li><a href="Help.php">Plans</a></li>
                            <li><a href="Help.php">FAQs</a></li>
                            <li><a href="Help.php">Help</a></li>
                        </ul>
                    </div>
                </div>
            </footer>

            <p class="site-name">&copy; 2024 Million Library. All rights reserved.</p>
            <script src="script.js"></script>
        </body>

        </html>

        <?php
    } else {
        echo "Book not found.";
    }
} else {
    echo "No BookId provided.";
}
?>