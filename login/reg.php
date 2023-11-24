<?php
session_start();
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
			<h1>Register</h1>
			<form action="register.php" method="post" autocomplete="off">
				<label for="username"><i class="fas fa-user"></i></label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<?php
				if (isset($_SESSION['reg-error']) && $_SESSION['reg-error'] == TRUE) {
					// Could not get the data that should have been sent.
					$_SESSION['reg-error'] = FALSE;
					echo('<p id="error"style="background-color: rgb(236, 156, 64); width: 100%">Username taken</p>');
				}
				?>
				<label for="password"><i class="fas fa-lock"></i></label>
				<input type="password" name="password" placeholder="Password" id="password" required>

                <label for="username"><i class="fas fa-envelope"></i></label>
				<input type="text" name="fname" placeholder="First" id="fname" required>
                <label for="username"><i class="fas fa-envelope"></i></label>
				<input type="text" name="lname" placeholder="Last" id="lname" required>
                <label for="password"><i class="fas fa-user"></i></label>
				<input type="number" name="ssn" placeholder="SSN" id="ssn" required>
				<label for="username"><i class="fas fa-lock"></i></label>
				<input type="text" name="email" placeholder="user@gmail.com" id="email" required>

                <input type="submit" value="Register">

			</form>
		</div>
	</body>
</html>