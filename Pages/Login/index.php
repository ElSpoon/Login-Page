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
					input id="submitButton" type="button" name="registerButton" value="Register">
				</a>
			</form>
		</div>

		<div>
			<?php 

				if(isset($_POST['formSubmit']))
				{
					$username = $_POST['username'];
					$password = $_POST['password'];

					if($username && $password)
					{
						loginAccount($username, $password);
					}
				}

				// Function to log into the account
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

					// Prepare, bind, and execute the query
					$loginQuery = $conn->prepare("SELECT password FROM $db_table WHERE username = ?");
					$loginQuery->bind_param("s", $accountUsername);
					$loginQuery->execute();

					// Stores the results
					$result = $loginQuery->get_result();
					
					// Gets the data from the results
					$fetchedResult = $result->fetch_row();

					if($result->num_rows)
					{
						// Stores the hashed password into a variable
						$hashedPassword = $fetchedResult[0];

						// Verifies the password matches the stored encrypted password
						$verify = password_verify($accountPassword, $hashedPassword);

						// If the password matches, login
						if($verify)
						{
							echo "<p class=\"success\">Login Successful! Redirecting...</p>";
							sleep(3);
							header("Location: loggedin.html");
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
