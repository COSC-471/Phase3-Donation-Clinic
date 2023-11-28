

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

    $sql2 = "SELECT * FROM `clinic`";
    $clinics = mysqli_query($con,$sql2);


    // add the new appointment on button click
    if(isset($_POST['Add'])) {
        $_SESSION['clinic-selected'] = $_POST['clinic'];

        $employee = mysqli_real_escape_string($con,$_POST['Category']); 

        // Store the Category ID in a "id" variable
        $donor = $_SESSION['Donor-id'];
        $location = mysqli_real_escape_string($con,$_POST['clinic']);
        $date = mysqli_real_escape_string($con,$_POST['date']); 
        
        // Creating an insert query using SQL syntax and
        $emp = checkAppts($con);

        // storing it in a variable.
        $stmt = $con->prepare('INSERT INTO appointments (Location, Employee, Donor_ID, Date_Donated) 
        VALUES (?, ?, ?, ?)');
        
        $stmt->bind_param('iiis', $location, $emp, $donor, $date);
        $stmt->execute();

        header('Location: Donor-home.php');        
    }

    
function checkAppts($con) {
    $query = "SELECT Employee FROM appointments WHERE Date_Donated !='{$_POST['date']}'";
    $query_run = mysqli_query($con, $query);

    while (mysqli_num_rows($query_run) > 0) {
        foreach($query_run as $items) {
            return $items['Employee'];
        }
    }
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
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>

		<form action="Donor-home.php" method="get" autocomplete="off">
                <a href="Donor-home.php">
                    <input style="width:200px; margin-left: 230px"type="button" value="Back to Home"/>
                </a>
			</form>

		<div id="appt" class="register">

			<h1>New Appointment</h1>


			<form action="add-apt.php" name="myform" method="post" autocomplete="off">
                <br><br>
                <label>Date</label>
                <input type="date" name="date" value="<?php echo isset($_SESSION['date'])?$_SESSION['date']:''?>" placeholder="00/00/0000" id="date" required>
                <label>Clinic</label>

                <select id="select_id" name="clinic">
                    <option disabled selected value> -- select an option -- </option>
                    <?php 
                        while ($category = mysqli_fetch_array($clinics,MYSQLI_ASSOC)):
                    ?>
                        <option class="opt" value="<?php echo $category['ID']?>"
                        <?php echo isset($_SESSION['clinic-selected']) && $_SESSION['clinic-selected'] == $category['ID'] ? 'selected' : '' ?>>
                            <?php echo $category["Hospital_Receiving"];?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <input type="submit" value="Add Appointment" name="Add">
			</form>

		</div>    
	</body>
</html>