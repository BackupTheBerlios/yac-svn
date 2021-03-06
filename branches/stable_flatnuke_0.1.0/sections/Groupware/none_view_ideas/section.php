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

$formClass = new form;

# print title
echo "<h3>Introduzione alla sezione</h3>";

# print welcome message
echo $groupware_general->welcome("Benvenuto. Da questa sezione potrai comodamente visualizzare la lista di tutti i progetti in <a href=\"#adoption\">adozione</a> (che cercano un mantainer) e quella dei progetti <a href=\"#orfan\">orfani</a> (che avevano un mantainer ma ora non pi�).<br>
Cliccando sul nome del progetto si potr� ottenere una scheda con delle informazioni aggiuntive che saranno ovviamente maggiori nel caso in cui il progetto sia orfano.");

# print title
echo "<br><a name=\"adoption\"></a><h3>Lista progetti in adozione</h3>";

# TOP link is auto inserted

$dir = "misc/groupware/writeable/projects/adoption/";
$opdir = opendir($dir);

$data = array();

while($file = readdir($opdir)){
	$data[] = $file;
}


$projectsClass->idea_short_preview($data, $dir);


# print title
echo "<br><a name=\"orfan\"></a><h3>Lista progetti orfani</h3>";

# TOP link is auto inserted

$dir = "misc/groupware/writeable/projects/orfan/";
$opdir = opendir($dir);

$data = array();

while($file = readdir($opdir)){
	$data[] = $file;
}


$projectsClass->idea_short_preview($data, $dir, "orfan");


?>