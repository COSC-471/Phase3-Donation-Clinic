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

function editPassword($con) {

	if (isset($_POST['pwd']) && isset($_POST['new-pwd0']) && isset($_POST['new-pwd']) 
	&& !empty($_POST['pwd']) && !empty($_POST['new-pwd0']) && !empty($_POST['new-pwd'])) {

		$query = "SELECT password FROM employee WHERE Username='{$_POST['emp-id']}'";
		$query_run = mysqli_query($con, $query);
	
		if ($_SESSION['new-pwd0'] == $_SESSION['new-pwd'] && mysqli_num_rows($query_run) > 0)  {
			foreach($query_run as $items) {
				if (password_verify($_POST['pwd'] == $items['Password'])) {
					$query = "UPDATE employee SET Password='{$_POST['new-pwd']}' WHERE Username='{$_SESSION['username']}'";
					$query_run = mysqli_query($con, $query);
				}
			}	
		}
		else

			header(Location: 'profile.php');
	}
}

$con = connectDB();
displayData($con);
editPassword($con);

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
						<form action="profile.php"><td><input type="text" name="pwd" placeholder="Input current password" require></td></tr><tr>
						<td><td><input type="text" name='new-pwd0' placeholder="Input new password" require>
						<input type='hidden' name='emp-id' value='<?php echo $_SESSION['username'] ?>'></td>
						<td><input type="text" name='new-pwd' placeholder="Input new password" require></td>
						<td><input type="submit" value="edit password"></td></form>
					</tr>
				</table>
			</div>
		</div>
	</body> 

</html>