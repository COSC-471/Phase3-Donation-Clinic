<?php

// Connect to database
$con = mysqli_connect('localhost', 'root', '', 'blood clinic');

if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['fname'], $_POST['lname'], $_POST['id'], $_POST['blood-type'])) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['id']) || empty($_POST['blood-type'])) {
	// One or more values are empty.
	exit('Please complete the registration form');
}

// We need to check if the donor with that id exists.
if ($stmt = $con->prepare('SELECT * FROM donor WHERE ID = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['id']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {echo 'Donor exists!';} 

    else {
        // Donor doesn't exist insert new 
        if ($stmt = $con->prepare('INSERT INTO Donor (First_Name, Last_Name, ID, Blood_type) 
        VALUES (?, ?, ?, ?)')) {

            $stmt->bind_param('ssss', $_POST['fname'], $_POST['lname'], $_POST['id'], $_POST['blood-type']);
            $stmt->execute();
            header('Location: appointment.php');        
        } 
	}
	$stmt->close();
} else {
	// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
	echo 'Could not prepare statement!';
}
$con->close();
?>