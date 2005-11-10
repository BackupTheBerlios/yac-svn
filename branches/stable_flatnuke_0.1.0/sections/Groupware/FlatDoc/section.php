<?php

# require shared.php file
require_once("shared.php");

# require FORM creation class
require_once("misc/groupware/class/form_class.php");

# require XMLcreation class
require_once("misc/groupware/class/xml_class.php");


# path where are the documents
define("FNDOC_WRITEABLE", "misc/groupware/writeable/FlatDoc/");

# this section
define("FNDOC_SECTION", "sections/".$_GET['mod']."/");


if(!isset($_POST['submit'])){

	# create FORM object
	$formClass = new form;
	
	# open DocCreation form
	$formClass->openForm("index.php?mod=".$_GET['mod'], true, "POST", "DocCreation");
	
	# create TextInput
	$formClass->text("title", "Titolo:");
	
	# create TextInput for the number of page
	$formClass->text("docPage", "Numero di pagina:");
	
	$opDir = opendir(FNDOC_WRITEABLE);
	$array = array(array("[crea categoria]"), array("[crea categoria]"));
	while($file = readdir($opDir)){
		if($file != "." AND $file != ".."){
			$array['0'][] = $file;
			$array['1'][] = $file;
		}

	}
	
	# create selectBox where put the sections
	$formClass->select("category", $array, "Categoria:");
	
	# create TextInput for the creation of a category
	$formClass->text("newCategory", "Crea categoria:");
	
	# create TextArea
	$formClass->textarea("mainText", "Testo del documento:");
	
	# crate submit button
	$formClass->submit("", true, "Invia i dati");
	
	# close DocCreation form
	$formClass->closeForm();
	
}else{
	
	# create XML object
	$xmlClass = new xml;
	
	# start XML file cration
	$xmlClass->createXMLFile();
	
	# eregi all whitespaces from string
	$docTitle = eregi_replace(" ", "_", $_POST['title']);
	
	# if is checked the option `[crea categoria]' create a new directory in the
	# FlatDoc writeable directory
	if($_POST['category'] == "[crea categoria]" AND !file_exists(FNDOC_WRITEABLE.$_POST['newCategory'])){
		if(mkdir(FNDOC_WRITEABLE.$_POST['newCategory'])){
			echo "Categoria creata con successo!";
			$_POST['category'] = $_POST['newCategory'];
		}else{
			trigger_error("Impossiile creare la directory `".$_POST['newCategory']."' in `".FNDOC_WRITEABLE."'", E_USER_ERROR);
		}
	}elseif($_POST['category'] == "[crea categoria]"){
		trigger_error("Categoria già esistente, inserisco all'interno il documento.", E_USER_NOTICE);
		$_POST['category'] = $_POST['newCategory'];
	}
	
	# set XML file path
	$xmlClass->setPath(FNDOC_WRITEABLE.$_POST['category']."/".$_POST['docPage'].".xml");
	
	# add Name XMLElement to contents
	$xmlClass->add_XML_element("name", $_POST['title']);
	
	# add MainText XMLElement to contents
	$xmlClass->add_XML_element("mainText", $_POST['mainText']);
	
	# set overwrite variable to true
	$xmlClass->setOverWrite(true);
	
	# complete XML file creation
	$xmlClass->closeXMLFile();
	 
}

?>