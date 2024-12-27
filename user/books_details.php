<?php
require('dbconn.php');

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
            <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
            <title>OLMS</title>
            <link rel="stylesheet" href="style.css" />

            <style>
                .navbar-placeholder {
                    height: 100px;
                    width: 100%;
                }

                .content {
                    flex: 1;
                    padding: 30px;
                    background: #fff;
                    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
                    width: 90%;
                    max-width: 800px;
                    border-radius: 5px;
                    margin: 0 auto;
                }


                .content h3 {
                    margin-bottom: 20px;
                    border-bottom: 1px solid #ddd;
                    padding-bottom: 10px;
                }

                .book-details {
                    line-height: 1.8;
                }

                .book-details p span {
                    font-weight: bold;
                }

                button {
                    display: inline-block;
                    padding: 1px 20px;
                    font-size: 16px;
                    color: #784939;
                    background-color: #D8D2D0;
                    border-radius: 5px;
                    text-decoration: none;
                    transition: background-color 0.3s;
                    margin-top: 20px;
                }
            </style>
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
            <div class="navbar-placeholder"></div>
            <!-- sidebar -->
            <nav class="sidebar">
                <div class="menu_content">
                    <ul class="menu_items">
                        <div class="menu_title menu_dahsboard"></div>
                        <!-- start -->
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
                            <a href="all_books.php" class="nav_link submenu_item">
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
                    <h3>Book Details</h3>
                    <div class="book-details">
                        <h1>Book Details</h1>
                        <p><strong>Book ID:</strong> <?php echo $book['BookId']; ?></p>
                        <p><strong>Title:</strong> <?php echo $book['Title']; ?></p>
                        <p><strong>Availability:</strong>
                            <?php echo $book['Availability'] > 0 ? "Available" : "Not Available"; ?></p>
                        <a href="all_books.php"><button>Go back</button></a>
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
                            <li><a href="Help.html">About Us</a></li>
                            <li><a href="Help.html">Contact Us</a></li>
                            <li><a href="Help.html">Terms and conditions</a></li>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <li><a href="Help.html">Plans</a></li>
                            <li><a href="Help.html">FAQs</a></li>
                            <li><a href="Help.html">Help</a></li>
                        </ul>
                    </div>
                </div>
            </footer>

            <p style="margin-left: 650px; margin-top: 20px;">&copy; 2024 Million Library. All rights reserved.</p>

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