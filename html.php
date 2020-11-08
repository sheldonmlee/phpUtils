<?php
//
// HTML generation
//

//
// Forms
//

const INPUT_BUTTON = 1;
const INPUT_CHECKBOX = 2;
const INPUT_COLOR = 3;
const INPUT_DATE = 4;
const INPUT_DATETIME_LOCAL = 5;
const INPUT_EMAIL = 6;
const INPUT_FILE = 7;
const INPUT_HIDDEN = 8;
const INPUT_IMAGE = 9;
const INPUT_MONTH = 10;
const INPUT_NUMBER = 11;
const INPUT_PASSWORD = 12;
const INPUT_RADIO = 13;
const INPUT_RANGE = 14;
const INPUT_RESET = 15;
const INPUT_SEARCH = 16;
const INPUT_SUBMIT = 17;
const INPUT_TEL = 18;
const INPUT_TEXT = 19;
const INPUT_TIME = 20;
const INPUT_URL = 21;
const INPUT_WEEK = 22;


function generateInput($type)
{
	switch ($type) { 
	# case FORM_NUMBER: 
	# 	type = 
	}
	$str = "
	<label></label><br>
	"
}

function generateSelect($name, $options, $default)
{
	foreach ($options as $option) {
		
	}
}

function generateForm($form)
{
	foreach ($array as $entry) {
		switch ($entry["type"]) {
			case 
		}
	}
}

// Generates <select> html list
// usage: generateSelect(<connection instance>, string: <id field>, string: <display field>, string: <default option>, boolean: <is required>);
// $default matches with $v_field
function generateSelectFromTable(&$connection, $t_name, $id_field, $d_field, $default=null)
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
