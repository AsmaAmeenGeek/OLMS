<?php
require('dbconn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Million Library</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Background -->
    <div class="background">
        <div class="container">
            <h1 class="text-center text-white fw-bold mb-4">MILLION LIBRARY</h1>
            <div class="form-container row justify-content-center">
                <!-- Sign In Section -->
                <div class="col-md-5 form-box p-4">
                    <h2 class="text-center mb-4">Sign In</h2>
                    <form action="" method="post">
                        <div class="mb-3">
                            <input type="text" name="RollNo" class="form-control" placeholder="Roll No" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="Password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" name="signin" class="edit_button">Sign In</button>
                    </form>
                </div>

                <!-- Sign Up Section -->
                <div class="col-md-5 form-box p-4">
                    <h2 class="text-center mb-4">Sign Up</h2>
                    <form action="" method="post">
                        <div class="mb-3">
                            <input type="text" name="Name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="Email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="Password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="PhoneNumber" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="RollNo" class="form-control" placeholder="Roll Number" required>
                        </div>
                        <div class="mb-3">
                            <select name="Category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="GEN">General</option>
                                <option value="OBC">OBC</option>
                                <option value="SC">SC</option>
                                <option value="ST">ST</option>
                            </select>
                        </div>
                        <button type="submit" name="signup" class="edit_button">Sign Up</button>
                    </form>
                </div>
            </div>
            <p class="text-white text-center mt-3">
                By creating an account, you agree to our <a href="terms.html" class="text-warning">Terms and Conditions</a>.
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
                header('location:admin/home.html');
            else
                header('location:user/home.php');
        } else {
            echo "<script type='text/javascript'>alert('Failed to Login! Incorrect RollNo or Password')</script>";
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
            echo "<script type='text/javascript'>alert('Registration Successful')</script>";
        } else {
            echo "<script type='text/javascript'>alert('User Exists')</script>";
        }
    }
    ?>


    <script src="index.js"></script>
</body>

</html>
