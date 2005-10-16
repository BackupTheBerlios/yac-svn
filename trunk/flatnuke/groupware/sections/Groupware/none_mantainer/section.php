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

$flag = true;

if($_GET['type'] == "orfan"){
	$flag = false;
}

# Became a mantainer of an adoption idea #
# if there isn't Posting Data print 'became mantainer' message
if(!isset($_POST['submitted']) AND $flag){

	# print JavaScript
	echo '<script type="text/javascript">
	<!--
	function accept_mantainer(){
	if(confirm ("Sei sicuro di voler diventare il mantainer del progetto?"))
		document.mantainer.submit();
	}
	// -->
	</script>';
	
	# print title
	echo "<h3>Creazione progetto: proporsi per un progetto</h3>";
	
	# print welcome message
	echo $groupware_general->welcome("Benvenuto. Questa interfaccia ti guiderà nel processo di acquisizione del progetto seguente.<br>");
	
	echo "<div style=\"width:80%; border:1px solid lightgray; padding: 3px; text-align:center;\">";
	$projectsClass->idea_big_preview($_GET['id'].".xml", "misc/groupware/writeable/projects/".$_GET['type']."/", $_GET['type'], false);
	echo "</div><br>";
	
	echo $groupware_general->welcome("Diventando il mantainer di un progetto, avrai la possibilità di gestire news interne, informazioni, F.A.Q, appuntamenti, screenshots, downloads e potrai inoltre accettare e gestire eventuali sviluppatori che abbiano voglia di unirsi a te.<br>
	INFO: per poter uploadare direttamente il tuo progetto su questo sito, dovrai farne richiesta esplicita all'amministratore tramite il modulo presente nel tuo pannello gestionale.<br><br>
	
	Per diventare il mantainer del progetto soprastante clicca su link 'Avanti' (deve essere abilitato JavaScript).<br>	
	<form action=\"".$SCRIPT_NAME."\" method=\"post\" name=\"mantainer\">
	 <input type=\"hidden\" name=\"submitted\">
	</form>
	<a href=\"javascript:accept_mantainer()\">Avanti &raquo;</a>");

# if there are posting data, make aviable the project
}else{
	
	/* How to make aviable the project
	
	Make XML data files for current project.
		* general file (motd, description, ChangeLog, ToDo)
		* config file (mantainers, developers etc)
		* project lists (users requests, Admin Nest)
		* appointments (appointments are shared with FlatOrganizer appointments)
		* news (but it must exists before this step)
	all those functions are inserted into `projects_class.php' file on
	make_aviable( string ProjectID, string Type) function;
	*/
	
	# pick up project informations	
	$dir = "misc/groupware/writeable/projects/".$_GET['type']."/";
	
	$file = $_GET['id'].".xml";
	
	# get XML file without comments
	$xml_contents = $xmlClass->get_xml_file($dir.$file, true);
	
	# get the main element
	$project = $xmlClass->get_xml_element("project", $xml_contents);
	
	# get the project name
	$name = $xmlClass->get_xml_element("name", $project);
	
	# get project category
	$appType = $xmlClass->get_xml_element("appType", $project);
	
	# get the project ideator
	$by = $xmlClass->get_xml_element("by", $project);
	
	# get the project short description
	$intro = $xmlClass->get_xml_element("intro", $project);
	
	# get the project main description
	$main = $xmlClass->get_xml_element("main", $project);
	
	# initialize string class
	$stringClass = new string;
	
	# execute text2html function
	/*
	$name = $stringClass->text2html($name);
	$by = $stringClass->text2html($by);
	$intro = $stringClass->text2html($intro);
	$main = $stringClass->text2html($main);
	*/
	
	
	  #################
	# start XML creation process (MAIN FILE)
	$xmlClass->createXMLFile();
	
	# set the Path of the file
	$xmlClass->setPath("misc/groupware/writeable/projects/shared/".$_GET['id']."/".date("D, d M Y H:i:s", $stringClass->get_current_date())."main.xml");
	
	##############################ATTENTION!!!
	$xmlClass->setOverwrite(true);
	
	# add comment
	$xmlClass->add_comment(XML_CLASS_COMMENT);
	
	# open XML element
	$xmlClass->open_xml_element("main");
	
	# open XML element
	$xmlClass->open_xml_element("main");
	
	# add XML element (Name)
	$xmlClass->add_xml_element("name", $name);
	
	# add XML element (MOTD)
	$xmlClass->add_xml_element("motd", $intro);
	
	# add XML element (Description)
	$xmlClass->add_xml_element("description", $main);
	
	# add XML element (ChangeLog)
	$xmlClass->add_xml_element("ChangeLog", "Change Log for ".$name."\n\nLast Update ".date("D, d M Y H:i:s", $stringClass->get_current_date())." ".$_COOKIE['myforum']."\n");
	
	# add XML element (ToDo list)
	$xmlClass->add_xml_element("ToDo", "Modify me! (ToDo list)");
	
	# close XML element
	$xmlClass->close_xml_element("main", "Created on ".date("D, d M Y H:i:s", $stringClass->get_current_date())." by ".$_COOKIE['myforum']);
	
	# close XML element
	$xmlClass->close_xml_element("main");
	
	# close XML creation process
	$xmlClass->closeXMLFile();
	
	
	   #########################	
	# start XML creation process (CONFIG FILE)
	$xmlClass->createXMLFile(" ", true);
	
	# set the Path of the file
	$xmlClass->setPath("misc/groupware/writeable/projects/shared/".$_GET['id']."/config.php");
	
	# add comment
	$xmlClass->add_comment(XML_CLASS_COMMENT);
	
	# open main element
	$xmlClass->open_xml_element("config");
	
	# open mantainers element
	$xmlClass->open_xml_element("mantainers");
	
	# insert user as mantainer
	$xmlClass->add_xml_element("name", $usersClass->get_user());
	
	# close mantainers element
	$xmlClass->close_xml_element("mantainers");
	
	# open developers element
	$xmlClass->open_xml_element("developers");
	
	# close developers element
	$xmlClass->close_xml_element("developers");
	
	# close main element
	$xmlClass->close_xml_element("config", "Last Update ".date("D, d M Y H:i:s", $stringClass->get_current_date())."");
	
	# write XML file (CONFIG)
	$xmlClass->closeXMLFile();
	
	
	   ##########################
	# start XML creation process (PROJECT LISTS)
	$xmlClass->createXMLFile(" ", true);
	
	# set the Path of the file
	$xmlClass->setPath("misc/groupware/writeable/projects/shared/".$_GET['id']."/lists.php");
	
	# add comment
	$xmlClass->add_comment(XML_CLASS_COMMENT);
	
	# add main element
	$xmlClass->open_xml_element("lists");
	
	# add request list element
	$xmlClass->open_xml_element("users:requests");
	
	# close request list element
	$xmlClass->close_xml_element("users:request");
	
	# open Admin Nest lists
	$xmlClass->open_xml_element("admin:nest");
	
	# open example message main element
	$xmlClass->open_xml_element("message");
	
	# add an example message user
	$xmlClass->add_xml_element("message:user", "Site Admin");
	
	# add an example message time
	$xmlClass->add_xml_element("message:time", date("D, d M Y H:i:s", $stringClass->get_current_date()));
	
	# add an example message time
	$xmlClass->add_xml_element("message:text", "Hi, welcome to Admin Nest list. Here you can leave messages that only mantainers can view.");
	
	# close example message main element
	$xmlClass->close_xml_element("message");
	
	# close Admin Nest list
	$xmlClass->close_xml_element("admin:nest");
	
	# open Admin Nest lists
	$xmlClass->open_xml_element("developers:nest");
	
	# open example message main element
	$xmlClass->open_xml_element("message");
	
	# add an example message user
	$xmlClass->add_xml_element("message:user", "Site Admin");
	
	# add an example message time
	$xmlClass->add_xml_element("message:time", date("D, d M Y H:i:s", $stringClass->get_current_date()));
	
	# add an example message time
	$xmlClass->add_xml_element("message:text", "Hi, welcome to Admin Nest list. Here you can leave messages that only mantainers and developers can view.");
	
	# close example message main element
	$xmlClass->close_xml_element("message");
	
	# close Admin Nest list
	$xmlClass->close_xml_element("developer:nest");
	
	# close file
	$xmlClass->closeXMLFile();
	
	
	   #######################	
	# start making appointments directory
	# set the Path of the file
	mkdir("misc/groupware/writeable/projects/shared/".$_GET['id']."/appointments/");

	# print congratulation message
	echo "<br>Da ora, potrai iniziare ad amministrare il tuo progetto.<br>Per fare ciò dirigiti immediatamente alla sua pagina e entra nel menù di amministrazione.";
}
?>