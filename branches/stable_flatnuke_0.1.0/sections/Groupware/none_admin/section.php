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

# require users class
require_once("misc/groupware/class/users_class.php");

# require config file
require_once("misc/groupware/config.php");


# initializing general object
$groupware_general = new groupware_general;

# initalizing config object
$groupwareConfig = new groupwareConfig;

# initializing users class
$usersClass = new users;

# initializing XML class
$xmlClass = new xml;

# initializing projects
$projectsClass = new projects_general;

# the service is active?
$groupwareConfig->is_active();

# is a logged user?
$groupwareConfig->guest_allowed();

# is a L4M3r?
$projectsClass->check_list($_GET['id'], $_GET['type']);

# initializin FORM class
$formClass = new form;

# if there isn't Posting Data print text editor
if(!isset($_POST['submit']) AND groupware_is_admin()){

	# print JavaScript
	echo '<script language="javascript" type="text/javascript" src="misc/groupware/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
	
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});
</script>
	';
	
	# print title
	echo "<h3>Modifica configurazione: modifica di un file</h3>";
	
	# print welcome message
	echo $groupware_general->welcome("Da questa comoda interfaccia potrai iniziare la personalizzazione di alcuni testi del groupware.<br>");
	
	$formClass->openForm($_SERVER['REQUEST_URI'], false);
	
	$formClass->textarea("text", "", implode("", file($_GET['what'])));
	
	echo("<br>");
	
	$formClass->submit("", true, "Save data");

	$formClass->closeForm($_SERVER['PHP_SELF']);
	
# if there are posting data, write data
}elseif(groupware_is_admin() AND isset($_POST['submit'])){
	
	$fp = fopen($_GET['what'], "w+");
	if($fp){
		fputs($fp, $_POST['text']);
		fclose($fp);
		
		echo "Bene, hai compiuto il tuo dovere....";
	}
}
?>