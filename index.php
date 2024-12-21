<<<<<<< HEAD
<?php
require('dbconn.php');
?>


<!DOCTYPE html>
<html>

<!-- Head -->

<head>

    <title>Library Management System </title>

    <!-- Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords"
        content="Library Member Login Form Widget Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />
    <script
        type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- //Meta-Tags -->

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all">

    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <!-- //Fonts -->

</head>
<!-- //Head -->

<!-- Body -->

<body>

    <h1>LIBRARY MANAGEMENT SYSTEM</h1>

    <div class="container">

        <div class="login">
            <h2>Sign In</h2>
            <form action="index.php" method="post">
                <input type="text" Name="RollNo" placeholder="RollNo" required="">
                <input type="password" Name="Password" placeholder="Password" required="">


                <div class="send-button">
                    <!--<form>-->
                    <input type="submit" name="signin" ; value="Sign In">
            </form>
        </div>

        <div class="clear"></div>
    </div>

    <div class="register">
        <h2>Sign Up</h2>
        <form action="index.php" method="post">
            <input type="text" Name="Name" placeholder="Name" required>
            <input type="text" Name="Email" placeholder="Email" required>
            <input type="password" Name="Password" placeholder="Password" required>
            <input type="text" Name="PhoneNumber" placeholder="Phone Number" required>
            <input type="text" Name="RollNo" placeholder="Roll Number" required="">

            <select name="Category" id="Category">
                <option value="GEN">General</option>
                <option value="OBC">OBC</option>
                <option value="SC">SC</option>
                <option value="ST">ST</option>
            </select>
            <br>


            <br>
            <div class="send-button">
                <input type="submit" name="signup" value="Sign Up">
        </form>
    </div>
    <p>By creating an account, you agree to our <a class="underline" href="terms.html">Terms</a></p>
    <div class="clear"></div>
    </div>

    <div class="clear"></div>

    </div>

    <div class="footer w3layouts agileits">
        <p> &copy; 2018 Library Member Login. All Rights Reserved </a></p>

    </div>

    <?php
    if (isset($_POST['signin'])) {
        $u = $_POST['RollNo'];
        $p = $_POST['Password'];


        $sql = "select * from LMS.user where RollNo='$u'";

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

        $sql = "insert into LMS.user (Name,Type,Category,RollNo,EmailId,MobNo,Password) values ('$name','$type','$category','$rollno','$email','$mobno','$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('Registration Successful')</script>";
        } else {
            //echo "Error: " . $sql . "<br>" . $conn->error;
            echo "<script type='text/javascript'>alert('User Exists')</script>";
        }
    }

    ?>

</body>
<!-- //Body -->

</html>
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLMS</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Fixed Header -->
    <header>
        <div class="logo">
            <img src="index_img/libLogo.png" alt="Million Library Logo">
            <span>Million</span>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
        <a href="signup.php" class="get-start">GET START</a>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>Library Revolution</h1>
            <p>Transforming the way you interact with your library, one click at a time!</p>
            <a href="signup.php" class="btn">Join Now</a>
        </div>
    </section>

    <!-- Quick Info -->
    <section class="quick-info">
        <p id="scrolling">* Quick Returns * Admin Messaging * 24/7 Access * Easy Reservations * Instant Renewals *</p>
    </section>

    <section class="unlock">
        <h1 style="color: #2D7DD2;">Unlock the world of books!</h1>
        <h2>Million Library Team</h2>
    </section>

    <img src="index_img/library1.jpg" alt="" style="margin: 20px 0px 0px 150px;">

    <!-- Stats Section -->
    <section class="stats">
        <div class="stat">
            <h3>1,000+</h3>
            <p>Happy Readers</p>
        </div>
        <div class="stat">
            <h3>500+</h3>
            <p>Books Available</p>
        </div>
        <div class="stat">
            <h3>24/7</h3>
            <p>Support Anytime</p>
        </div>
    </section>

    <img src="index_img/library2.jpg" alt="Library Image 2" style="margin: 20px 0px 0px 150px; width: 1200px;">

    <div class="welcome-section">
        <div class="text-section">
            <h1>Welcome to Million <br>Library!</h1>
            <p>At Million Library, we believe in making reading accessible and fun for everyone! Our library management system is designed to streamline your experience, making it easier than ever to reserve, renew, and return books. Say goodbye to the old ways of library management and hello to a new era of convenience!</p>
            <p>Our team of dedicated students has crafted this system as part of our university project, and we’re excited to share it with you. We’re not just a library; we’re a community of book lovers, and we want you to be a part of it!</p>
            <p>With features that allow users to send requests and receive messages from admins, we’re here to ensure that your library experience is smooth and enjoyable. Dive into the world of books with us!</p>
        </div>
        <div class="image-section">
            <img src="index_img/library3.jpg" alt="Library Image">
        </div>
    </div>

    <div class="library-section" id="services">
        <h1>Library in Action!</h1>
        <div class="image-container">
            <div class="image-box">
                <img src="index_img/image1.jpeg" alt="Library Shelf">
            </div>
            <div class="image-box">
                <img src="index_img/image2.png" alt="Stack of Books">
            </div>
            <div class="image-box">
                <img src="index_img/image3.jpg" alt="Library Ladder">
            </div>
            <div class="image-box">
                <img src="index_img/image4.jpg" alt="Bookshelf Close-up">
            </div>
        </div>
    </div>

    <!-- Action Section -->
    <section class="action">
        <h2>Join Our Bookish Adventure!</h2>
        <div class="social-icons">
            <a href="#"><img src="index_img/facebook.jpeg" alt="Facebook"></a>
            <a href="#"><img src="index_img/insta.jpeg" alt="Twitter"></a>
            <a href="#"><img src="index_img/twitter.jpeg" alt="Instagram"></a>
            <a href="#"><img src="index_img/linkedIn.jpeg" alt="LinkedIn"></a>
        </div>
    </section>

    <div class="get-in-touch">
        <a href="#" class="contact-button">GET IN TOUCH</a>
    </div>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="contact-info">
            <h1>Contact Us</h1>
            <p><strong>Phone:</strong> 041 123 4567</p>
            <p><strong>Email:</strong> info@millionlibrary.com</p>
            <p><strong>Address:</strong> 123 Main Street, Colombo 11</p>
            <p><strong>Working Hours:</strong> Mon-Fri: 9am - 5pm</p>
        </div>
        <div class="contact-map">
            <img src="index_img/map.jpg" alt="Map of Colombo" />
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p style="font-size: 30px;">Million Library</p><br>
        <p style="font-size: 20px;">OLMS</p>
        <p style="margin-left: 600px;">&copy; 2024 Million Library. All rights reserved.</p>
    </footer>

    <script src="index.js"></script>

</body>
</html>
>>>>>>> bb55a305e516887dbbf3fc64882d3a1032569e84
