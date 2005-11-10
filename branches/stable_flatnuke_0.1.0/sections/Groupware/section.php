<?php

# require form class
require_once("misc/groupware/class/form_class.php");

# require xml class
require_once("misc/groupware/class/xml_class.php");

# require config class
require_once("misc/groupware/class/config_class.php");

# require general class
require_once("misc/groupware/class/general_class.php");

# require users class
require_once("misc/groupware/class/users_class.php");

# require string class
require_once("misc/groupware/class/string_class.php");

# require projects class
require_once("misc/groupware/class/projects_class.php");


# initializing general object
$groupware_general = new groupware_general;

# initalizing config object
$groupwareConfig = new groupwareConfig;

# initializing XML class
$xmlClass = new xml;

# initializing projects
$projectsClass = new projects_general;

# the service is active?
$groupwareConfig->is_active();


# print title
echo "<h3>".YAC_INTRODUCTION_SECTION."</h3>";

# print welcome message
#echo $groupware_general->welcome("Benvenuto all'interno di YAC.");
$groupware_general->print_modable("main.html");

?>
