<?php
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['Donor-in'])) {
	header('Location: index.html');
	exit;
}

$con = mysqli_connect('localhost', 'root', '', 'blood clinic'); 


function appointmentList($con, $partition) {
	$query = "SELECT * FROM appointments WHERE Donor_ID='{$_SESSION['Donor-id']}'"; 
	$result = $con->query($query);

	echo "<table>"; // start a table tag in the HTML
	echo "<tr><th></th><th>Date</th><th>Employee</th><th>First Name</th><th>Last Name</th><th>ID</th><th>Blood Type</th></tr>";

	while ($row = $result->fetch_assoc()) {   //Creates a loop to loop through results

        $date = $row['Date_Donated'];
		$employee = ' ';
		$fname = ' ';
		$lname = ' ';
		$blood = ' ';

        // Get employee info

        $query = "SELECT First_Name, Last_Name FROM employee WHERE SSN='{$row['Employee']}'";
        $query_run = mysqli_query($con, $query);

        // get donor info

        $query2 = "SELECT First_Name, Last_Name, Blood_type, History FROM donor WHERE ID='{$row['Donor_ID']}'";
        $query_run2 = mysqli_query($con, $query2);

        // print out appointments according to search
        if(mysqli_num_rows($query_run) > 0)
        {
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
            "
            </tr>"; 
        }
    }
	echo "</table>"; //Close the table in HTML
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
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>

		<div class="content" >
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['Donor-first']?>!</p>

            <a href="add-apt.php"><button id="btn" type="button" style="width: 150px; height: 50px; margin-left: 0px">Add Appointment</button></a>

			<div id="London" class="tabs">
				<?php
					appointmentList($con, FALSE);
				?>
			</div>
		</div>
	</body>
</html>