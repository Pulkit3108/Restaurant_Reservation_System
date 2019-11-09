<?php

	session_start();
	require "includes/functions.php";
	$db = new mysqli("localhost", "root", "", "rrs");
	if(!isset($_SESSION['user'])) {
        header("location: logout.php");
    }

	$table_no = 0;
	$get_table_no = $db->query("SELECT * FROM Globals");
	if($get_table_no->num_rows) {
		$row_no = $get_table_no->fetch_assoc();
		$table_no = htmlentities($row_no['global_amt']);
	}


	$result = "";
	$pagenum = "";
	$per_page = 20;

		$count = $db->query("SELECT * FROM users");

		$pages = ceil((mysqli_num_rows($count)) / $per_page);

		if(isset($_GET['page'])) {

			$page = $_GET['page'];

		}else{

			$page = 1;

		}

		$start = ($page - 1) * $per_page;

		$reserve = $db->query("SELECT * FROM users LIMIT $start, $per_page");

		if($reserve->num_rows) {

			$result = "<table class='table table-hover'>
						<thead>
							<th>S/N</th>
							<th>username</th>

						</thead>
						<tbody>";

			$x = 1;

			while($row = $reserve->fetch_assoc()) {

        $username = $row['username'];


				$result .=  "<tr>
								<td>$x</td>
								<td>$username</td>

								
							</tr>";


				$x++;
			}

			$result .= "</tbody>
						</table>";

		}else{

			$result = "<p style='color:red; padding: 10px; background: #ffeeee;'>No Table reservations available yet</p>";

		}

	if(isset($_GET['delete'])) {

		$delete = preg_replace("#[^0-9]#", "", $_GET['delete']);

		if($delete != "") {

			$sql = $db->query("DELETE FROM reservation WHERE reserve_id='".$delete."'");

			if($sql) {

				echo "<script>alert('Successfully deleted')</script>";

			}else{

				echo "<script>alert('Operation Unsuccessful. Please try again')</script>";

			}

		}


	}

	if(isset($_POST['submit'])) {

		$notable = htmlentities($_POST['number'], ENT_QUOTES, 'UTF-8');

		if($notable == "") {
			echo "<script>alert('No form data sent')</script>";
		}else{
			$update = $db->query("UPDATE Globals SET global_amt='$notable'");

			if($update) {
				echo "<script>alert('Successfully Updated')</script>";
				//header("reservations.php");
			}else{
				echo "<script>alert('Problem encountered. Please try again')</script>";
			}
		}

	}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Restaurant</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />


    <link href="assets/css/style.css" rel="stylesheet" />

	<script>

		function check() {

			return confirm("Are you sure you want to delete this record");

		}

	</script>

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="#000" data-image="assets/img/sidebar-5.jpg">

    <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->


    	<?php require "includes/side_wrapper.php"; ?>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed" style="background: #335eff; ">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar" style="background: #fff;"></span>
                        <span class="icon-bar" style="background: #fff;"></span>
                        <span class="icon-bar" style="background: #fff;"></span>
                    </button>
                    <a class="navbar-brand" href="#" style="color: #fff;">MEMBERS LIST</a>
                </div>
                <div class="collapse navbar-collapse">

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="logout.php" class="btn btn-warning btn-fill">LOG OUT</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>



			<div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">MEMBERS</h4>
                            </div>
                            <div class="content table-responsive table-full-width">

								<?php echo $result; ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <footer class="footer">
            <div class="container-fluid">

                <p class="copyright pull-right">
                    &copy; 2019 <a href="index.php" style="color:#335eff; ">My Restaurant</a>
                </p>
            </div>
        </footer>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>



</html>