<?php
// example of how to generate form.
require_once("utils.php");
require_once("details.php");

$dbConn = getConnection($details);
$form = array( 
	"method" => Method::GET,
	"action" => "test.php",
	"inputs" => array(
		array("type" => Input::TEXT, "label" => "First name:", "name" => "first_name"),
		array("type" => Input::TEXT, "label" => "Last name:", "name" => "last_name"),
		array("type" => Input::TEXT, "label" => "readonly:", "name" => "readonly",  "value" => "sample_text", "readonly"),
		array("type" => Input::TEXT, "label" => "misc", "name" => "misc", "id" => "miscellaneous", "value" => "I have a custom ID", "readonly"),
		array("type" => Input::DATE, "label" => "Date:", "name" => "date"),
		array(
			"type" => Select::NORMAL,
			"name" => "select",
			"label" => "Select:",
			"options" => array(
				array(1, "one"),
				array(2, "two"),
				array("three")
			),
			"default_value" => "three"
		),
		array(
			"type" => Select::FROM_TABLE,
			"label" => "From table:",
			"connection" => &$dbConn,
			"table" => "nc_director",
			"id_field" => "directorID",
			"display_field" => "directorName",
			"default_id" => 12
		),
		array("type" => Input::SUBMIT)
	)
);

echo generateForm($form);
$dbConn = null;
?>
