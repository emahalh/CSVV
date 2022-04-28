<?php
session_start();
include_once 'DB_Connection.php';
	# verify if we get posted input, other wise will give error
	if ( !isset($_POST['GuardUserName'], $_POST['GuardPassword']) ) {
		exit('Please fill both the GuardUserName and GuardPassword fields!');
	}
	
	// SQL statement will prevent SQL injection.
	if ($stmt_Guard = $conn->prepare('SELECT id, password FROM login_table WHERE username = ? AND id=2')) {
		
		// Bind parameters
		$stmt_Guard->bind_param('s', $_POST['GuardUserName']);
		$stmt_Guard->execute();
		$stmt_Guard->store_result();
		
		if ($stmt_Guard->num_rows > 0) {
			$stmt_Guard->bind_result($id, $GuardPassword);
			$stmt_Guard->fetch();

			if ($_POST['GuardPassword'] === $GuardPassword) {

				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['GuardUserName'];
				$_SESSION['id'] = $id;
				header('Location: ../GuardPage.php');
			} else {
				// Incorrect AdminPassword
				echo '<script>alert("usernamee or password is wrong")</script>';
			}
			} else {
				// Incorrect AdminUserName
				echo '<script>alert("usernamee or password is wrong")</script>';
			}

		$stmt_Guard->close();
	}
	?>