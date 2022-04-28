<?php
session_start();
include_once 'DB_Connection.php';

if(isset($_POST['submit']))
{    
     $name = $_POST['name'];
     $email = $_POST['email'];
     $phone = $_POST['phone'];
	 $subject = $_POST['subject'];
	 $description = $_POST['description'];
     
	 
	 $sql = "INSERT INTO tickets (Name, Email, Phone, Subject, Description) VALUES ('$name','$email','$phone','$subject','$description')";
     if (mysqli_query($conn, $sql)) {
        echo "<script>alert('New record has been added successfully!');</script>";
     } else {
        echo "<script>alert('Failure.');</script>" . mysqli_error($conn);
     }
     mysqli_close($conn);
}
?>