<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/main1.css" />
    <link rel="stylesheet" href="admin/assets/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="js/jquery.min.js" ></script>

    <script src="js/myscript.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
  <div class="parallax" onclick="remove_class()">

  	<div class="parallax_head">
      <h2>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. </h2>
        </div>
      </div>
      <div class="content" onclick="remove_class()">

      	<div class="inner_content">
          <div class="content" onclick="remove_class()">

	<a href="reservation.php" class="submit">BOOK A TABLE</a>

</div>

    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>

</div>
</div>
  <div class="content" onclick="remove_class()">

  	<div class="inner_content">

  		<div class="contact">

  			<div class="left">

  				<h3><b>LOCATION</b></h3>
  				<p>Near abcd xxxx </p>
  				<p>xxx State</p>

  			</div>

  			<div class="left">

  				<h3><b>CONTACT</b></h3>
  				<p>88505xxxxx, 94178xxxxx</p>
  				<p>RRS@gmail.com</p>

  			</div>

  			<p class="left"></p>

  			<div class="icon_holder">

  				<a href="#"><img src="image/icons/Facebook.png" alt="image/icons/Facebook.png" /></a>
  				<a href="#"><img src="image/icons/Google+.png" alt="image/icons/Google+.png"  /></a>
  				<a href="#"><img src="image/icons/Twitter.png" alt="image/icons/Twitter.png"  /></a>

  			</div>

  		</div>

  	</div>

  </div>

  <div class="footer_parallax" onclick="remove_class()">

  	<div class="on_footer_parallax">

  		<p>&copy; <?php echo strftime("%Y", time()); ?> <span>MyRestaurant</span>. All Rights Reserved</p>

  	</div>

  </div>
  <!--===============================================================================================-->
  <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/bootstrap/js/popper.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/daterangepicker/moment.min.js"></script>
  <script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
  <script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
  <script src="js/main.js"></script>
</body>
</html>
