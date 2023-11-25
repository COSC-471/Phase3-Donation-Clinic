<?php
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$con = mysqli_connect('localhost', 'root', '', 'blood clinic'); 


function appointmentList($con, $partition) {
	$query = "SELECT * FROM appointments"; 
	$result = $con->query($query);

	echo "<table>"; // start a table tag in the HTML
	echo "<tr><th></th><th>Date</th><th>Employee</th><th>First Name</th><th>Last Name</th><th>ID</th><th>Blood Type</th></tr>";

	while ($row = $result->fetch_assoc()) {   //Creates a loop to loop through results

		$date = $row['Date_Donated'];
		$employee = ' ';
		$fname = ' ';
		$lname = ' ';
		$blood = ' ';

		// filter by date
		$currDate = date('Y-m-d H:i:s');

		if ($partition ? $date < $currDate : $date >= $currDate) {

			// Get employee info

			$_GET['search'] = isset($_GET['search']) ? $_GET['search'] : '';
			$filtervalues = $_GET['search'];
			$query = "SELECT First_Name, Last_Name FROM employee WHERE SSN='{$row['Employee']}' AND CONCAT(First_Name,Last_Name) LIKE '%$filtervalues%' ";
			$query_run = mysqli_query($con, $query);

			// get donor info

			$query2 = "SELECT First_Name, Last_Name, Blood_type FROM donor WHERE ID='{$row['Donor_ID']}' AND CONCAT(First_Name,Last_Name, Blood_type) LIKE '%$filtervalues%' ";
			$query_run2 = mysqli_query($con, $query2);

			// print out appointments according to search
			if(mysqli_num_rows($query_run) > 0 || mysqli_num_rows($query_run2) > 0)
			{
				$query = "SELECT First_Name, Last_Name FROM employee WHERE SSN='{$row['Employee']}'";
				$query2 = "SELECT First_Name, Last_Name, Blood_type FROM donor WHERE ID='{$row['Donor_ID']}'";
				$query_run = mysqli_query($con, $query);
				$query_run2 = mysqli_query($con, $query2);

				foreach($query_run as $items)
					$employee = $items['First_Name'] . " " . $items['Last_Name'];

				foreach($query_run2 as $items2) {
					$fname = $items2['First_Name'];
					$lname = $items2['Last_Name'];
					$blood = $items2['Blood_type'];
				}

				
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
								<h4 class='modal-title'>Edit Appointment Info</h4>
								</div>
								<div class='modal-body'>

							<form id='edit' action='edit-appt.php' method='post' autocomplete='off'>
								<input type='hidden' name='Donor_ID' value='".$row['Donor_ID']."'>
								<label>Donor First Name</label>
								<input type='text' name='fname' placeholder='First' id='username'>
								<label>Donor Last Name</label>
								<input type='password' name='lname' placeholder='Last' id='password'>
								<label>Donor Blood Type</label>
								<input type='text' name='blood' placeholder='00000000' id='fname'>

								<input style='height: 50px; width: 80px' type='submit' value='Edit'>
				
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
		}
	}
	
	echo "</table>"; //Close the table in HTML
}

function searchBar() {
	echo '
	<form id="search" action="" method="GET">
		<input type="text" name="search" value="' . (isset($_GET["search"]) ? $_GET['search'] : "") . '" class="form-control" placeholder="Search data">
		<input id="btn" type="submit" value="search" class="btn btn-primary"></button>
		<a href="appointment.php"><button id="btn" type="button" style="width: 150px; height: 50px; margin-left: 400px">Add Appointment</button></a>
	</form>
	';
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
				<a href="index.html"><i style="font-size: 3em;" class="fa-solid fa-plus"></i></a>
				<h1>Red Cross</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>

		<div class="content" >
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>

			<div class="tab">
				<button class="tablinks" onclick="openCity(event, 'London')">Upcoming Appointments</button>
				<button class="tablinks" onclick="openCity(event, 'Paris')">Past Appointments</button>
			</div>

			<div id="London" class="tabs">
				<?php
					searchBar();
					appointmentList($con, FALSE);
				?>
			</div>

			<div id="Paris" class="tabs" style="display:none">

				<?php
					searchBar();
					appointmentList($con, TRUE);
				?>
			</div>
		</div>

		
		<script>
			function openCity(evt, cityName) {
				// Declare all variables
				var i, tabcontent, tablinks;

				// Get all elements with class="tabcontent" and hide them
				tabcontent = document.getElementsByClassName("tabs");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}

				// Get all elements with class="tablinks" and remove the class "active"
				tablinks = document.getElementsByClassName("tablinks");
				for (i = 0; i < tablinks.length; i++) {
					tablinks[i].className = tablinks[i].className.replace(" active", "");
				}

				// Show the current tab, and add an "active" class to the button that opened the tab
				document.getElementById(cityName).style.display = "block";
				evt.currentTarget.className += " active";
				} 
		</script>
	</body>
</html>