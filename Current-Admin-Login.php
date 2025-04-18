<?php
//Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
// if(isset($_SESSION["loggedin_admin"]) && $_SESSION["loggedin_admin"] === true){
//   header("location: Admin-Dashboard.php");
//   exit;
// }

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'electricity_water');

$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Define variables and initialize with empty values
$admin_username = $admin_password = "";
$username_err = $password_err = "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["admin_username"]))) {
        $username_err = "Please enter the username.";
    } else {
        $admin_username = trim($_POST["admin_username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["admin_password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $admin_password = trim($_POST["admin_password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement

        $sql = "SELECT admin_id, admin_username, admin_password FROM admin WHERE admin_username = ?";

        if ($stmt = $link->prepare($sql)) {


            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $admin_username;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows() == 1) {
                    // Bind result variables
                    $stmt->bind_result($admin_id, $admin_username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($admin_password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin_admin"] = true;
                            $_SESSION["admin_id"] = $admin_id;
                            $_SESSION["admin_uname"] = $admin_username;

                            // Redirect user to welcome page
                            header("location: Current/Admin/Admin-Dashboard.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $link->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ONLINE-EBMS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="Appland/assets/img/favicon.png" rel="icon">
    <link href="Appland/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="Appland/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="Appland/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="Appland/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="Appland/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="Appland/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="Appland/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="Appland/assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Appland - v4.3.0
  * Template URL: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top  header-transparent ">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="logo">
                <h1><a href="Appland/index.html">ONLINE-EBMS</a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="Appland/index.php">Home</a></li>
                    <li><a class="nav-link scrollto active">Log in</a></li>
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                    <li><a class="getstarted scrollto" href="#features">Get Started</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <main id="main" style="align-items: center;"><br>
        <section class="inner-page">
            <div class="row gutters-sm justify-content-center">
                <div class="col-md-6">
                    <div class="card border shadow-lg p-4">
                        <div class="container">
                            <div class="card-body">
                                <div class="row">
                                <div class=" col-md-10">
                                    <h2>Admin Login - Electricity Bill</h2>
                                        <p>Please fill in your admin credentials to login.</p>
                                    </div>
                                    <div class=" col-md-3"><img src="images/ebd-logo.jpeg"></div>

                                </div>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                    <div class="form-group" style="opacity: 0.8;">
                                        <label>Admin Username</label>
                                        <input type="text" name="admin_username" class="form-control" value="<?php echo $admin_username; ?>">
                                        <span class="help-block"><?php echo $username_err; ?></span>
                                    </div><br>
                                    <div class="form-group" style="opacity: 0.8;">
                                        <label>Password</label>
                                        <input type="password" name="admin_password" class="form-control">
                                        <span class="help-block"><?php echo $password_err; ?></span>

                                    </div><br>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-md btn-block myBtn" value="Login" style="float: right;background-color: #5777ba;color: white;width: 25%;">
                                    </div>
                                    <div class="forgot float-right">
                                        <a href="Current/Admin/Forgot-Password.php">Forgot Password?</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </main><!-- End #main -->

    <section id="features" class="features">
      <div class="container">

<!-- App feature section-->
        <div class="section-title">
          <h2>Features</h2>
          <p>We introduce an online system to manage electrical billing for the administrator and customer.
          </p>
        </div>

        <div class="row no-gutters">
          <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
            <div class="content d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-md-6 icon-box" data-aos="fade-up">
                  <i class="bx bx-receipt"></i>
                  <h4>Online Bill Management</h4>
                  <p>Paperless bill management system</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-money"></i>
                  <h4>Online Payment Portal</h4>
                  <p>User can pay their bills through online</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <i class="bx bx-images"></i>
                  <h4>Upload Meter Image</h4>
                  <p>User needs to upload an image of the meter before the deadline</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                  <i class="bx bx-chart"></i>
                  <h4>Analyze the Usage</h4>
                  <p>User can analyze the electricity usage in past months</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                  <i class="bx bx-bell"></i>
                  <h4>Get Updated</h4>
                  <p>User can view the notifications and reminders send by administrators</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                  <i class="bx bx-lock"></i>
                  <h4>Privacy</h4>
                  <p>Privacy of all user data will be maintained</p>
                </div>
              </div>
            </div>
          </div>
          <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2"
            data-aos="fade-left" data-aos-delay="100">
            <img src="ONLINE-EBMS/Appland/assets/img/features.svg" class="img-fluid" alt="">
          </div>
        </div>

      </div>
    </section><!--end feature section-->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Contact</h2>
                <p>Contact us for any issue through below ways.</p>
            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6 info">
                            <i class="bx bx-map"></i>
                            <h4>Address</h4>
                            <p>House No.08/A Thana road, Thana para,<br>Sirajganj Sadar-6700 Sirajganj</p>
                        </div>
                        <div class="col-lg-6 info">
                            <i class="bx bx-phone"></i>
                            <h4>Call Us</h4>
                            <p>+880 1757 444444<br>+021 2 456 789</p>
                        </div>
                        <div class="col-lg-6 info">
                            <i class="bx bx-envelope"></i>
                            <h4>Email Us</h4>
                            <p>ocawbms2021@gmail.com</p>
                        </div>
                        <div class="col-lg-6 info">
                            <i class="bx bx-time-five"></i>
                            <h4>Working Hours</h4>
                            <p>24 Hour service</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <form action="forms/contact.php" method="post" role="form" class="php-email-form" data-aos="fade-up">
                        <div class="form-group">
                            <input placeholder="Your Name" type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="form-group mt-3">
                            <input placeholder="Your Email" type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="form-group mt-3">
                            <input placeholder="Subject" type="text" class="form-control" name="subject" id="subject" required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea placeholder="Message" class="form-control" name="message" rows="5" required></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit">Send Message</button></div>
                    </form>
                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->


    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>Online-EBMS</h3>
                        <p>
                            House No.08/A Thana road, Thana para <br>
                            Sirajganj Sadar-6700 Sirajganj<br><br>
                            <strong>Phone:</strong> +880 1757 444444, +021 2 456 789<br>
                            <strong>Email:</strong> online-ebms@gmail.com<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">DBA</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Social Networks</h4>
                        <p>See more of us from social media networks</p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container py-4">

            <div class="credits">
                <div class="copyright">
                    &copy; Copyright <strong><span>ONLINE-EBMS</span></strong>. All Rights Reserved
                </div>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="Appland/assets/vendor/aos/aos.js"></script>
    <script src="Appland/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="Appland/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="Appland/assets/vendor/php-email-form/validate.js"></script>
    <script src="Appland/assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Template Main JS File -->
    <script src="Appland/assets/js/main.js"></script>
    <style>
        .help-block {
            color: red;
        }
    </style>

</body>

</html>