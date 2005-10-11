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


# initializing general object
$groupware_general = new groupware_general;

# initalizing config object
$groupwareConfig = new groupwareConfig;

# initializing users object
$usersClass = new users;

# the service is active?
$groupwareConfig->is_active();

# is a logged user?
$groupwareConfig->guest_allowed();


if(!isset($_POST['submit'])){

	# create FORM object
	$formClass = new form;
			
	# open DocCreation form
	$formClass->openForm("index.php?mod=".$_GET['mod'], true, "POST", "add_app");
		
	# add 'social contract' label in BOLD
	$formClass->only_text("<h3>Creazione/ideazione di un nuovo progetto</h3>");
	
	# welcome to...
	$formClass->only_text($groupware_general->welcome("Benvenuto.
	 Da questa sezione potrai aggiungere un nuovo progetto alla lista ed eventualmente diventarne mantainer.<br>Prima di inserire un nuovo contenuto, verifica che non sia già presente un idea simile alla tua, così da evitare l'inserimento di duplicati.<br>Ricorda inoltre che dovrai leggere e accettare il contratto posto qui di seguito.<br>"));
	
	# add 'social contract' label in BOLD
	$formClass->only_text("<strong>Contratto sociale:</strong><br>");
	
	# add contract item
	$formClass->readonly("__nn_contract", "", GROUPWARE_CONTRACT, 8, 60);
	
	# add confirm checkbox
	$formClass->checkbox("__nn_contract_accept", "accetto tutti i termini del contratto", "agree");
	
	# add breaklines
	echo("<br><br><br>");
	
	# add 'social contract' label in BOLD
	$formClass->only_text("<h3>Prime impostazioni del progetto</h3>");
	
	# some informations
	$formClass->only_text($groupware_general->welcome("Da qui potrai iniziare a configurare le prime opzioni della tua proposta"));

	# create TextInput
	$formClass->text("__ob_name", "Nome:");
	
	$array = array(file("misc/groupware/documents/apps_type"), file("misc/groupware/documents/apps_type"));
	
	# create type of app
	$formClass->select("__ob_appType", $array, "Tipo di progetto:");
	
	# create textarea for introdution
	$formClass->textarea("__ob_intro", "Breve introduzione:", "", 3, 60);
	
	# create main textarea page
	$formClass->textarea("__ob_main", "Descrizione approfondita:", "", 8, 60);
	
	# create cehckbox "will be you the mantainer?"
	$formClass->checkbox("__nn_is_mantainer", "Vuoi diventarne da subito il mantainer ufficiale?", "agree");
	
	/*
	* TODO:
	* - create documentation class
	* - add here a (info) button to display some informations
	*/
	# add link to documentation
	# $docClass->add_link("none_add_app", "became_mantainer");
	
	# add breakline
	echo("<br>");
	
	# do you remember the contract??
	$formClass->only_text($groupware_general->welcome("Ti ricordiamo inoltre che, la continuazione dell'operazione, impone l'accettazione di tutte le regole descritte nel nostro <strong>contratto sociale</strong> presente nella prima parte della pagina. Il suddetto documento <strong>andrà accettato</strong> per poterci consentire la conferma della tua inserzione."));
	
	# add breakline
	echo("<br>");
	
	# crate submit button
	$formClass->submit("", true, "Invia i dati");
	
	# close DocCreation form
	$formClass->closeForm();
	
}else{

	# set up a flag
	 $flag = true;
	 
	# user MUST agrees all conditions
	if($_POST['__nn_contract_accept'] != "agree"){
		echo "- Devi accettare il contratto sociale per poter continuare l'inoltro dei dati.<br>";
		$flag = false;
	}
	
	# verify if the posted data is correctly sended
	while(list($key, $value) = each($_POST)){
		if(substr($key, 0, 5) == "__ob_"){
			if($value == "" OR $value == "scegli..."){
				echo "- Non hai compilato il campo obbligatorio <strong>$key</strong>, l'azione non può essere processata.<br>";
				$flag = false;
			}
		}
	}
	if(!$flag){
		# die if there are some errors
		die("<br>Siamo spiacenti, ma a causa di qualche errore, la tua richiesta non può essere inoltrata correttamente al server. Verifica di aver compilato tutti i campi.<br><br><a href=\"javascript:history.back()\" title=\"indietro\">Indietro</a>");
	}
	
	# create STRING object
	$stringClass = new string;
	
	# create XML object
	$xmlClass = new xml;
	
	# set overwrite to true
	$xmlClass->setOverWrite(false);
	
	# starting autopilot
	$xmlClass->autopilot("misc/groupware/writeable/projects/adoption/".$stringClass->get_current_date().".xml", $_POST, $usersClass->__get_user(), "project");
	
}


?>