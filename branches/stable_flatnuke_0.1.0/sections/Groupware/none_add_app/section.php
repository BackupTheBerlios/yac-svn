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


if(!isset($_POST['email'])){

	# save confirm ID
	$_SESSION['add_project_confirm_ID'] = $stringClass->get_random_id();

	# create FORM object
	$formClass = new form;
			
	# open DocCreation form
	$formClass->openForm("index.php?mod=".$_GET['mod']."&file=".$_GET['file'], true, "POST", "add_app");
		
	# add 'social contract' label in BOLD
	$formClass->only_text("<h3>Creazione/ideazione di un nuovo progetto: step 1</h3>");
	
	# welcome to...
	$formClass->only_text($groupware_general->print_modable("add_app.1.0.html"));


/*	 	$groupware_general->welcome("Benvenuto.
	 Da questa sezione potrai aggiungere un nuovo progetto alla lista ed eventualmente diventarne mantainer.<br>Prima di tutto ci&ograve; dovrai farti inviare un codice di conferma ad un tuo indirizzo valido.<br>
	 Ti baster&agrave; seguire le istruzioni contenute nella email che ti sar&agrave; recapitata.<br>
	 Ricorda inoltre che la sessione che hai appena attivato avr&agrave; una durata limitata, e che non potrai creare pi&ugrave; di un progetto per volta durante la stessa.") */


	# create ID text input
	$formClass->text("email", YAC_EMAIL.": ");
	
	# crate submit button
	$formClass->submit("", true);
	
	# close DocCreation form
	$formClass->closeForm();
	
}else{

	if($stringClass->check_address(trim($_POST['email']))){
	
		$_SESSION['ADD_APP_CONFIRM_CODE'] = $stringClass->get_random_id();
	
		$message = implode("", file("misc/groupware/documents/check_email"));
		$url=$_SERVER["PHP_SELF"];
		$message .= $url."?mod=".$_GET['mod']."&file=activate.php".$_GET['file']."&PS=".session_id()."";		
		$message .= "\n\nCONFIRMATION CODE: ".$_SESSION['ADD_APP_CONFIRM_CODE'];
		
		$sendmail = mail($_POST['email'], "Code activation for ".GROUPWARE_TITLE." site", $message, "From: ".GROUPWARE_TITLE." Team <".GROUPWARE_CHECK_EMAIL.">");
		
		$_SESSION['ADD_APP_CONFIRM_CODE'] = sha1($_SESSION['ADD_APP_CONFIRM_CODE']);
		
		#########################################
		#########################################
		#########################################
		#########################################
		#########################################
		#########################################
		if($sendmail){
			echo "<strong>OCCHIO che il codice era volutamente buggato</strong><br>";
			echo "Ti &egrave; stata inviata una mail contenente le istruzioni necessarie al completamento dell'operazione da te richiesta.<br><br>";
			echo "Il testo contenuto &egrave;:<br><pre>$message</pre>";
			
			
		}else{
			echo "Siamo spiacenti ma ci risulta impossibile inviarle l'email di conferma, riprovi in seguito...<br>";
		}
		
	}else{
		die("Indirizzo email non valido!");
	}
	
}


?>
