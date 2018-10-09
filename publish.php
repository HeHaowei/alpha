<!DOCTYPE html>
<head>
	<title>Crowdfunding: Publishing Project</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>li {list-style: none;}</style>
</head>
<body>
	<h2>Publishing Project</h2>
	<form action="" method="POST" id="frmLogout">
		<div class="member-dashboard">
			<?php
				session_start();
				if ($_SESSION[userid] == NULL) {
					echo "You have not logged in yet";
				}
				else {
					echo "You have logged in as ";
					echo ucwords($_SESSION[userid]);
				}
			?>
		</div>
	</form>
	<form name="display" action="publish.php" method="POST">
		<ul>
			<div class="container">
				<li><label for="pid">Project ID</label></li>
				<li><input type="text" placeholder="Enter Project ID" name="pid" required></li>
				<li><label for="title">Title</label></li>
				<li><input type="text" placeholder="Enter Project Title" name="title" required></li>
				<li><label for="desc">Description</label>
				<li><input type="text" placeholder="Enter Description" name="desc" required></li>
				<li><label for="dura">Duration (Days)</label></li>
				<li><input type="number" placeholder="Enter Funding Duration" name="dura" required></li>
				<li><label for="cat">Category</label></li>
				<li><input type="text" placeholder="Enter Category" name="cat" required></li>
				<li><label for="total">Total Amount (SGD)</label></li>
				<li><input type="number" placeholder="Enter Total Amount" name="total" required></li>
			</div>
			<div class="clearfix">
				<button type="reset" class="cancelbtn">Clear</button>
				<button type="submit" class="publishbtn" name="pub">Confirm Pulish</button>
			</div>
		</ul>
	</form>
	<br/>
	<form name="display" action="index.php" method="GET">
		<button type="submit">Return to Homepage</button>
	</form>
	<?php
		// Connect to the database. Please change the password in the following line accordingly
		$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=000000");
		date_default_timezone_set("Asia/Singapore");
		$current_date = date("Y-m-d");
		if (isset($_POST[pub])) {
			$result = pg_query($db, "INSERT INTO publish_projects VALUES ('$_SESSION[userid]', '$_POST[pid]', '$_POST[title]', '$_POST[desc]', '$current_date', '$_POST[dura]', '$_POST[cat]', '$_POST[total]')");
			if (!$result) {
				echo "<p>Invalid input(s)!</p>";
			}
			else {
				echo "<p>Publish successful!</p>";
			}
		}
	?>
</body>