<?php

// connect using the info above.
echo '<script>alert("Welcome to Geeks for Geeks")</script>'; 

$con = mysqli_connect('localhost', 'root', '', 'blood clinic');
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['Donor_ID'], $_POST['Date']))
	exit('Please complete the registration form!');

// Make sure the submitted registration values are not empty.
if (empty($_POST['Donor_ID']) || empty($_POST['Date']))
	exit('Please complete the registration form');

// We need to check if the account with that username exists.
if ($stmt = $con->prepare('DELETE FROM apointments  WHERE Donor_ID = ? AND Date_Donated= ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('ss', $_POST['Donor_ID'], $_POST['Date']);
	$stmt->execute();
	$stmt->close();
}
$con->close();
?>