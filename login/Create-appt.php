<?php
    session_start();

    // Connect to database 
    $con = mysqli_connect("localhost","root","","blood clinic");
       
    // Get all the employees for the appointment form
    $sql = "SELECT * FROM `clinic`";
    $clinics = mysqli_query($con,$sql);

    // add the new appointment on button click
    if(isset($_POST['submit'])) {
        // check if the user already exists
        $query = "SELECT ID FROM donor WHERE First_Name='{$_POST['fname']}' AND Last_Name='{$_POST['lname']}'";
        $query_run = mysqli_query($con, $query);

        if(mysqli_num_rows($query_run) > 0) {
            $_SESSION['exists'] = TRUE;
        }
        else {
            // create a new donor id
            $id = rand(0,100000000);
            $query = "SELECT First_Name FROM donor WHERE ID='{$id}'";
            $query_run = mysqli_query($con, $query);

            while (mysqli_num_rows($query_run) > 0) {
                $id = rand(0,100000000);
                $query = "SELECT First_Name FROM donor WHERE ID='{$id}'";
                $query_run = mysqli_query($con, $query);
            }
            $query = "INSERT INTO donor(ID, Blood_type, First_Name, Last_Name, Donated_Clinic) 
            VALUES ('{$id}', '{$_POST['blood']}', '{$_POST['fname']}', '{$_POST['lname']}', '{$_POST['clinic']}')";
            $query_run = mysqli_query($con, $query);

            $emp = checkAppts($con);
            echo '<script>alert("'.$emp.'")</script>'; 
            $query = "INSERT INTO appointments (Donor_ID, Location, Employee, Date_Donated) 
            VALUES ('{$id}', '{$_POST['clinic']}', '{$emp}', '{$_POST['date']}')";
            $query_run = mysqli_query($con, $query);

            $_SESSION['new-id'] = $id;
            header('Location: new-donor.php');  
        }
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
	<body>
		<div class="register">
			<h1>Donate</h1>
			<form action="Create-appt.php" method="post" autocomplete="off">
				<?php
				if (isset($_SESSION['exists']) && $_SESSION['exists'] == TRUE) {
					// Could not get the data that should have been sent.
					$_SESSION['exists'] = FALSE;
					echo('<p id="error"style="background-color: rgb(236, 156, 64); width: 100%">User Exists. Login with your ID</p>');
				}
				?>
                <label for="username"><i class="fas fa-envelope"></i></label>
				<input type="text" name="blood" placeholder="Blood type" id="blood" required>
                <label for="username"><i class="fas fa-envelope"></i></label>
				<input type="text" name="fname" placeholder="First" id="fname" required>
                <label for="username"><i class="fas fa-user"></i></label>
				<input type="text" name="lname" placeholder="Last" id="lname" required>
                <label for="username"><i class="fas fa-lock"></i></label>
				<input type="date" name="date" placeholder="date" id="date" required>
                <label style="width: 100px">Location</label>
                <select style="width: 260px"id="select_id" name="clinic" onchange="myform.submit();" required>
                    <option disabled selected value> -- select an option -- </option>
                    <?php 
                        while ($clinic = mysqli_fetch_array($clinics,MYSQLI_ASSOC)):
                    ?>
                        <option class="opt" value="<?php echo $clinic['ID']?>">
                            <?php echo $clinic["Location"]?>
                        </option>

                    <?php endwhile; ?>
                </select>

                <input type="submit" name="submit" value="Donate">

			</form>
		</div>
	</body>
</html>