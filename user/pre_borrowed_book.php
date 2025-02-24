<?php
require('dbconn.php');
?>

<?php
if ($_SESSION['RollNo']) {
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
                                <i class='bx bx-book'></i>
                            </span>
                            <span class="navlink">All Books</span>
                        </a>
                    </li>

                    <li class="item">
                        <a href="pre_borrowed_book.php" class="nav_link submenu_item">
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
            <div class="search-bar">
                <label for="search">Search:</label>
                <input type="text" id="search" placeholder="Enter Name / ID of Book">
                <button type="button">Search</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Book Name</th>
                        <th>Issued Date</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rollno = $_SESSION['RollNo'];
                    if (isset($_POST['submit'])) {
                        $s = $_POST['title'];
                        $sql = "select * from olms.record,olms.book where RollNo = '$rollno' and Date_Issue is NOT NULL and Date_Return is NOT NULL and book.Bookid = record.BookId and (record.BookId='$s' or Title like '%$s%')";
                    } else
                        $sql = "select * from olms.record,olms.book where RollNo = '$rollno' and Date_Issue is NOT NULL and Date_Return is NOT NULL and book.Bookid = record.BookId";

                    $result = $conn->query($sql);
                    $rowcount = mysqli_num_rows($result);

                    if (!($rowcount))
                        echo "<br><center><h2><b><i>No Results</i></b></h2></center>";

                    while ($row = $result->fetch_assoc()) {
                        $bookid = $row['BookId'];
                        $name = $row['Title'];
                        $issuedate = $row['Date_Issue'];
                        $returndate = $row['Date_Return'];
                        ?>

                        <tr>
                            <td><?php echo $bookid ?></td>
                            <td><?php echo $name ?></td>
                            <td><?php echo $issuedate ?></td>
                            <td><?php echo $returndate ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </section>
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

        <p style="margin-left: 690px; margin-top: 20px;">&copy; 2024 Million Library. All rights reserved.</p>
        <script src="script.js"></script>
    </body>

    </html>

<?php } else {
    echo "<script type='text/javascript'>alert('Access Denied!!!')</script>";
} ?>