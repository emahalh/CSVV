<?php
    include_once "./PHP BackEnd/DB_Connection.php";
?>

<!DOCTYPE html>
<html>
<head>

	<title>CSVV Support</title>
	<link rel="stylesheet" href="./CSS/bootstrap.min.css">
	<link rel="stylesheet" href="./CSS/bootstrap-theme.css" media="screen">
	<link rel="stylesheet" href="./CSS/style.css">
    
</head>

<body>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
				<a class="navbar-brand" href="index.html">
					<img class="logo-dim" src="./Images/Common/logo.png" alt="logo"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right mainNav">
					<li><a href="index.html">Home</a></li>
					<li><a href="about.html">About</a></li>
					<li><a href="Samples.html">Samples</a></li>
					<li class="active"><a href="Support.php">Support</a></li>
					<li><a href="Login.html">Login</a></li>

				</ul>
			</div>
		</div>
	</div>
	<!-- /.navbar -->

	<header id="head" class="secondary">
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<h1>Support Team</h1>
				</div>
			</div>
		</div>
	</header>

	<!-- container -->
	<div class="container">
		<div class="row">
					<div class="col-md-6">
						<h3 class="section-title">Raise Ticket</h3>
						<p>
						In case you are facing any problem in CSVV system, kindly raise ticket with specific description in form below: 
						</p>
						
						<form class="form-light mt-20" role="form" action="./PHP BackEnd/Insert_Ticket.php" method="post">
							<div class="form-group">
								<label >Name</label>
								<input type="text" class="form-control" placeholder="Your name" name="name" required>
							</div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" placeholder="Email address" name="email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" placeholder="Phone number" name="phone" required>
                                        </div>
                                    </div>
                                </div>
							<div class="form-group">
								<label>Subject</label>
								<input type="text" class="form-control" placeholder="Subject" name="subject" required>
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" id="message" placeholder="Write you description here..." style="height:100px;" name="description" required></textarea>
							</div>
							<button type="submit" class="submitbtn" name="submit">Submit</button><p><br/></p>
						</form>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-6">
								<h3 class="section-title">Our Address</h3>
								<div class="Support-info">
									<h5>Address</h5>
									<p>Saudi Arabia-Jeddah City</p>
									
									<h5>Email</h5>
									<p>s180131320@seu.edu.sa</p>
                                    <p>s180209531@seu.edu.sa</p>
                                    <p>s180362719@seu.edu.sa</p>
									
									<h5>Phone</h5>
									<p>+966 xx xxx xx</p>
								</div>
							</div>
							<div class="col-md-6">
								<h3 class="section-title">Working Time</h3>
								<div class="Support-info">
									<h5>Sunday - Thursday</h5>
									<p>08:00 AM - 5:00 PM</p>
									
									<h5>Friday</h5>
									<p>Closed</p>
									
									<h5>Saturday</h5>
									<p>Closed</p>
								</div>
							</div>
						</div>
							
					</div>  
		</div>
        <div class="row">
            <div class="ticketRetive">
                <h3 class="section-title">Tickets Status :</h3>
                    <div class="ticketTable">
                        <?php
                        include './PHP BackEnd/DB_Connection.php';
                        $sql = "SELECT id, Name, Email, Phone, Subject, Creation_Date, Status FROM tickets";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<table style='border:4px solid black;Font-size:12px;Font-Weight:bold;background:white;'>
                            <tr style='text-align: center; font-family: serif; border:4px solid black; font-size: 20px; background-color:#1778b9; color: white; '>
                                <th >ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>";
                        // output data of each row
                            while($row = $result->fetch_assoc()) {
                            echo "<tr style='text-align: center;font-family: serif; font-size: 15px'>
                                <td>".$row["id"]."</td>
                                <td>".$row["Name"]."</td>
                                <td>".$row["Email"]."</td>
                                <td>".$row["Phone"]."</td>
                                <td>".$row["Subject"]."</td>
                                <td>".$row["Creation_Date"]."</td>
                                <td>".$row["Status"]."</td>
                                </tr>";
                            }
                                echo "</table>";
                                } else {
                                    echo "0 results";
                                    }
                                    $conn->close();
                                ?>
                            </div> 
            </div> 
        </div>

	<!-- /container -->

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
							<a href="Login.html">Login</a>
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