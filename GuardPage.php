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

	<title>CSVV Guard Page</title>
	<link rel="stylesheet" href="./CSS/bootstrap.min.css">
	<link rel="stylesheet" href="./CSS/bootstrap-theme.css" media="screen">
	<link rel="stylesheet" href="./CSS/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  

</head>

<body>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse ">
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
				<a class="navbar-brand" href="index.html">
					<img class="logo-dim" src="./Images/Common/logo.png" alt="logo"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a href="index.html">Home</a></li>
					<li><a href="about.html">About</a></li>
					<li><a href="Samples.html">Samples</a></li>
					<li><a href="Support.php">Support</a></li>
					<li class="active"><a href="GuardPage.php">Guard</a></li>
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
					<h1>Guard Page</h1>
				</div>
			</div>
		</div>
	</header>
  
	<!-- /Header -->

  <!-- CAM section -->
  <section class="container">
    <div id="dateTime"></div>


<script src="./JS/LiveDateTime.js"></script>
	<br><br>
	<div class=row>
		<div class='col-md-6'>
			<img id='video_feed' src = "http://127.0.0.1:5000/video_feed">
			<canvas id="canvas" width="640" height="480"></canvas>
			<button class="btn btn-danger" id='btn_toggle' onclick="ClickCapture('Stop')">Stop</button>
		</div>
		<div class='col-md-6'>
			<div class='col-md-8'>
				<img id="img" src=''>
			</div>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<div class='col-md-8'>
				Student Name : <span id='std_name'></span><br>
				Vaccine Status : <span id='Vaccine_Status'></span><br>
				Doses Count : <span id='Doses_Count'></span><br>
			</div>
			<br><br><br><br>
			<div class="col-md-8">
				<div style="display: none;" id='alert' class="alert alert-danger alert-dismissible">
				</div>
			</div>
			
		</div>

	</div>

    </section>
  <!-- /CAM access -->

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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	let image_capture = setInterval(function(){
		// here ajax is responsible for calling api from Flask
		$.ajax({
			url: 'http://127.0.0.1:5000/image_capture',
			type: 'GET',
			success: function (data){
				debugger;
				var image = new Image();
				image.onload = function () {
					document.getElementById('img').setAttribute('src', this.src);
				};
				image.src = './shots/' + data;
			}
		})
	// set time interval for call image capture 
	},3000);


	let take_attendance = setInterval(function(){
		// here ajax is responsible for calling api from Flask
		$.ajax({
			url: 'http://127.0.0.1:5000/take_attendance',
			type: 'GET'
		})
	// set time interval for call image capture 
	},2000);


	let interval = setInterval(function(){
		// caling api here for face recognition app
		$.ajax({
			url: 'http://127.0.0.1:5000/get_current_student_data',
			type: 'GET',
			success: function (data){
				debugger;
				// receiving data from face recognition app
				if(data === 'unknown'){
					document.getElementById('alert').innerText = 'The Student is not Registered!!'
					document.getElementById('alert').style.display = 'block'
					document.getElementById('std_name').innerText =  'No data Found!!'
					document.getElementById('Vaccine_Status').innerText =  'No data Found!!'
					document.getElementById('Doses_Count').innerText =  'No data Found!!'
					$('#alert').removeClass('alert-success').addClass('alert-danger ');
					$.ajax({
						url: 'http://127.0.0.1:5000/add_event',
						type: 'POST',
						data: {'Stud_Access_Status': 'Not Registered', 'Sys_Status': 'ON', 'Notification': 'Yes', 'Alarm': 'Yes'},
					})
				}else{
					document.getElementById('std_name').innerText =  data.Student_Name
					document.getElementById('Vaccine_Status').innerText =  data.Vaccine_Status
					document.getElementById('Doses_Count').innerText =  data.Doses_Count

					if(data.Doses_Count != 3){
						document.getElementById('alert').innerText = 'The Student is not vaccineted!!'
						document.getElementById('alert').style.display = 'block'
						$('#alert').removeClass('alert-success').addClass('alert-danger ');
						$.ajax({
							url: 'http://127.0.0.1:5000/add_event',
							type: 'POST',
							data: {'Stud_Access_Status': 'Not Vaccinated', 'Sys_Status': 'ON', 'Notification': 'Yes', 'Alarm': 'Yes'},
						})
					}
					if(data.Doses_Count === 3){
						document.getElementById('alert').innerText = 'Pass'
						document.getElementById('alert').style.display = 'block'
						$('#alert').removeClass('alert-danger').addClass('alert-success ');
						$.ajax({
							url: 'http://127.0.0.1:5000/add_event',
							type: 'POST',
							data: {'Stud_Access_Status': 'Passed', 'Sys_Status': 'ON', 'Notification': 'No', 'Alarm': 'No'},
						})
					}
					
				}
			}
		})
		// for attendance record and vaccine verication set time interval 
	},3000);

	function ClickCapture(btn_val) {
		btn_start = document.getElementById('btn_toggle').innerText
		if(btn_start === 'Start'){
			btn_val = btn_start
		}
		$.ajax({
			url: 'http://127.0.0.1:5000/requests',
			type: 'POST',
			data: {'click': btn_val},
			success: function (data){
				if(data === 'stopped'){
					document.getElementById('btn_toggle').innerHTML = 'Start'
				}
				if(data === 'started'){
					document.getElementById('btn_toggle').innerHTML = 'Stop'
					window.location.href = "GuardPage.php";
				}
			}
		})
	}
</script>
</body>

</html>