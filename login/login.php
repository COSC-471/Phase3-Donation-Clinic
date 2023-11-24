<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
        <link href="login.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="authenticate.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<?php
				if (isset($_SESSION['usererror']) && $_SESSION['usererror'] == TRUE) {
					// Could not get the data that should have been sent.
					$_SESSION['usererror'] = FALSE;
					echo('<p id="error"style="background-color: rgb(236, 156, 64); width: 100%">Incorrect username and/or password</p>');
				}
				?>
				<input type="submit" value="Login">
				<a href="reg.php" class="button" target="_blank">Sign Up</a>		
			</form>
		</div>
	</body>
</html>