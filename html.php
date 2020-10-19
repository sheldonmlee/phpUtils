<?php
//
// HTML generation
//

// Generates <select> html list
// usage: generateSelect(<connection instance>, string: <id field>, string: <display field>, string: <default option>, boolean: <is required>);
// $default matches with $v_field
function generateSelect(&$connection, $t_name, $id_field, $d_field, $default=null)
{
	$queryResult = $connection->query("
		SELECT $id_field, $d_field FROM $t_name
		ORDER BY $id_field;
	");

	echo "<select name='$id_field'>";
	foreach ($queryResult as $row) {
		$selected="";
		if ($default == $row[$id_field] && $default != null) {
			$selected = "selected";
		}
		echo "<option value='{$row[$id_field]}'$selected>{$row[$d_field]}</option>";
	}
	echo "</select>";
}
?>
