<!DOCTYPE html>
<head>
	<title>Crowdfunding</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>li {list-style: none;}</style>
</head>
<body>
	<table>
		<h3>Sign up</h3>
		<form name="display" action="index.php" method="POST">
			<div class="container">
				<label for="uname"><b>Username</b></label>
    			<input type="text" placeholder="Enter Username" name="uname" required>
    			<label for="psw"><b>Password</b></label>
    			<input type="password" placeholder="Enter Password" name="psw" required>
    			<label for="name"><b>Full Name</b></label>
    			<input type="text" placeholder="Enter Full Name" name="name" required>
				<label for="email"><b>Email</b></label>
				<input type="text" placeholder="Enter Email" name="email" required>
				<label>
					<input type="checkbox" checked="checked" name="rmb"> Remember me
				</label>
			</div>
			<div class="clearfix">
				<button type="button" class="cancelbtn">Cancel</button>
				<button type="submit" class="signupbtn" name="signup">Sign up</button>
			</div>
		</form>
		<h3>Sign in</h3>
		<form name="display" action="index.php" method="POST">
			<div class="container">
				<label for="uid"><b>Username</b></label>
				<input type="text" placeholder="Enter Username" name="uid" required>
				<label for="pass"><b>Password</b></label>
				<input type="password" placeholder="Enter Password" name="pass" required>
				
				<label>
					<input type="checkbox" checked="checked" name="remember"> Remember me
				</label>
			</div>
			<div class="clearfix">
				<button type="button" class="cancelbtn">Cancel</button>
				<button type="submit" class="signinbtn" name="signin">Sign in</button>
			</div>
		</form>
		<br/>
	</table>
	<form name="display" action="publish.php" method="GET">
		<button type="submit">Publish Project</button>
	</form>
	<?php
		// Connect to the database. Please change the password in the following line accordingly
		$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=000000");
		date_default_timezone_set("Asia/Singapore");
		$current_date = date("Y-m-d");
		session_start();
		$_SESSION[userid] = NULL;
		if (isset($_POST[signup])) {
			$result = pg_query($db, "INSERT INTO users VALUES ('$_POST[uname]', '$_POST[psw]', '$_POST[name]', '$_POST[email]', '$current_date')");
			if (!$result) {
				echo "<p>Invalid input(s)!</p>";
			}
			else {
				$_SESSION[userid] = $_POST[uname];
				echo "<p>Sign up successful!</p>";
			}
		}
		if (isset($_POST[signin])) {
			$user = pg_fetch_assoc(pg_query($db, "SELECT * FROM users WHERE users.user_id = '$_POST[uid]'"));
			if ($user[password] != $_POST[pass]) {
				echo "<p>Invalid input(s)!</p>";
			}
			else {
				$_SESSION[userid] = $user[user_id];
				echo "<p>Sign in successful!</p>";
			}
		}
	?>
	<form action="" method="POST" id="frmLogout">
		<div class="member-dashboard">
			<?php
				if ($_SESSION[userid] == NULL) {
					echo "You have not logged in yet";
				}
				else {
					echo "You have logged in as ";
					echo ucwords($_SESSION[userid]);
				}
			?>
			<br/>
			<input type="submit" name="logout" value="Logout" class="logoutbtn">
		</div>
	</form>
	<?php
		if(isset($_POST["logout"])) {
			$_SESSION[userid] = NULL;
		}
	?>
</body>
</html>
