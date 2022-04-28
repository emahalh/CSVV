<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: Login.html');
	exit;
}
?>

<!DOCTYPE html>
<html>

<head>

	<title>CSVV Admin Page</title>
	<link rel="stylesheet" href="./CSS/bootstrap.min.css">
	<link rel="stylesheet" href="./CSS/bootstrap-theme.css" media="screen">
	<link rel="stylesheet" href="./CSS/style.css">

</head>

<body>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse ">
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
				<a class="navbar-brand" href="index.html">
					<img class="logo-dim" src="./Images/Common/logo.png" alt="logo"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a href="index.html">Home</a></li>
					<li><a href="about.html">About</a></li>
					<li><a href="Samples.html">Samples</a></li>
					<li><a href="Support.php">Support</a></li>
					<li class="active"><a href="AdminPage.php">Admin</a></li>
					<li><a href="./PHP BackEnd/logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /.navbar -->

	<!-- Header -->
  <header id="head" class="secondary">
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<h1>Admin Page</h1>
				</div>
			</div>
		</div>
	</header>
	<!-- /Header -->

<!--menu bar -->
<div class="menu-bar-admin">
        <div class="div-menu"><a href="Report Page.html">Report</a></div>
        <div class="div-menu"><a href="Search Page.php">Search</a></div>
<div>
    <input type="checkbox" class="toggle" id="rounded">
    <label for="rounded" data-checked="Notification on" class="rounded" data-unchecked="Notification off"></label>
</div>
 </div>
 <br><br><br><br>
<div class="menu-bar-just-admin">
        <div><a href="Report Page.html"><button class="div-botton">Report</button</a></div>
        <div><a href="Search Page.php"><button class="div-botton">Search</button</a></div>
<div class="div-menu">
    <input type="checkbox" class="toggle" id="rounded">
    <label for="rounded" data-checked="Notification on" class="rounded" data-unchecked="Notification off"></label>
</div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<!--/drop down -->

<footer id="footer">
	<div class="footer2">
		<div class="container">
			<div class="row">
				<div class="col-md-6 panel">
					<div class="panel-body">
						<p class="simplenav">
							<a href="index.html">Home</a>
							<a href="about.html">About</a>
							<a href="Samples.html">Samples</a>
							<a href="Support.php">Support</a>
							<a href="./PHP BackEnd/logout.php">Logout</a>
						</p>
					</div>
				</div>

				<div class="col-md-6 panel">
					<div class="panel-body">
						<p class="text-right">
							Copyright &copy; 2022. Stundent Project by <a href="https://seu.edu.sa/" rel="develop">Saudi Electronic University</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>


</body>
</html>