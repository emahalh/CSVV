<?php
include_once "./PHP BackEnd/DB_Connection.php";
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
					<h1>Admin Search Page</h1>
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

	<!-- search box-->
	<div class="main_container">
		<form method="post" class="search-bar">
			<input type="text" placeholder="Student Name or ID" name="search" required>
			<button type="submit" name="submit"><img src="./Images/Search Page/search.png"></button>
		</form>
	</div>
	<div class="container">
		<div class="row">
			<div class="ticketRetive">
				<h3 class="section-title">Result of search :</h3>
				<div class="searchtTable">
					<?php
					include './PHP BackEnd/DB_Connection.php';

					if (isset($_POST["submit"])) {
						$str = $_POST["search"];
						$sql = "SELECT * from student_table WHERE Student_ID = '$str' OR Student_Name = '$str'";

						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
							echo "<table style='border:4px solid black;Font-size:12px;Font-Weight:bold;background:white;'>
													<tr style='text-align: center; font-family: serif; border:4px solid black; font-size: 20px; background-color:#1778b9; color: white; '>
														<th>Student_ID</th>
														<th>Student_Name</th>
														<th>Vaccine_Status</th>
														<th>Doses_Count</th>
														<th>School_Lvl</th>
														<th>Parent_Name</th>
														<th>Parents_Contact_No</th>
													</tr>";
							while ($row = $result->fetch_assoc()) {
								echo "<tr style='text-align: center;font-family: serif; font-size: 15px'>
														<td>" . $row["Student_ID"] . "</td>
														<td>" . $row["Student_Name"] . "</td>
														<td>" . $row["Vaccine_Status"] . "</td>
														<td>" . $row["Doses_Count"] . "</td>
														<td>" . $row["School_Lvl"] . "</td>
														<td>" . $row["Parent_Name"] . "</td>
														<td>" . $row["Parents_Contact_No"] . "</td>
														</tr>";
							}
							echo "</table>";
						} else {
							echo "0 records";
						}

						$conn->close();
					}
					?>
				</div>
			</div>
		</div>
	</div>
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