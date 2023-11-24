<?php
// Connect to Database
session_start();

function connectDB() {
	$DATABASE_HOST = 'localhost';
	$DATABASE_USER = 'root';
	$DATABASE_PASS = '';
	$DATABASE_NAME = 'blood clinic';
	// Try and connect using the info above.
	$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	return $con;
}

function errorCheck() {
	if (mysqli_connect_errno()) {
		// If there is an error with the connection, stop the script and display the error.
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}

	// If the data was submitted, isset() function will check if the data exists.
	if (!isset($_POST['username'], $_POST['password'], $_POST['fname'], $_POST['lname'], $_POST['ssn'], $_POST['email'])) {
		// Could not get the data that should have been sent.
		exit('Please complete the registration form!');
	}
	// Make sure the submitted registration values are not empty.
	if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['ssn']) || empty($_POST['email'])) {
		exit('Please complete the registration form');
	}
}

function validateInfo($con) {
	// Check if the account with that username exists.
	if ($stmt = $con->prepare('SELECT Location_ID, password FROM employee WHERE username = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the account exists in the database.
		if ($stmt->num_rows > 0) {
			// Username already exists
			$_SESSION['reg-error'] = TRUE;
			header('Location: reg.php');        
		} 
		else {
			// Username doesn't exists, insert new account
			if ($stmt = $con->prepare('INSERT INTO employee (SSN, Email, First_Name, Last_Name, Username, Password) 
			VALUES (?, ?, ?, ?, ?, ?)')) {
				// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
				$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

				$stmt->bind_param('isssss', $_POST['ssn'], $_POST['email'], $_POST['fname'], $_POST['lname'],  $_POST['username'], $password);
				$stmt->execute();

				header('Location: register-success.html');        
			} else {
				// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all three fields.
				header('Location: register-error.html');        
			}
		}
		$stmt->close();
	} else {
		// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
		header('Location: register-error.html');        
	}
}

$con = connectDB();
errorCheck();
validateInfo($con);

$con->close();
?>