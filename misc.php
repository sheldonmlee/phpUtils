<?php
// Custom Enum definition;
abstract class Enum 
{
	// returns array of constants
	private static function getConstants()
	{
		$called_class = get_called_class();
		$reflect = new ReflectionClass(get_called_class());
		return $reflect->getConstants();
	}

	// check if constant exists
	static function exists($name)
	{
		return in_array($name, self::getConstants());
	}
}

// functions to return a defult value if array item doesn't exist.
function defaultNull($arr, $key) { return isset($arr[$key])? $arr[$key] : null; }
function defaultEmpty($arr, $key) { return isset($arr[$key])? $arr[$key] : ""; }
function defaultString($arr, $key, $default) { return isset($arr[$key])? $arr[$key] : $default; }

// Function to strip $get arguments from url.
function stripArgs($str)
{
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] == '?') {
            return substr($str, 0, $i);
        }
    }
	return $str;
}
?>
