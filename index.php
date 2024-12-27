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
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
</head>

<body>
    <div class="background">
        <div class="container">
            <h1>MILLION LIBRARY</h1>
            <div class="form-container">
                <div class="form-box">
                    <h2>Sign In</h2>
                    <form action="" method="post">
                        <input type="text" name="RollNo" placeholder="RollNo" required>
                        <input type="password" name="Password" placeholder="Password" required>
                        <button type="submit" name="signin">Sign In</button>
                    </form>
                </div>

                <!-- Sign Up Section -->
                <div class="form-box">
                    <h2>Sign Up</h2>
                    <form action="" method="post">
                        <input type="text" name="Name" placeholder="Name" required>
                        <input type="text" name="Email" placeholder="Email" required>
                        <input type="password" name="Password" placeholder="Password" required>
                        <input type="text" name="PhoneNumber" placeholder="Phone Number" required>
                        <input type="text" name="RollNo" placeholder="Roll Number" required>
                        <select name="Category" required>
                            <option value="GEN">General</option>
                            <option value="OBC">OBC</option>
                            <option value="SC">SC</option>
                            <option value="ST">ST</option>
                        </select>
                        <button type="submit" name="signup">Sign Up</button>
                    </form>
                </div>
            </div>
            <p>By creating an account, you agree to our <a class="underline" href="terms.html">Terms and Conditions</a></p>
            <div class="clear"></div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Million Library. All Rights Reserved.</p>
    </div>

    <?php
    if (isset($_POST['signin'])) {
        $u = $_POST['RollNo'];
        $p = $_POST['Password'];


        $sql = "select * from olms.user where RollNo='$u'";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $x = $row['Password'];
        $y = $row['Type'];
        if (strcasecmp($x, $p) == 0 && !empty($u) && !empty($p)) {//echo "Login Successful";
            $_SESSION['RollNo'] = $u;


            if ($y == 'Admin')
                header('location:admin/home.html');
            else
                header('location:user/home.html');

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

        $sql = "insert into olms.user (Name,Type,Category,RollNo,EmailId,MobNo,Password) values ('$name','$type','$category','$rollno','$email','$mobno','$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('Registration Successful')</script>";
        } else {
            //echo "Error: " . $sql . "<br>" . $conn->error;
            echo "<script type='text/javascript'>alert('User Exists')</script>";
        }
    }

    ?>

</body>

</html>
