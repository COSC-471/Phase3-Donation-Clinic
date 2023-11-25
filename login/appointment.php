

<?php
    session_start();

    // Connect to database 
    $con = mysqli_connect("localhost","root","","blood clinic");
       
    // Get all the employees for the appointment form
    $sql = "SELECT * FROM `EMPLOYEE`";
    $employees = mysqli_query($con,$sql);

    // Get all donors for the appointment form
    $sql = "SELECT * FROM `DONOR`";
    $donors = mysqli_query($con,$sql);

    // Depending on the employee chosen, populate the location input
    if (isset($_POST['Category'])) {
        $_SESSION['selected'] = $_POST['Category'];

        $stmt = $con->prepare('SELECT Location_ID FROM EMPLOYEE WHERE SSN=?');
        $SSN = (int) $_POST['Category'];
        $stmt->bind_param('i', $SSN);
        $stmt->execute();  

        $results = $stmt->get_result()->fetch_assoc();

        $stmt = $con->prepare('SELECT Location FROM clinic WHERE ID=?');
        $ID = (int) $results['Location_ID'];
        $_SESSION['location-int'] = (int) $results['Location_ID'];
        $stmt->bind_param('i', $ID);
        $stmt->execute();  

        $results = $stmt->get_result()->fetch_assoc();

        $_SESSION['location'] = $results['Location'];
        $stmt->close();
    }

    // check that inputs are filled out
    if (isset($_POST['Donor']))
        $_SESSION['d_selected'] = $_POST['Donor'];

    if (isset($_POST['date']))
        $_SESSION['date'] = $_POST['date'];

    if (isset($_POST['new-donor'])) {
        header('Location: donor-register.html');        
    }

    // add the new appointment on button click
    if(isset($_POST['Add'])) {
        $employee = mysqli_real_escape_string($con,$_POST['Category']); 

        // Store the Category ID in a "id" variable
        $donor = mysqli_real_escape_string($con,$_POST['Donor']); 
        $location = mysqli_real_escape_string($con,$_SESSION['location-int']);
        $date = mysqli_real_escape_string($con,$_POST['date']); 
        
        // Creating an insert query using SQL syntax and
        // storing it in a variable.
        $stmt = $con->prepare('INSERT INTO appointments (Location, Employee, Donor_ID, Date_Donated) 
        VALUES (?, ?, ?, ?)');
        
        $stmt->bind_param('iiis', $location, $employee, $donor, $date);
        $stmt->execute();

        header('Location: home.php');        
    }
?>
  
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Register</title>
		<link href="register.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body id="new-appt">
        <nav class="navtop">
            <div>
				<a href="index.html"><i style="font-size: 3em;" class="fa-solid fa-plus"></i></a>
				<h1>Red Cross</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>

		<form action="home.php" method="get" autocomplete="off">
                <a href="home.php">
                    <input style="width:200px; margin-left: 230px"type="button" value="Back to Home"/>
                </a>
			</form>

		<div id="appt" class="register">

			<h1>New Appointment</h1>


			<form action="appointment.php" name="myform" method="post" autocomplete="off">
                <label>Employee Attending</label>
                <select id="select_id" name="Category" onchange="myform.submit();">
                    <option disabled selected value> -- select an option -- </option>
                    <?php 
                        while ($category = mysqli_fetch_array($employees,MYSQLI_ASSOC)):
                    ?>
                        <option class="opt" value="<?php echo $category['SSN']?>"
                        <?php echo isset($_SESSION['selected']) && $_SESSION['selected'] == $category['SSN'] ? 'selected' : '' ?>>
                            <?php echo $category["First_Name"]. " " . $category["Last_Name"];?>
                        </option>

                    <?php endwhile; ?>
                </select>

                <br><br>
                <label>Date</label>
                <input type="date" name="date" value="<?php echo isset($_SESSION['date'])?$_SESSION['date']:''?>" placeholder="00/00/0000" id="date" required>
                <label>Clinic</label>
                <input type="text" name="clinic" value="<?php echo isset($_SESSION['location'])?$_SESSION['location']:''?>" id="clinic" disabled>
                <label>Donor:</label>
                <select id="select_id2" name="Donor" onchange="myform.submit();">

                <option disabled selected value> -- select an option -- </option>
                    <?php 
                        // use a while loop to fetch data 
                        // from the $employees variable 
                        while ($donor = mysqli_fetch_array($donors,MYSQLI_ASSOC)):
                    ?>
                        <option class="opt" value="<?php echo $donor['ID']?>"
                        <?php echo isset($_SESSION['d_selected']) && $_SESSION['d_selected'] == $donor['ID'] ? 'selected' : '' ?>>
                            <?php echo $donor["First_Name"]. " " . $donor["Last_Name"];?>
                        </option>

                    <?php endwhile; ?>
                </select>
                <input type="submit" value="New Donor" name="new-donor">

                <input type="submit" value="Add Appointment" name="Add">
			</form>

		</div>    
	</body>
</html>