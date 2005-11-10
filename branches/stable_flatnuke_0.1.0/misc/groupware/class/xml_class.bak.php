<?php

class xml{

# would you use the debug system?  ( true || false )
var $debug = true;

# can overwrite a file?  ( false || true )
var $overWrite = false;

# default path of the file  ( string )
var $filePath = "";

# the contents of the xml file
var $contents;

# is creating an XML file?
var $creationStatus = false;

# is frozen?
var $freeze = false;

	# begin XML file creation process
	function createXMLFile(){
		if($this->creationStatus AND $this->debug){
			trigger_error("Cannot create two or more XML files in the same moment. FREEZING...<br>");
			$this->creationStatus = false;
			$this->freeze = true;
			return false;
		}elseif($this->creationStatus AND !$this->debug){
			$this->creationStatus = false;
			$this->freeze = true;
			return false;
		}else{
			$this->creationStatus = true;
			$this->contents = "<?xml version='1.0'?>\n";
			return true;
		}
	}
	
	# add an XML element to contents
	function add_XML_element($element, $text){
		
		if($this->creationStatus){
			$this->contents .= "<".$element.">".$text."</".$element.">\n";
			return false;
		}elseif(!$this->creationStatus AND $this->debug){
			trigger_error("Cannot add an element to XML document. Creation process is not already started. FREEZING...<br>");
			return false;
		}
		
	}
	
	# set the path of the XML file
	function setPath($path){
		$this->filePath = $path;
		return true;
	}
	
	# set the overwrite permission
	function setOverWrite($reply){
		if(!is_bool($reply)){
			$reply = false;
		}
		
		$this->overWrite = $reply;
		return true;
	}
	
	# reset all security variabiles and STOP all process
	function killallProcess(){
		$this->filePath = "";
		$this->contents = "";
		$this->creationStatus = false;
		$this->freeze = false;
	}
	
	# create the final file that contains XML code
	function __makeFile(){
		
		if($fp = fopen($this->filePath, "w+")){
			fputs($fp, $this->contents);
			fclose($fp);
			return true;
		}elseif($this->debug){
			trigger_error("Cannot crate XML file in `".$this->filePath."'. FREEZING...<br>");
			$this->freeze = true;
			return false;
		}else{
			$this->freeze = true;
			return false;
		}
	}
	
	# complete creation process
	function closeXMLFile(){
		
		if($this->filePath == "" AND $this->debug) {
			trigger_error("You <strong>must</strong> run `<i>setPath( string PATH )</i>' function before close the creation process. FREEZING...<br>");
			$this->freeze = true;
			
		}elseif($this->filePath == "" AND !$this->debug){
			$this->freeze = true;
		}else{
			// [continue] //
		}
		
		if(!$this->creationStatus AND $this->debug){
			trigger_error("You must begin a cration status.");
			return false;
		}elseif(!$this->creationStatus AND !$this->debug){
			return false;
		}elseif($this->creationStatus){
			if(file_exists($this->filePath) AND !$this->overWrite AND !$this->debug){
				$this->freeze = true;
				return false;
			}elseif(file_exists($this->filePath) AND $this->overWrite){
			
			}elseif(file_exists($this->filePath) AND !$this->overWrite AND $this->debug){
				trigger_error("File already exists, you cannot overwrite it. Use `setOverWrite( bool )' function to set it permission temporanely. FREEZING...<br>");
				$this->freeze = true;
			}
			
			if(!$this->freeze){
				if($this->__makeFile()){
					echo "CREATION PROCESS succesfull completed!!!";
					return true;
				}
			}elseif($this->freeze AND $this->debug){
				trigger_error("You cannot close XML file while the status is freeze.", E_USER_ERROR);
				exit;
				return false;
			}elseif($this->freeze AND !$this->debug){
				exit;
				return false;
			}
			
		}
	}
	
}

?>