<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();

// Connect to the database
function connectDB() {
	if (!isset($_SESSION['loggedin'])) {
		header('Location: index.html');
		exit;
	}

	$con = mysqli_connect('localhost', 'root', '', 'blood clinic');
	if (mysqli_connect_errno()) {
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	return $con;
}

// Display user date
function displayData($con) {
	$stmt = $con->prepare('SELECT First_Name, Last_Name, SSN, Email, Username, Password FROM employee WHERE ssn = ?');
	// In this case we can use the account ID to get the account info.
	$stmt->bind_param('i', $_SESSION['id']);
	$stmt->execute();
	$stmt->bind_result($_SESSION['fname'], $_SESSION['lname'], $_SESSION['ssn'], $_SESSION['email'], $_SESSION['username'], $_SESSION['password']);
	$stmt->fetch();
	$stmt->close();
}

$con = connectDB();
displayData($con);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="login.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1 id="website"><a href="home.php">Red Cross</a></h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>First Name:</td>
						<td><?=$_SESSION['fname']?></td>
					</tr>
					<tr>
						<td>Last Name:</td>
						<td><?=$_SESSION['lname']?></td>
					</tr>
					<tr>
						<td>Social Security Number:</td>
						<td><?=$_SESSION['ssn']?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$_SESSION['email']?></td>
					</tr>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['username']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$_SESSION['password']?></td>
					</tr>
				</table>
			</div>
		</div>
	</body> 

</html>