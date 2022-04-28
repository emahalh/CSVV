<html> 

 <head>  
  
 <title>Download Page</title>
   
  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
  <link rel="stylesheet" href="../CSS/bootstrap.min.css">
	<link rel="stylesheet" href="../CSS/bootstrap-theme.css" media="screen">
	<link rel="stylesheet" href="../CSS/style.css">
	<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
 
</head> 

 <body>
   
 	<!-- Fixed navbar -->
   <div class="navbar navbar-inverse ">
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
				<a class="navbar-brand" href="../index.html">
					<img class="logo-dim" src="../Images/Common/logo.png" alt="logo"></a>
			</div>
            <div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a href="../index.html">Home</a></li>
					<li><a href="../about.html">About</a></li>
					<li><a href="../Samples.html">Samples</a></li>
					<li><a href="../Support.php">Support</a></li>
					<li class="active"><a href="../AdminPage.php">Admin</a></li>
					<li><a href="logout.php">Logout</a></li>

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
					<h1>Download for Specific Student</h1>
				</div>
			</div>
		</div>
	</header>
	<!-- /Header -->

<!--menu bar -->
<div class="menu-bar-admin">
        <div class="div-menu"><a href="../Report Page.html">Report</a></div>
        <div class="div-menu"><a href="../Search Page.php">Search</a></div>
<div>
    <input type="checkbox" class="toggle" id="rounded">
    <label for="rounded" data-checked="Notification on" class="rounded" data-unchecked="Notification off"></label>
</div>
 </div>

<!-- Download box-->
<div class="container">
<div class="row">
		<div class="ticketRetive">
                <h3 class="section-title">Result of search :</h3>
                    <div class="downloadtTable">
    <?php
						include 'DB_Connection.php';

						if (isset($_POST["dbtn"])) {
						$dte = $_POST["date"];
            			$stid = $_POST["stid"];
			  				$sql = "SELECT log_table.log_id, 
								log_table.Attend_Date, 
								log_table.Student_ID, 
								student_table.Student_Name, 
								student_table.Vaccine_Status, 
								student_table.Doses_Count, 
								student_table.School_Lvl, 
								student_table.Parent_Name, 
								student_table.Parents_Contact_No,
								eventtype_table.Event_ID,
								eventtype_table.Stud_Access_Status
								FROM log_table 
                            	JOIN student_table ON student_table.Student_ID = log_table.Student_ID
                            	JOIN eventtype_table ON eventtype_table.Student_ID = log_table.Student_ID
            					where (log_table.Attend_Date = '$dte') AND (student_table.Student_Name = '$stid' OR student_table.Student_ID = '$stid')
								GROUP BY log_table.Student_ID";
							$result = $conn->query($sql);

						if ($result->num_rows > 0){
							echo "<table class='center' id='specTable' style='border:4px solid black;Font-size:12px;Font-Weight:bold;background:white;'>
                                              <tr style='text-align: center; font-family: serif; border:4px solid black; font-size: 14px; background-color:#1778b9; color: white; '>
                                                <th>log_id</th>
                                                <th>Attend_Date</th>
                                                <th>Student_ID</th>
                                                <th>Student_Name</th>
                                                <th>Vaccine_Status</th>
                                                <th>Doses_Count</th>
                                                <th>School_Lvl</th>
                                                <th>Parent_Name</th>
                                                <th>Parents_Contact_No</th>
                                                <th>Event_ID</th>
                                                <th>Stud_Access_Status</th>
                                              </tr>";
						
							while($row = $result->fetch_assoc() ){
								echo "<tr style='text-align: center;font-family: serif; font-size: 15px'>
											<td>".$row["log_id"]."</td>
											<td>".$row["Attend_Date"]."</td>
											<td>".$row["Student_ID"]."</td>
											<td>".$row["Student_Name"]."</td>
											<td>".$row["Vaccine_Status"]."</td>
											<td>".$row["Doses_Count"]."</td>
											<td>".$row["School_Lvl"]."</td>
											<td>".$row["Parent_Name"]."</td>
											<td>".$row["Parents_Contact_No"]."</td>
											<td>".$row["Event_ID"]."</td>
											<td>".$row["Stud_Access_Status"]."</td>
							  		</tr>";
							}echo "</table>";
						} else {
							echo "0 records";
							}

						$conn->close();
						}
						?>
                          </div>
                      </div>
                  </div>
                  <button type="submit" class="Export-btn" onclick="ExportToExcel('xlsx')">Export</button>
              </div>
   </div>
  </div>  

<script>
// JavaScript function to export the HTML table to excel file
function ExportToExcel(type, fn, dl) {
	var elt = document.getElementById('specTable');
	var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
	return dl ?
		XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
		XLSX.writeFile(wb, fn || ('Spec_Student_Report.' + (type || 'xlsx')));
}
</script>

  <!--/drop down -->

<footer id="footer">
	<div class="footer2">
		<div class="container">
			<div class="row">
				<div class="col-md-6 panel">
					<div class="panel-body">
						<p class="simplenav">
							<a href="../index.html">Home</a>
							<a href="../about.html">About</a>
							<a href="../Samples.html">Samples</a>
							<a href="../Support.php">Support</a>
              <a href="PHP BackEnd/logout.php">Logout</a>
              
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