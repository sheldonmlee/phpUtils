<?php

function initSession()
{
	if (session_status() != PHP_SESSION_NONE) return ;

	isset($_SERVER["DOCUMENT_ROOT"])? $home = $_SERVER["DOCUMENT_ROOT"] : $home = null; 
	if (!$home) return;
	$session_dir = $home."/../sessionData";

	ini_set("session.save_path", $session_dir);
	session_start();
}

function readSession() {
	initSession();
	echo "<p>";
	print_r($_SESSION);
	echo "</p>";
}
?>
