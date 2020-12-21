<?php
require_once("utils.php");

// example of how to generate form.
$form = array( 
	"method" => Method::GET,
	"target" => "test.php",
	"inputs" => array(
		array("type" => Input::TEXT, "label" => "First name:", "name" => "first_name"),
		array("type" => Input::TEXT, "label" => "Last name:", "name" => "last_name"),
		array("type" => Input::TEXT, "label" => "readonly:", "name" => "readonly",  "value" => "sample_text", "readonly"),
		array("type" => Input::TEXT, "label" => "misc", "name" => "misc", "id" => "miscellaneous", "value" => "I have a custom ID", "readonly"),
		array("type" => Input::DATE, "label" => "Date:", "name" => "date"),
		array("type" => Input::SUBMIT)
	)
);

echo generateForm($form);

print_r($_REQUEST);
?>
