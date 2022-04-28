<?php
session_start();
include_once 'DB_Connection.php';
	# verify if we get posted input, other wise will give error
	if ( !isset($_POST['AdminUserName'], $_POST['AdminPassword']) ) {
		exit('Please fill both the AdminUserName and AdminPassword fields!');
	}
	
	// SQL statement will prevent SQL injection.
	if ($stmt_Adm = $conn->prepare('SELECT id, password FROM login_table WHERE username = ? AND id=1')) {
		
		// Bind parameters
		$stmt_Adm->bind_param('s', $_POST['AdminUserName']);
		$stmt_Adm->execute();
		$stmt_Adm->store_result();
		
		if ($stmt_Adm->num_rows > 0) {
			$stmt_Adm->bind_result($id, $AdminPassword);
			$stmt_Adm->fetch();

			if ($_POST['AdminPassword'] === $AdminPassword) {

				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['AdminUserName'];
				$_SESSION['id'] = $id;
				header('Location: ../AdminPage.php');
			} else {
				// Incorrect AdminPassword
				echo '<script>alert("usernamee or password is wrong")</script>';
			}
			} else {
				// Incorrect AdminUserName
				echo '<script>alert("usernamee or password is wrong")</script>';
			}

		$stmt_Adm->close();
	}
	?>