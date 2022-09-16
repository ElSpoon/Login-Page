<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/styles.css">
	<title>Log In</title>
</head>

<body>
	<div class="container">
		<div class="loginBox">
			<form action="index.php" method="post">
				<div class="center">
					<h1>Login</h1>

					<p>
						<label>Username<br>
						<input type="text" name="username" required></label>
					</p>

					<p>
							<label>Password<br>
						<input type="password" name="password" required></label>
					</p>
				</div>

				<input id="submitButton" type="submit" name="formSubmit" value="Login"><br>
				<a href="../Register/index.php">
					<input id="submitButton" type="button" name="registerButton" value="Register">
				</a>
			</form>
		</div>

		<div>
			<?php 

			// https://www.geeksforgeeks.org/how-to-encrypt-and-decrypt-passwords-using-php/

				if(isset($_POST['formSubmit']))
				{
					$username = $_POST['username'];
					$password = $_POST['password'];

					if($username && $password)
					{
						loginAccount($username, $password);
					}
				}

				function loginAccount($username, $password)
				{
					include("config.php");
					$conn = new mysqli($db_serverName, $db_user, $db_pass, $db_name);

					// Check Connection
					if ($conn->connect_error)
					{
						die("Connection failed: " . $conn->connect_error);
					}

					$accountUsername = $username;
					$accountPassword = $password;

					$loginQuery = $conn->prepare("SELECT password FROM $db_table WHERE username = ?");
					$loginQuery->bind_param("s", $accountUsername);
					$loginQuery->execute();

					$result = $loginQuery->get_result();
					
					$fetchedResult = $result->fetch_row();

					if($result->num_rows)
					{
						$hashedPassword = $fetchedResult[0];
						$verify = password_verify($accountPassword, $hashedPassword); // error here "Uncaught TypeError: password_verify(): Argument #2 ($hash) must be of type string"
						if($verify)
						{
							echo "<p class=\"success\">Login Successful!</p>";
						}
						else
						{
							echo "<p class=\"error\">Password is incorrect.</p>";
						}
					}
					else
					{
						echo "<p class=\"error\">Login Failed.<br>Incorrect username. Please check your username and try again.</p>";
					}

				}
			?>
		</div>
	</div>
</body>
</html>
