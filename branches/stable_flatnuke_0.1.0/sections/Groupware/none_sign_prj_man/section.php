<?php

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

# is a L4M3r?
$projectsClass->check_list($_GET['id'], $_GET['type']);

echo $groupware_general->error("<h2>ATTENZIONE:</h2> questa funzionalità non è stata ancora abilitata. Ti preghiamo di riprovare in seguito.");

echo "Questa funzione ti permetterà di essere sempre aggiornato sulle novità di questo progetto.<br>
Ogni attività potrai comodamente scoprirla usando un lettore <a href=\"#\">RSS</a>.<br>
Se sei dunque interessato a <a href=\"index.php?mod=".GROUPWARE_MOD_PATH."view_ideas&file=view.php&id=".$_GET['id']."&type=".$_GET['type']." \" target=\"_blank\">questa idea</a> puoi aggiungere il link sottostante al tuo lettore di file RSS.<br>

<h3>Iscrizione al Feed del progetto</h3>

<em>Se non hai ancora un programma capace di leggere dei Feed RSS, <a href=\"#\">clicca qui</a></em>.<br>";


?>