<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Donor Login</title>
        <link href="login.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body>
		<ul>
            <li style="margin-left:100px;"><a style="color: white" id="home" href="index.html">Red Cross</a></li>
            <li style="float:right"><a class="active" href="login.php">Employee Portal</a></li>
            <li style="float:right"><a class="active" href="Donor-login.php">Patient Portal</a></li>

        </ul>
		<div class="login">
			<h1>Donor Login</h1>
			<form action="Donor-auth.php" method="post">
				<input type="password" name="id" placeholder="id" id="id" required>
				<input type="submit" value="Login">
				<a href="reg.php" class="button" target="_blank">Sign Up</a>		
			</form>
		</div>
	</body>
</html>