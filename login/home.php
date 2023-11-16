<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="login.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Website Title</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>

			<h2>Appointments</h2>
			<div>
					<?php
						$con = mysqli_connect('localhost', 'root', '', 'blood clinic'); //The Blank string is the password
						
						$query = "SELECT * FROM donor"; //You don't need a ; like you do in SQL
						$result = $con->query($query);

						echo "<table>"; // start a table tag in the HTML
						echo "<tr><th>Date</th><th>Clinic</th><th>Donor Name</th><th>ID</th><th>Blood Type</th><th>History</th></tr>";

						
						while ($row = $result->fetch_assoc()) {   //Creates a loop to loop through results
						echo "<tr><td>" . htmlspecialchars($row['ID']) . "</td><td>" . htmlspecialchars($row['Blood_type']) . "</td></tr>";  //$row['index'] the index here is a field name
						}
						
						echo "</table>"; //Close the table in HTML
						
						$con->close(); //Make sure to close out the database connection
						
						echo "<tr>"
					?>
			</div>
		</div>
	</body>
</html>