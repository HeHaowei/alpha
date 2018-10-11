<!DOCTYPE html>
<head>
    <title>UPDATE PostgreSQL data with PHP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>li {list-style: none;}</style>
</head>
<body>
<h2>Our current on-going projects</h2>
<ul>
    <form name="display" action="BrowseProjects.php" method="POST" >
    </form>
</ul>


	<?php
  	// Connect to the database. Please change the password in the following line accordingly
    $db       = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=test");
    $funded   = pg_query($db, 'SELECT Project_id, title, category, total_amount FROM publish_projects WHERE current_amount >= total_amount');
    $unfunded = pg_query($db, 'SELECT Project_id, title, category, total_amount, total_amount - current_amount AS shortage FROM publish_projects WHERE current_amount < total_amount ORDER BY shortage')

    if(!$funded or !$unfunded){
    	echo 'An error occurred.\n';
    	exit;
    }

    $number_funded =pg_query($db, 'SELECT COUNT(*) FROM publish_projects WHERE current_amount >=total_amount');
    $number_unfunded = pg_query($db, 'SELECT COUNT(*) FROM publish_projects WHERE current_amount<total_amount');
    $average_shortage = pg_query($db, 'SELECT AVG (total_amount - current_amount) FROM publish_projects WHERE current_amount<total_amount');

    $funded =  pg_fetch_all($funded);
    $unfunded = pg_fetch_all($unfunded);

    echo "<h2> Projects seeking fund</h2>";
    echo "number of projects: ".$number_unfunded."<br>";
    echo "average money needed: ".$average_shortage."<br>";
    print_r($unfunded);

    echo "<h2> Funded Projects</h2>";
    echo "number of funded projects: ".$number_funded."<br>";
    print_r($funded);

    ?>
 
 </body>
</html>















	