<?php
require('dbconn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Million Library</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Background -->
    <div class="background">
        <div class="container">
            <h1>MILLION LIBRARY</h1>
            <div class="form-container">
                <!-- Sign In Section -->
                <div class="form-box">
                    <h2>Sign In</h2>
                    <form action="" method="post">
                        <input type="text" name="RollNo" placeholder="Roll No" required>
                        <input type="password" name="Password" placeholder="Password" required>
                        <button type="submit" name="signin" class="edit_button">Sign In</button>
                    </form>
                </div>

                <!-- Sign Up Section -->
                <div class="form-box">
                    <h2>Sign Up</h2>
                    <form action="" method="post">
                        <input type="text" name="Name" placeholder="Name" required>
                        <input type="email" name="Email" placeholder="Email" required>
                        <input type="password" name="Password" placeholder="Password" required>
                        <input type="text" name="PhoneNumber" placeholder="Phone Number" required>
                        <input type="text" name="RollNo" placeholder="Roll Number" required>
                        <button type="submit" name="signup" class="edit_button">Sign Up</button>
                    </form>
                </div>
            </div>
            <p class="text-center">
                By creating an account, you agree our Terms and Conditions</a>.
            </p>

        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 Million Library. All Rights Reserved.</p>
    </div>

    <?php
    if (isset($_POST['signin'])) {
        $u = $_POST['RollNo'];
        $p = $_POST['Password'];
        $sql = "SELECT * FROM olms.user WHERE RollNo='$u'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $x = $row['Password'];
        $y = $row['Type'];
        if (strcasecmp($x, $p) == 0 && !empty($u) && !empty($p)) {
            $_SESSION['RollNo'] = $u;
            if ($y == 'Admin')
                header('location:admin/home.php');
            else
                header('location:user/home.php');
        } else {
            echo "<script>alert('Failed to Login! Incorrect RollNo or Password')</script>";
        }
    }

    if (isset($_POST['signup'])) {
        $name = $_POST['Name'];
        $email = $_POST['Email'];
        $password = $_POST['Password'];
        $mobno = $_POST['PhoneNumber'];
        $rollno = $_POST['RollNo'];
        $category = $_POST['Category'];
        $type = 'Student';

        $sql = "INSERT INTO olms.user (Name, Type, Category, RollNo, EmailId, MobNo, Password) 
                VALUES ('$name', '$type', '$category', '$rollno', '$email', '$mobno', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration Successful')</script>";
        } else {
            echo "<script>alert('User Exists')</script>";
        }
    }
    ?>

    <script src="index.js"></script>
</body>

</html>