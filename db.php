<?php
//
// PDO utility functions
//

// see details_example.php
function getConnection($details) {
	$hostname =	$details["hostname"];
	$dbname = 	$details["dbname"];
	$username =	$details["username"];
	$password =	$details["password"];

	// check if required fields present
	$fields = array($hostname, $dbname, $username, $password);
	foreach ($fields as $field) { if (empty($field)) return null; }

	echo"<p>";
	print_r($fields);
	echo"</p>";

	try {
		$connection = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$password");
		return $connection;
	} catch (Exception $e) {
		return null;
	}
}

// Gets next sequentially available id
// usage: getNextID(<connection instance>, string: <table name>, string: <id_field>);
function getNextID(&$connection, $t_name, $id_field)
{
	$sql = "
	SELECT $id_field FROM $t_name
	ORDER BY $id_field;
	";

	$queryResult = $connection->query($sql);

	$last_id = 0;
	foreach($queryResult as $row) {
		$id = $row[$id_field];
		if($last_id +1 != $id) return $last_id+1;
		$last_id = $id;
	}

	$queryResult = null;
	return $last_id+1;
}
?>
