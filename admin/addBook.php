<?php
require('dbconn.php');

if (!isset($_SESSION['RollNo'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $author1 = trim($_POST['author1']);
    $author2 = trim($_POST['author2']);
    $author3 = trim($_POST['author3']);
    $publisher = trim($_POST['publisher']);
    $year = trim($_POST['year']);
    $availability = trim($_POST['availability']);

    // File upload handling
    $pdf_file = $_FILES['PDF_Link'];

    // Check if the file is uploaded without errors
    if ($pdf_file['error'] == 0) {
        $pdf_name = $pdf_file['name'];
        $pdf_tmp_name = $pdf_file['tmp_name'];
        $pdf_size = $pdf_file['size'];
        $pdf_extension = pathinfo($pdf_name, PATHINFO_EXTENSION);

        // Check if the file is a PDF
        if (strtolower($pdf_extension) == "pdf") {
            // Generate a unique name for the file
            $new_pdf_name = uniqid('book_') . '.' . $pdf_extension;
            $pdf_path = '../Assets/' . $new_pdf_name;

            // Move the uploaded file to the Assets folder
            if (move_uploaded_file($pdf_tmp_name, $pdf_path)) {
                // Successful file upload, proceed with database insertion
                $conn->begin_transaction();
                try {
                    // Insert book details (Fix: changed PdfPath to PDF_Link)
                    if ($stmt = $conn->prepare("INSERT INTO book (Title, Publisher, Year, Availability, PDF_Link) VALUES (?, ?, ?, ?, ?)")) {
                        $stmt->bind_param("sssis", $title, $publisher, $year, $availability, $pdf_path);
                        if ($stmt->execute()) {
                            $bookId = $conn->insert_id;
                        } else {
                            throw new Exception("Error inserting book: " . $stmt->error);
                        }
                        $stmt->close();
                    } else {
                        throw new Exception("Error preparing book insert query: " . $conn->error);
                    }

                    // Insert authors
                    if ($stmt = $conn->prepare("INSERT INTO author (BookId, Author) VALUES (?, ?)")) {
                        foreach ([$author1, $author2, $author3] as $author) {
                            if (!empty($author)) {
                                $stmt->bind_param("is", $bookId, $author);
                                if (!$stmt->execute()) {
                                    throw new Exception("Error adding author: " . $stmt->error);
                                }
                            }
                        }
                        $stmt->close();
                    } else {
                        throw new Exception("Error preparing author insert query: " . $conn->error);
                    }

                    $conn->commit();
                    echo "<script>alert('Book added successfully!'); window.location='admin_allBooks.php';</script>";
                } catch (Exception $e) {
                    $conn->rollback();
                    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
                }
            } else {
                echo "<script>alert('File upload failed. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Only PDF files are allowed.');</script>";
        }
    } else {
        echo "<script>alert('Error in uploading file.');</script>";
    }
}

// fetch profile
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
    <title>Add New Book</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <!-- navbar -->
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

    <div class="span9">
        <div class="container1">
            <div class="container1_box">
                <h2>Add Books</h2>
                <form method="POST" action="" enctype="multipart/form-data">
                    <label>Book Title:</label>
                    <input type="text" name="title" required>

                    <label>Author 1:</label>
                    <input type="text" name="author1" required>

                    <label>Author 2:</label>
                    <input type="text" name="author2">

                    <label>Author 3:</label>
                    <input type="text" name="author3">

                    <label>Publisher:</label>
                    <input type="text" name="publisher" required>

                    <label>Year:</label>
                    <input type="number" name="year" required>

                    <label>Number of Copies:</label>
                    <input type="number" name="availability" required>

                    <label>PDF File:</label>
                    <input type="file" name="PDF_Link" accept=".pdf" required>

                    <button type="submit" class="table_btn">Add Book</button>
                </form>
            </div>
        </div>
</body>

</html>