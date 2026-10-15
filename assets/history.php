<?php
require("../include/config.inc.php");
require("../include/classes/db/db.php");

// Define the variables
$state = getState();

function getState() {
        $db = DB::get();

        $state = $db->query("SELECT state FROM state ORDER BY id DESC LIMIT 1");

        return $state;
}

function getActions() {
	$db = DB::get();
	$result = $db->query("SELECT * FROM state ORDER BY id DESC");

	return $result;
}

$states = getActions();

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Xenon Boostrap Admin Panel" />
	<meta name="author" content="" />
	
	<title>Spacestate Override</title>

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
	<link rel="stylesheet" href="assets/css/fonts/linecons/css/linecons.css">
	<link rel="stylesheet" href="assets/css/fonts/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/xenon-core.css">
	<link rel="stylesheet" href="assets/css/xenon-forms.css">
	<link rel="stylesheet" href="assets/css/xenon-components.css">
	<link rel="stylesheet" href="assets/css/xenon-skins.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.1.min.js"></script>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	
</head>
<body class="page-body">

	<div class="page-container">
		
		<div class="main-content">
					
			<div class="page-title">
				
				<div class="title-env">
					<h1 class="title">Spacestate Override | Spacestate History</h1>
					<p class="description">&quot;For when david forgot the spacestate once again&quot;</p>
				</div>
				<div class="breadcrumb-env">
					<ol class="breadcrumb bc-1">
						<li>
							<i>
								<?php echo "We are currently : " . $state[0]->state; ?>
							</i>
						</li>
					</ol>
				</div>				
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-head"><h3>Spacestate History</h3>Click <a href="index.php"><b>here</b></a> for spacestate override</div>
						<div class="panel-body">
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									$("#spacestate").dataTable({
										aLengthMenu: [
											[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
										]
									});
								});
							</script>
						<table id="spacestate" class="table table-bordered table-striped table-condensed table-hover">
							<thead>
								<th>State</th>
								<th>User</th>
								<th>Method</th>
								<th>Time</th>
								<th>Action Sent</th>
							</thead>
							<tbody>
							<?php foreach($states as $state) {
							echo "<tr>";
								echo "<td>" . $state->state . "</td>";
								echo "<td>" . $state->user . "</td>";
								echo "<td>" . $state->method . "</td>";
								echo "<td>" . $state->timestamp . "</td>";
								echo "<td>" . $state->actiondone . "</td>";
							echo "</tr>";
							} ?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>

			<!-- Main Footer -->
			<!-- Choose between footer styles: "footer-type-1" or "footer-type-2" -->
			<!-- Add class "sticky" to  always stick the footer to the end of page (if page contents is small) -->
			<!-- Or class "fixed" to  always fix the footer to the end of page -->
			<footer class="main-footer sticky footer-type-1">
				
				<div class="footer-inner">
				
					<!-- Add your copyright text here -->
					<div class="footer-text">
						&copy; 2016
						<strong>Pixelbar</strong> 
						theme by <a href="http://laborator.co" target="_blank">Laborator</a>
					</div>
					
					
					<!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
					<div class="go-up">
					
						<a href="#" rel="go-top">
							<i class="fa-angle-up"></i>
						</a>
						
					</div>
					
				</div>
				
			</footer>
		</div>
		
	</div>
	
	<!-- Bottom Scripts -->
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/TweenMax.min.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/xenon-api.js"></script>
	<script src="assets/js/xenon-toggles.js"></script>

	<script src="assets/js/datatables/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/datatables/dataTables.bootstrap.js"></script>

	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/xenon-custom.js"></script>

</body>
</html>
