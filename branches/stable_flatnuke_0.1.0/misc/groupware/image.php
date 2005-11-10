<?php

require("class/images_class.php");

require("class/string_class.php");

$stringClass = new string;

session_start();

session_id($_GET['sessid']);

$imagesClass = new images;

switch($_GET['type']){
	case "project_confirm_ID":
		$type = "project_confirm_ID";
	break;
	case "add_project_confirm_ID":
		$type = "add_project_confirm_ID";
	break;
}

$imagesClass->print_image($_SESSION[$type]);

?>