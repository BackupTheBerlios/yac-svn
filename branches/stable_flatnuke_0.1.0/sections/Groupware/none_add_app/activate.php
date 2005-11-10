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

# require config file
require_once("misc/groupware/config.php");


# initializing general object
$groupware_general = new groupware_general;

# initalizing config object
$groupwareConfig = new groupwareConfig;

# initializing string class
$stringClass = new string;

# initializing users object
$usersClass = new users;

# the service is active?
$groupwareConfig->is_active();

# is a logged user?
$groupwareConfig->guest_allowed();


if(!isset($_POST['confirmation_code'])){

	# create FORM object
	$formClass = new form;
			
	# open DocCreation form
	$formClass->openForm("index.php?mod=".$_GET['mod']."&file=".$_GET['file']."&PS=".$_GET['PS'], true, "POST", "add_app");
		
	# add 'social contract' label in BOLD
	$formClass->only_text("<h3>Creazione/ideazione di un nuovo progetto: step 2</h3>");
	
	# welcome to...
	$formClass->only_text($groupware_general->welcome("Per poter completare la fase di creazione di un progetto ti basta inserire il codice di conferma, <strong>allegato alla mail ricevuta</strong>, nel campo sottostante."));
	 	
	# create ID text input
	$formClass->text("confirmation_code", "CONFIRMATION CODE: ");
	
	# crate submit button
	$formClass->submit("", true, "Invia i dati");
	
	# close DocCreation form
	$formClass->closeForm();
	
	
}else{
		session_id($_GET['PS']);
	
		if(sha1($_POST['confirmation_code']) == $_SESSION['ADD_APP_CONFIRM_CODE']){
		
			# adjust sessions
			unset($_SESSION['ADD_APP_CONFIRM_CODE']);
			$_SESSION['ADD_APP_CONFIRM'] = true;
			
			# set URL link
			$url=$_SERVER["PHP_SELF"];
			$url = $url."?mod=".$_GET['mod']."&file=add.php";
			
			echo "Complimenti, ora ti manca un solo passaggio per poter cos&igrave; completare la creazione dell'idea.<br>";
			echo "Per aggiungere un progetto ti basta cliccare su <a href=\"$url\" title=\"Create project: step 3\">questo link</a>.<br>";
			
			echo $url;
		}else{
			fnlog("YAC - activate add app", $_SERVER['REMOTE_ADDR']."||USER ".GROUPWARE_CURRENT_USER.": CONFIRMATION CODE is not valid");
			die("CONFIRMATION CODE is not valid!<br>Accident will be reported.");
		}
	
	
}


?>