<?php

	session_start();
	require_once "config.php";
	$db = new mysqli("localhost", "root", "", "rrs");
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
	}



	$msg = "";

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		if(isset($_POST['submit'])) {

			$guest = preg_replace("#[^0-9]#", "", $_POST['guest']);
			$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
			$phone = preg_replace("#[^0-9]#", "", $_POST['phone']);
			$date_res = htmlentities($_POST['date_res'], ENT_QUOTES, 'UTF-8');
			$time = htmlentities($_POST['time'], ENT_QUOTES, 'UTF-8');
			$suggestions = htmlentities($_POST['suggestions'], ENT_QUOTES, 'UTF-8');

			if($guest != "" && $email && $phone != "" && $date_res != "" && $time != "" && $suggestions != "") {

				//Check for remaining table space;
				$table_array = array();
				$mtime = strftime("%H", time());
				$mdate = strftime("%Y-%m-%d", time());
				$get_table_count = $db->query("SELECT global_amt FROM Globals");
				$row_count = $get_table_count->fetch_assoc();
				$table_count = $row_count['global_amt'];
				$fetch = $db->query("SELECT * FROM reservation");
				if($fetch->num_rows) {
					while($row_fetch = $fetch->fetch_assoc()) {
						if(($row_fetch['date_res'] >= $mdate) && ($row_fetch['time'] >= $mtime)) {
							$table_array[] = $row_fetch['reserve_id'];
						}
					}
				}
				echo(count($table_array));
				if(count($table_array) < $table_count) {
					$check = $db->query("SELECT * FROM reservation WHERE no_of_guest='".$guest."' AND email='".$email."' AND phone='".$phone."' AND date_res='".$date_res."' AND time='".$time."' LIMIT 1");

					if($check->num_rows) {

						$msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>You have already placed a reservation with the same information</p>";

					}else{

						$insert = $db->query("INSERT INTO reservation(no_of_guest, email, phone, date_res, time, suggestions) VALUES('".$guest."', '".$email."', '".$phone."', '".$date_res."', '".$time."', '".$suggestions."')");

						if($insert) {

							$ins_id = $db->insert_id;

							$reserve_code = "RRS_$ins_id".substr($phone, 3, 8);

							$msg = "<p style='padding: 15px; color: green; background: #eeffee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Reservation placed successfully. Your reservation code is $reserve_code </p>";

						}else{

							$msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Could not place reservation. Please try again</p>";

						}

					}
				}else{

					$msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>No table space available.Please check back after one hour</p>";

				}

			}else{

				$msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Incomplete form data or Invalid data type</p>";

				//print_r($_POST);

			}

		}

	}

?>

<!Doctype html>

<html lang="en">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<meta name="description" content="" />

<meta name="keywords" content="" />

<head>

<title>RRS</title>
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

</head>

<body>


<div class="parallax" onclick="remove_class()">

	<div class="parallax_head">

		<h2>Reserve</h2>
		<h3>Table Space</h3>

	</div>

</div>

<div class="content" onclick="remove_class()">

	<div class="inner_content">

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="hr_book_form">

			<h2 class="form_head">BOOK A TABLE</h2>
			<p class="form_slg">We offer you the best reservation services</p>

			<?php echo "<br/>".$msg; ?>

			<div class="left">

				<div class="form_group">

					 <label>No of Guest</label>
					<input type="number" placeholder="How many guests" min="1" name="guest" id="guest" required>

				</div>

				<div class="form_group">

					<label>Email</label>
					<input type="email" name="email" placeholder="Enter your email" required>

				</div>

				<div class="form_group">

					<label>Phone Number</label>
					<input type="text" name="phone" placeholder="Enter your phone number" required>

				</div>

				<div class="form_group">

					<label>Date</label>
					<input type="date" name="date_res" placeholder="Select date for booking" required>

				</div>

				<div class="form_group">

					<label>Time</label>
					<input type="time" name="time" placeholder="Select time for booking" required>

				</div>


			</div>

			<div class="left">

				<div class="form_group">

                    <label>Suggestions <small><b>(E.g No of Plates, How you want the setup to be)</b></small></label>
					<textarea name="suggestions" placeholder="Enter Your Suggestions" required></textarea>

				</div>

				<div class="form_group">

					<input type="submit" class="submit" name="submit" value="MAKE YOUR BOOKING" />

				</div>

			</div>

			<p class="clear"></p>

		</form>

	</div>

</div>
<p>
	<center>
<a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
</center>
</p>

<div class="content" onclick="remove_class()">

	<div class="inner_content">

		<div class="contact">

			<div class="left">

				<h3><b>LOCATION</b></h3>
				<p>Near abcd xxxx</p>
				<p>xxxx State</p>

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
