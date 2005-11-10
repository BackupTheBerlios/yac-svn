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

# require config file
require_once("misc/groupware/config.php");

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

$formClass = new form;


$xml = $xmlClass->get_xml_file("misc/groupware/writeable/projects/shared/".$_GET['id']."/main.xml");

$xmlMain = get_xml_element("main", $xml);

$xmlName = stripslashes(get_xml_element("name", $xmlMain));
$xmlMainBlock = stripslashes(get_xml_element("MainBlock", $xmlMain));

echo '<div style="float:right; border: 1px solid lightgray; width: 200px; min-height:80px; padding: 3px">';
echo "<strong>$xmlName</strong><br>";
echo $projectsClass->create_project_menu($_GET['id'], $xmlMainBlock);
echo '</div>';

switch($_GET['body']){
	default :
		$xmlMOTD = stripslashes(get_xml_element("motd", $xmlMain));
		
		echo "<h3>".$xmlName."</h3>";
		echo $xmlMOTD;
	break;
	case "description":
		$xmlDescription = stripslashes(get_xml_element("description", $xmlMain));
		echo "<h3>".$xmlName.": description</h3>";
		echo $xmlDescription;
	break;
	case "ToDo":
		$xmlToDo = stripslashes(get_xml_element("ToDo", $xmlMain));
		echo "<h3>".$xmlName.": To-Do</h3>";
		echo $xmlToDo;
	break;
	
	case "description":
		$xmlDescription = stripslashes(get_xml_element("description", $xmlMain));
		echo "<h3>".$xmlName.": description</h3>";
		echo $xmlDescription;
	break;

	case "ChangeLog":
		$xmlChangeLog = stripslashes(get_xml_element("ChangeLog", $xmlMain));
		echo "<h3>".$xmlName.": ChangeLog</h3>";
		echo $xmlChangeLog;
	break;
}



?>
