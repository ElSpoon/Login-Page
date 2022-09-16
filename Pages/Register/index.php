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
			</form>
		</div>

		<div>
			<?php


				include("config.php");
				$conn = new mysqli($db_serverName, $db_user, $db_pass, $db_name);

				// Check Connection
				if ($conn->connect_error)
				{
					die("Connection failed: " . $conn->connect_error);
				}

				if(isset($_POST['formSubmit']))
				{
					$email = $_POST['email'];
					$username = $_POST['username'];
					$password = $_POST['password'];

					if($email && $username && $password)
					{
						$password_hash = password_hash($password, PASSWORD_DEFAULT);

						if (checkEmail($email) && checkUsername($username) == true)
						{
							$sql = "INSERT INTO $db_table (email, username, password) VALUES (\"$email\", \"$username\", \"$password_hash\")";

							if($conn->query($sql) === TRUE)
							{
								echo "<p><b>Account Created!</b></p>";
								header("Location: ../Login/index.php");
							}
							else
							{
								echo "Error: " . $sql . "<br>" . $conn->error;
							}
						}
					}
				}

				function checkEmail($email)
				{
					include("config.php");
					$conn = new mysqli($db_serverName, $db_user, $db_pass, $db_name);

					// Check Connection
					if ($conn->connect_error)
					{
						die("Connection failed: " . $conn->connect_error);
					}

					$emailQuery = $conn->prepare("SELECT user_id FROM $db_table WHERE email = ?");
					$emailQuery->bind_param("s", $email);
					$emailQuery->execute();

					$result = $emailQuery->get_result();

					if($result->num_rows) {
						echo "<p class='error'>That email address is already in use!</p>";
						return false;
					}
					else
					{
						return true;
					}

					/*
					if($emailQuery = 1)
					{
						echo "<p class='error'>That email address is already in use!</p>";
						return false;
					}
					else
					{
						return true;
					}
					*/
					$conn->close();


				}

				function checkUsername($username)
				{
					include("config.php");
					$conn = new mysqli($db_serverName, $db_user, $db_pass, $db_name);

					// Check Connection
					if ($conn->connect_error)
					{
						die("Connection failed: " . $conn->connect_error);
					}

					$usernameQuery = $conn->prepare("SELECT user_id FROM $db_table WHERE username = ?");
					$usernameQuery->bind_param("s", $username);
					$usernameQuery->execute();

					$result = $usernameQuery->get_result();

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