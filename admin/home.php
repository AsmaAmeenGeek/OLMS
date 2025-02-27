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
                  <i class='bx bx-chat' ></i>
                </span>
                <span class="navlink">Messages</span>
              </a>
            </li>
            
             <li class="item">
              <a href="#" class="nav_link submenu_item">
                <span class="navlink_icon">
                  <i class='bx bxs-user-detail' ></i>
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
              <a href="#" class="nav_link submenu_item">
                <span class="navlink_icon">
                  <i class='bx bx-right-indent'></i>
                </span>
                <span class="navlink">Reserve/Return<br>Requests</span>
              </a>
            </li>
            
             <li class="item">
              <a href="#" class="nav_link submenu_item">
                <span class="navlink_icon">
                  <i class='bx bx-list-ul'></i>
                </span>
                <span class="navlink">Currently Issued<br>Books</span>
              </a>
            </li>
           
             <li class="item">
              <a href="logout.php" class="nav_link submenu_item">
                <span class="navlink_icon">
                  <i class='bx bx-log-out-circle' ></i>
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

    <!-- Main Section -->
    <section class="home_content">
        <!-- Banner -->
        <img src="images/bg.jpg" class="banner"></div>

        <!-- About Section -->
        <div class="about-library">
            <h2>Welcome to the Million Library Admin Portal!</h2>
            <p>As the backbone of our library management system, you play a crucial 
                role in maintaining smooth operations and ensuring a seamless 
                experience for our users. From managing book inventories and handling 
                user requests to overseeing reservations and renewals, this platform 
                puts everything you need at your fingertips. Our system is designed 
                to simplify administrative tasks, allowing you to focus on what 
                matters most—enhancing the library experience. We’re thrilled to 
                have you as part of our team, working together to foster a vibrant, 
                accessible library for everyone. Let's keep the world of books running 
                efficiently and effectively!</p>
        </div>
    </section>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div>
                <h3>Million Library</h3>
                <p>OLMS</p>
            </div>
            <div>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Terms and conditions</a></li>
                </ul>
            </div>
            <div>
                <ul>
                    <li><a href="#">Plans</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
            </div>
        </div>
    </footer>
    
    <p style="margin-left: 650px; margin-top: 20px;">&copy; 2024 Million Library. All rights reserved.</p>

    <script src="script.js"></script>
</body>

</html>