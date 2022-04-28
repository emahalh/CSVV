<?php

    $DATABASE_HOST = "localhost";
    $DATABASE_USER = "root";
    $DATABASE_PASS = "";
    $DATABASE_NAME = "csvv_db";

// Try and connect using the info above.
	$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// If there is an error with the connection, stop the script and display the error.
	if ( mysqli_connect_errno()){
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
