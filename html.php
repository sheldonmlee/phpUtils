<?php
//
// HTML generation
//


//
// Forms
//

function defaultNull($arr, $key) { return isset($arr[$key])? $arr[$key] : null; }
function defaultEmpty($arr, $key) { return isset($arr[$key])? $arr[$key] : ""; }
function defaultString($arr, $key, $default) { return isset($arr[$key])? $arr[$key] : $default; }

abstract class Method {
	const GET = "get";
	const POST = "post";
}

// encapsulates constants used as inputs
abstract class Input 
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

	// returns array of constants
	private static function getConstants()
	{
		$reflect = new ReflectionClass(get_called_class());
		return $reflect->getConstants();
	}

	// check if constant exists
	static function exists($name)
	{
		return in_array($name, self::getConstants());
	}
}


// Takes an array() as input. Works for html <input>.
function generateInput($input)
{
	$type = defaultNull($input, "type");

	// lambdas to generate <input> or <select> elements.
	// all lambdas inerit $input
	$generateInputSelect = function() use($input)
	{
		return "";
	};

	$generateInputGeneral = function() use ($input, $type)
	{
		$name = defaultNull($input, "name");
		$id = defaultNull($input, "id");
		$label = defaultEmpty($input, "label");
		$value = defaultEmpty($input, "value");
		$readonly = in_array("readonly", $input)? "readonly" : "";

		if ($id == null) $id = $name;

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
	case Input::SELECT:
		return $generateInputSelect();
		break;
	case Input::SUBMIT:
		return $generateInputSubmit();
		break;
	default:
		return $generateInputGeneral();
	}
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
			$output .= generateInput($input);
		}
	}
	$output .= "</form>";

	return $output;
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
