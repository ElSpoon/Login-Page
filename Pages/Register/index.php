<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/styles.css">
	<title>Register</title>
</head>

<body>
	<div class="container">
		<div class="loginBox">
			<form action="index.php" method="post">
				<div class="center">
					<h1>Register</h1>

					<p>
						<label for="email">E-Mail<br>
						<input type="email" name="email" required></label>
					</p>

					<p>
						<label>Username<br>
						<input type="text" name="username" required></label>
					</p>

					<p>
						<label>Password<br>
						<input type="password" name="password" required></label>
					</p>
				</div>

				<input id="submitButton" type="submit" name="formSubmit" value="Register">
				<br><a href="../Login/index.php">Return to Login Page</a>
			</form>
		</div>

		<div>
			<?php

				// Connect to the database
				include("config.php");
				$conn = new mysqli($db_serverName, $db_user, $db_pass, $db_name);

				// Check Connection
				if ($conn->connect_error)
				{
					die("Connection failed: " . $conn->connect_error);
				}

				// Check if the login button is clicked
				if(isset($_POST['formSubmit']))
				{
					$email = $_POST['email'];
					$username = $_POST['username'];
					$password = $_POST['password'];

					if($email && $username && $password)
					{
						// Encrpyt the password
						$password_hash = password_hash($password, PASSWORD_DEFAULT);

						if (checkEmail($email) && checkUsername($username) == true)
						{
							$sql = "INSERT INTO $db_table (email, username, password) VALUES (\"$email\", \"$username\", \"$password_hash\")";

							// Checks if the query was successful
							if($conn->query($sql) === TRUE)
							{
								echo "<p><b>Account Created!</b></p>";
								header("Location: ../Login/index.php");
							}
							else
							{
								echo "<p class='error'>There was an error creating your account. Please try again later.</p>";
							}
						}
					}
				}

				// Checks if the email is already in use
				function checkEmail($email)
				{
					// Connect to database
					include("config.php");
					$conn = new mysqli($db_serverName, $db_user, $db_pass, $db_name);

					// Check Connection
					if ($conn->connect_error)
					{
						die("Connection failed: " . $conn->connect_error);
					}

					// Prepare the query, bind the parameters, then execute the query
					$emailQuery = $conn->prepare("SELECT user_id FROM $db_table WHERE email = ?");
					$emailQuery->bind_param("s", $email);
					$emailQuery->execute();

					// Get the reults for the query
					$result = $emailQuery->get_result();

					// Check if there are any results. If there is, the email is already in use
					if($result->num_rows) {
						echo "<p class='error'>That email address is already in use!</p>";
						return false;
					}
					else
					{
						return true;
					}

					$conn->close();

				}

				// Checks if the username is already in use
				function checkUsername($username)
				{
					// Connect to the database
					include("config.php");
					$conn = new mysqli($db_serverName, $db_user, $db_pass, $db_name);

					// Check Connection
					if ($conn->connect_error)
					{
						die("Connection failed: " . $conn->connect_error);
					}

					// prepare the query, bind the parameters, then execute the query
					$usernameQuery = $conn->prepare("SELECT user_id FROM $db_table WHERE username = ?");
					$usernameQuery->bind_param("s", $username);
					$usernameQuery->execute();

					// Get the results for the query
					$result = $usernameQuery->get_result();

					// Check if there are any results. If there is, the username is already in use
					if($result->num_rows)
					{
						echo "<p class='error'>That username is already in use!</p>";
						return false;
					}
					else
					{
						return true;
					}
					$conn->close();

				}

				$conn->close();
			?>
		</div>
	</div>
</body>
</html>