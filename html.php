<?php
//
// HTML generation
//

require_once("misc.php");

//
// Forms
//

abstract class Method extends Enum
{
	const GET = "get";
	const POST = "post";
}

// encapsulates constants used as inputs
abstract class Input extends Enum
{
	const BUTTON			= "button";
	const CHECKBOX			= "checkbox";
	const COLOR				= "color";
	const DATE				= "date";
	const DATETIME_LOCAL	= "datetime-local";
	const EMAIL				= "email";
	const FILE				= "file";
	const HIDDEN			= "hidden";
	const IMAGE				= "image";
	const MONTH				= "month";
	const NUMBER			= "number";
	const PASSWORD			= "password";
	const RADIO				= "radio";
	const RANGE				= "range";
	const RESET				= "reset";
	const SEARCH			= "search";
	const SUBMIT			= "submit";
	const TEL				= "tel";
	const TEXT				= "text";
	const TIME				= "time";
	const URL				= "url";
	const WEEK				= "week";

	const SELECT 			= "select";

}

abstract class Select Extends Enum
{
	const NORMAL = 1;
	const FROM_TABLE = 2;
}

// Takes an array() and returns an html string.
// For structure, refer to etc/example_form.php.
function generateForm($form)
{
	$action = defaultEmpty($form, "action");
	$method = defaultEmpty($form, "method");
	$target = defaultEmpty($form, "target");
	$inputs = defaultNull($form, "inputs");

	$output = "<form action=\"$action\" method=\"$method\" target=\"$target\">\n";
	if ($inputs != null) {
		foreach ($inputs as $input) {
			$type = defaultNull($input, "type");
			if (Input::exists($type)) $output .= generateInput($input);
			else if ($type == Select::NORMAL) $output.= generateSelect($input);
			else if ($type == Select::FROM_TABLE) $output.= generateSelectFromTable($input);
		}
	}
	$output .= "</form>\n";

	return $output;
}


// Takes an array() as input. Works for html <input>.
function generateInput($input)
{
	$type = defaultNull($input, "type");
	if (!Input::Exists($type)) return;

	// lambdas to generate <input> or <select> elements.
	// all lambdas inerit $input
	$generateInputGeneral = function() use ($input, $type)
	{
		$name = defaultNull($input, "name");
		$id = defaultString($input, "id", $name);
		$label = defaultEmpty($input, "label");
		$value = defaultEmpty($input, "value");
		$readonly = in_array("readonly", $input)? "readonly" : "";

		$str = "<label for=\"$id\">$label</label><br>\n<input type=\"$type\" name=\"$name\" id=\"$id\" value=\"$value\" $readonly><br>\n";
		return $str;
	};

	$generateInputSubmit = function() use ($input)
	{
		$value = defaultNull($input, "value");
		if ($value == null) $value = "Submit"; 
		return "<input type=\"submit\" value=\"$value\">\n";
	};

	// main logic
	switch ($type) {
	case null: 
		return;
	case Input::SUBMIT:
		return $generateInputSubmit();
		break;
	default:
		return $generateInputGeneral();
	}
}

// Generates <select> html list
function generateSelect($select)
{
	$name = defaultNull($select, "name");
	$id = defaultString($select, "id", $name);
	$label = defaultEmpty($select, "label");
	$options = defaultNull($select, "options");
	$default_value = defaultNull($select, "default_value");

	$output = "<label for=\"$id\">$label</label><br>\n";
	$output .= "<select name=\"$name\" id=\"$id\">\n";
	if ($options == null) return;
	foreach($options as $option) {
		$value = defaultNull($option, 0);
		if ($value == null) continue;
		$label = defaultString($option, 1, $value);

		// apply selected attribute if $value matches $default_value
		$selected = ($default_value == $value)? "selected" : "";
		$output .= "<option value=\"$value\" $selected>$label</option>\n";
	}
	$output .= "</select><br>\n";
	return $output;
}

// Generates <select> html list from table
// usage: generateSelect(<connection instance>, string: <id field>, string: <display field>, string: <default option>, boolean: <is required>);
// $default matches with $v_field
function generateSelectFromTable($select)
{
	$connection = defaultNull($select, "connection");
	$table = defaultNull($select, "table");
	$id_field = defaultNull($select, "id_field");
	$display_field = defaultNull($select, "display_field");
	//if ($connection == null or $table == null or $id_field == null or $display_field == null) return;

	$label = defaultEmpty($select, "label");
	$default_id = defaultNull($select, "default_id");

	$queryResult = $connection->query("
		SELECT $id_field, $display_field FROM $table
		ORDER BY $id_field;
	");

	$options = array();
	foreach ($queryResult as $row) {
		$options[] = array($row[$id_field], $row[$display_field]);
	}

	return generateSelect(array(
		"name" => $id_field,
		"label" => $label,
		"options" => $options,
		"default_value" => $default_id
	));
}

?>
