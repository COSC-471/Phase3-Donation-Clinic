<?php
session_start();
// connect using the info above.

$con = mysqli_connect('localhost', 'root', '', 'blood clinic');
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    // We need to check if the account with that username exists.
    if ($stmt = $con->prepare('DELETE FROM appointments  WHERE Donor_ID = ? AND Date_Donated= ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
    $stmt->bind_param('ss', $_POST['Donor_ID'], $_POST['Date']);
    $stmt->execute();
    $stmt->close();
    }
    $con->close();

    if (isset($_SESSION['Donor-id'])) {
        header('Location: Donor-home.php');       
    }
    else
        header('Location: home.php');       
}
?>