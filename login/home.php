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
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
			<a href="appointment.php"><button>Add Appointment</button></a>

			<div>
					<?php
						$con = mysqli_connect('localhost', 'root', '', 'blood clinic'); //The Blank string is the password
						
						$query = "SELECT * FROM appointments"; 
						$result = $con->query($query);

						echo "<table>"; // start a table tag in the HTML
						echo "<tr><th></th><th>Date</th><th>Employee</th><th>First Name</th><th>Last Name</th><th>ID</th><th>Blood Type</th></tr>";

						while ($row = $result->fetch_assoc()) {   //Creates a loop to loop through results

							$date = $row['Date_Donated'];

							// Get employee info
							$stmt = $con->prepare('SELECT First_Name, Last_Name FROM employee WHERE SSN=?');
							$id = (int) $row['Employee'];
							$stmt->bind_param('i', $id);
							$stmt->execute();
							$results = $stmt->get_result()->fetch_assoc();

							$employee = $results['First_Name'] . " " . $results['Last_Name'];

							// get donor info
							$stmt = $con->prepare('SELECT First_Name, Last_Name, Blood_type FROM donor WHERE ID=?');
							$id = $row['Donor_ID'];
							$stmt->bind_param('i', $id);
							$stmt->execute();
							$results = $stmt->get_result()->fetch_assoc();

							$fname = $results['First_Name'];
							$lname = $results['Last_Name'];
							$blood = $results['Blood_type'];

						echo "<tr><td>
						<form method='post' action='delete.php'>
							<input id='delete' type='submit' name='submit' value='&#xf1f8;'>
							<input type='hidden' name='Donor_ID' value='" . $row['Donor_ID'] . "'>
							<input type='hidden' name='Date' value='" . $date . "'>
						</form></td><td>"

						. htmlspecialchars($date) . "</td><td>" 
						. htmlspecialchars($employee) . "</td><td>" 
						. htmlspecialchars($fname) . "</td><td>" 
						. htmlspecialchars($lname) . "</td><td>" 
						. htmlspecialchars($row['Donor_ID']) . "</td><td>" 
						. htmlspecialchars($blood) . "</td>" 
						. 
						"<td>		
							<div class='container'>
							<button id='btn' type='button' class='btn btn-info btn-lg' data-toggle='modal' 
							data-target='#myModal'><i class='fa-solid fa-arrow-right-long'></i></button>
				
							<!-- Modal -->
							<div class='modal fade' id='myModal' role='dialog'>
								<div class='modal-dialog'>
								
									<!-- Modal content-->
									<div class='modal-content'>
										<div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title'>Edit Appointment</h4>
										</div>
										<div class='modal-body'>
										<form action='register.php' method='post' autocomplete='off'>
										<label for='username'><i class='fas fa-user'></i></label>
										<input type='text' name='username' placeholder='Username' id='username' required>
										<label for='password'><i class='fas fa-lock'></i></label>
										<input type='password' name='password' placeholder='Password' id='password' required>
						
										<label for='username'><i class='fas fa-envelope'></i></label>
										<input type='text' name='fname' placeholder='First' id='fname' required>
										<label for='username'><i class='fas fa-envelope'></i></label>
										<input type='text' name='lname' placeholder='Last' id='lname' required>
										<label for='password'><i class='fas fa-user'></i></label>
										<input type='number' name='ssn' placeholder='SSN' id='ssn' required>
										<label for='username'><i class='fas fa-lock'></i></label>
										<input type='text' name='email' placeholder='user@gmail.com' id='email' required>
						
										<input type='submit' value='Register'>
						
									</form>
										</div>
										<div class='modal-footer'>
										<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
										</div>
									</div>
							
								</div>
							</div>
						</div>
						</td>
						</tr>"; 
						}
						
						echo "</table>"; //Close the table in HTML
						
						$con->close(); //Make sure to close out the database connection
					?>
			</div>
		</div>

	</body>
</html>