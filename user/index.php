<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OLMS</title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="#">OLMS </a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        <ul class="nav pull-right">
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="images/user.png" class="nav-avatar" />
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="index.php">My Profile</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <div class="sidebar">
                            <ul class="widget widget-menu unstyled">
                                <li class="active"><a href="#"><i class="menu-icon icon-home"></i>Home</a></li>
                                <li><a href="message.php"><i class="menu-icon icon-inbox"></i>Messages</a></li>
                                <li><a href="#"><i class="menu-icon icon-book"></i>All Books</a></li>
                                <li><a href="#"><i class="menu-icon icon-tasks"></i>Previously Borrowed Books</a></li>
                                <li><a href="#"><i class="menu-icon icon-list"></i>Currently Reserved Books</a></li>
                            </ul>
                            <ul class="widget widget-menu unstyled">
                                <li><a href="#"><i class="menu-icon icon-signout"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="span9">
                        <center>
                            <div class="card" style="width: 50%;"> 
                                <img class="card-img-top" src="images/profile2.png" alt="Card image cap">
                                <div class="card-body">
                                    <h1 class="card-title"><center>David Fernando</center></h1>
                                    <p><b>Email ID: </b>davidfer@gmail.com</p>
                                    <p><b>Roll No: </B>004</p>
                                    <p><b>Category: </b>Student</p>
                                    <p><b>Mobile number: </b>+94 76 1234567</p>
                                </div>
                            </div>
                            <br>
                            <a href="#" class="btn btn-primary">Edit Details</a>    
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="container">
                <b class="copyright">&copy; 2024 Library Management System </b>All rights reserved.
            </div>
        </div>

        <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="scripts/common.js" type="text/javascript"></script>
    </body>

</html>