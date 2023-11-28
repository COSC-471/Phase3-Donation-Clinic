
<?php
    session_start();
    $id = $_SESSION['new-id'];
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
			<h1>Login</h1>
			<form action="Donor-login.php" method="get" autocomplete="off">
            <h1>You have successfully registered! Login to view your appointment using your id: 
                <?php echo $id?> </h1>
                <a href="Donor-login.php">
                    <input type="button" value="Login"/>
                </a>
			</form>
		</div>
	</body>
</html>v