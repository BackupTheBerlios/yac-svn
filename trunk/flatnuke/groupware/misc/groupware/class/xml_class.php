<?php
/*
 * $Id: xml_class.php,v 0.35RC1 2005/08/04 22:38:27 gigasoft Exp $
 * XML class
 * Copyright (C) 2004 Giovanni Piller Cottrer
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the license, or any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA
 */

/**
 * XML class
 *
 * This file contains a class to create/modify/manipulate XML files
 *
 * <note>
 * If you want to support me, you can visit my site or make a donation (this
 * feature will be aviable soon :D)
 * 
 * Excuse me for bad English...
 *
 * http://gigasoft.altervista.org/
 * </note>
 *
 * <to-do>
 * Those are the features that I will insert in this class.
 *
 * - Functions to create XML file/contents   <OK>
 * - Functions to read XML strings   <OK>
 * - Functions to check XML string   <VERY-PARTIAL>
 * - Functions to modify/delete XML   <NO>
 * - Function to Check XML syntax   <NO>
 * - Real indentation in XML strings   <OK>
 * - Functions to manage XML attributes   <NO>
 * - Functions to create dinamically RSS Feeds   <NO>
 * - Function to read remote and local RSS files as you want   <NO>
 * - Functions to transpose XML to Array and reverse process   <NO-REMOTE>
 *        * I have tested a simple method to do it but can do only one
 *          transposition and the reverse process is more difficult to do.
 * - Functions to set all the DTD that you need   <NO>
 * - Function to make all Beer that you need :D   <HOW-DO-THIS?>
 * 
 * I can't do all this things alone. Or I can, but very slowly.
 * If you want you can support me...
 * </to-do>
 *
 * @package Xml
 *
 * @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
 * @version 0.30RC2
 * @copyright Copyright (c) 2003-2005
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License
 */


/**
* provvisory include (only for the correct rewriting of some function picked up
* from flatnuke)
*
* @include flatnuke shared functions
*/
#include_once("shared.php");


/**
* Simple class to create/modify/delete XML
*
* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
*/
class xml{

/**
* use Debug system?
*
* @var bool
* @access public
*/
var $debug = true;

/**
* can OverWrite?
*
* @var bool
* @access public
*/
var $overWrite = false;

/**
* default Path of file
*
* @var string
*/
var $filePath = "";

/**
* contents of XML string (DO NOT EDIT!)
*
* @var NULL
*/
var $contents = NULL;

/**
* is creating an XML string/file? (DO NOT EDIT!)
*
* @var bool
*/
var $creationStatus = false;

# is frozen?
/**
* is frozen? (DO NOT EDIT!)
*
* @var bool
*/
var $freeze = false;

/**
* Array that contain indentation levels (DO NOT EDIT!)
*
* @var int
*/
var $indentations = 0;



	/**
	* Begin XML file creation process
	*
	* This function initializing the creation process to generate an XML
	* document.
	* You can't create two or more XML documents in the same moment.
	* If you do it, all the processes will be freezed
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string $encoding enconding type
	* @param bool $disable_direct_acess disable direct accessto file
	* 			   (extension must be *.php)
	*/
	function createXMLFile($encoding = " encoding=\"ISO-8859-1\"", $disable_direct_acess = false){
		if($encoding = " "){
			$encoding = " encoding=\"ISO-8859-1\"";
		}
	
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
			$this->indentations = 0;
			if($disable_direct_acess){
				$this->contents = "<?exit(1);?>\n";
			}
			$this->contents = "<?xml version='1.0'$encoding?>\n";
			return true;
		}
	}
	
	/**
	* Add an XML element
	*
	* This function add an XML element to the current contents.
	* To do this, an XML creation process must_be_started else, it return
	* an error.
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string $element Xml element to create
	* @param string $text The text of te element
	*/
	function add_xml_element($element, $text){
		
		if($this->creationStatus){
			$this->open_xml_element($element, $text);
			$this->close_xml_element($element, "", true);
			return false;
		}elseif(!$this->creationStatus AND $this->debug){
			trigger_error("Cannot add an element to XML document. Creation process is not already started. FREEZING...<br>");
			return false;
		}
		
	}
	
	/**
	* Open XML element
	*
	* This function add an opened XML element to the contents
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string $element element's name
	* @param string $text optional text (inside element)
	*
	* @see close_xml_element()
	*/
	function open_xml_element($element, $text=""){
		if($this->creationStatus){
			$this->contents .= $this->__set_indentation("\n<".$element.">".$text."");
			$this->indentations++;
			return true;
		}elseif(!$this->creationStatus AND $this->debug){
			trigger_error("Cannot add an element to XML document. Creation process is not already started. FREEZING...<br>");
			return false;
		}
	}
	
	/**
	* Close an opened XML element
	*
	* This function close and opened XML element
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string $element element's name
	* @param string $text optional text (inside element)
	* @param bool $no_nl not use newline in this function
	*
	* @see open_xml_element()
	*/
	function close_xml_element($element, $text = "", $no_nl = false){
		# initializing flag
		$xml_flag = true;
	
		# add new line to $text
		if($text != "" AND !$no_nl){
			$text = "\n".$text;
		}elseif($text != "" AND $no_nl){
			// [continue]
		}
		
		if(substr_count($this->contents, "<".$element.">") > substr_count($this->contents, "</".$element.">")){
			// [continue]
		}else{
			# there aren't opened XML element like `$element' to close
			$xml_flag = false;
			return false;
		}

		
		if($this->creationStatus AND $xml_flag){
			$this->indentations--;
			
			if($no_nl){
				$this->contents .=$text."</".$element.">";
			}else{
				$this->contents .= $this->__set_indentation($text."\n</".$element.">");
			}
			return true;
		}elseif(!$this->creationStatus AND $this->debug){
			trigger_error("Cannot add an element to XML document. Creation process is not already started. FREEZING...<br>");
			return false;
		}
	}
	
	/**
	* Add a comment
	*
	* Add a comment to current $contents class var
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string $text text to comment
	*/
	function add_comment($text){
		if($this->creationStatus){
			$this->contents .= $this->__set_indentation("\n<!-- ".$text." -->\n");
			return false;
		}elseif(!$this->creationStatus AND $this->debug){
			trigger_error("Cannot add a comment to XML document. Creation process is not already started. FREEZING...<br>");
			return false;
		}
	}
	
	/**
	* Add $repeat newline
	*
	* Add n new line as $repeat variable
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param int $repeat n° of newline output
	*/
	function add_nl($repeat = 1){
		if($this->creationStatus AND $xml_flag){
			$this->contents .= str_repeat("\n", $repeat);
			return false;
		}elseif(!$this->creationStatus AND $this->debug){
			trigger_error("Cannot ".$repeat." new line to XML document. Creation process is not already started. FREEZING...<br>");
			return false;
		}
	}
	
	/**
	* Set the location of the file
	*
	* Set 'filePath' class variabile with the path of the new XML file
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string File path
	*/
	function setPath($path){
		$this->filePath = $path;
		return true;
	}
	
	/**
	* Set the overwrite permissions
	*
	* The question is: can you overwrite an existent file? :D
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param bool
	*/
	function setOverWrite($reply){
		if(!is_bool($reply)){
			$reply = false;
		}
		
		$this->overWrite = $reply;
		return true;
	}
	
	/**
	* Reset all
	*
	* Reset all class variabiles and delete all current processes
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*/
	function killallProcess(){
		$this->filePath = "";
		$this->contents = "";
		$this->creationStatus = false;
		$this->freeze = false;
	}
	
	/**
	* Set indentation of XML elements
	*
	* This function is used in all the part of code where is created an XML
	* element. This provide a level indentations on the current element.
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string $text XML element text with tags
	*
	* @see *_xml_element() (only functions that make XML elements!)
	*/
	function __set_indentation($text){
		$return = str_repeat(" ", $this->indentations).$text;
		
		if(substr_count($text, "\n") > 0){
		
			$return = str_replace("\n", "\n".str_repeat(" ", $this->indentations), $text);
		}
		
		return $return;
	}
	
	/**
	* Create XML file
	*
	* This function write to the xml file the value of the class variabile
	* 'contents' but only if there is a process active
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @access private
	*/
	function __makeFile(){
		
		if($fp = fopen($this->filePath, "w+")){
			fputs($fp, $this->contents);
			fclose($fp);
			return true;
		}elseif($this->debug){
			trigger_error("Cannot create XML file in `".$this->filePath."'. FREEZING...<br>");
			$this->freeze = true;
			return false;
		}else{
			$this->freeze = true;
			return false;
		}
	}
	
	/**
	* Complete creation process
	*
	* Complete creation process and reset all class veriabiles used.
	*
	*@author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*/
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
					echo "CREATION PROCESS succesfully completed!!!<br>\n";
					$this->killallProcess();
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
	
	/**
	* Verify if XML element exists
	*
	* This is a very useful function that permti you to verify if an XML
	* element exists.
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string $element The element to verify
	* @param string $source XML source
	*
	* @return bool
	*/
	function xml_element_exists($element, $source){
		if(substr_count($source, "<".$element.">") > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	* Semi-Automatize XML creation process
	*
	* This function can automatize the creation of an XML fle using the
	* names and the value of the inputs. This function became very useful
	* when there are multiples input to inflate in a XML file.
	* You can ignore items putting the attribute '__nn_' first of the rest
	* of the name.
	* All '__ob_' strings are removed from the item name.
	* If you use the third parameter, we will indent all the other elements
	* with a whitespace to identify that elements block quikly.
	*
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string $file The location where the file will be created
	* @param array $array a superglobal array (usually $_POST)
	* @param string $upperElement an optional main element
	*/
	function autopilot($file, $array, $by = "", $upperElement = ""){
		
		# starting autoprocessing pilot
		$this->createXMLFile();
		
		# set path
		$this->setPath($file);
		
		if($upperElement != ""){
			$this->open_xml_element($upperElement);
		}

		# verify if the posted data is correctly sended
		while(list($key, $value) = each($array)){
			
			# initializing flag
			$flag_two = false;
		
			if(substr($key, 0, 5) == "__ob_"){
			
				# delete the string '__ob_'
				$xml_name = eregi_replace("__ob_", "", $key);
				
			}elseif(substr($key, 0, 5) == "__nn_" OR substr($key, 0, 6) == "submit"){
				
				# setting up flag_two
				$flag_two = true;
				
			}else{
				# set $xml_name as key
				$xml_name = $key;
			}
			
			# if the "flag man" say 'false' we can continue
			if(!$flag_two){
				
				if($upperElement != ""){
					# add a whitespace for indentation
					$this->contents .= " ";
				}
				
				# add xml element as $key
				$this->add_xml_element($xml_name, $value);
			}
		}
		
		if($by != ""){
			# add xml element as $key
			$this->add_xml_element("by", $by);
		}
		
		if($upperElement != ""){
			$this->close_xml_element($upperElement);
		}
		
		# complete XML creation process
		$this->closeXMLFile();
	}
	
	/**
	* Get the first XML element founded
	*
	* This function will return you the content of the first XML element.
	* 
	* @author Simone Vellei <simone_vellei@users.sourceforge.net>
	*
	* @param string $element the name of the element
	* @param string $text the XML string
	*
	* @see get_xml_array(), get_xml_file()
	*/
	function get_xml_element($element, $text){
		$buff = ereg_replace(".*<".$element.">","",$text);
		$buff = ereg_replace("</".$element.">.*","",$buff);
		return $buff;
	}
	
	/**
	* Get the arry of all element selected
	*
	* This function get an array from the list of all the elements called as
	* $element variable
	*
	* @author Simone Vellei <simone_vellei@users.sourceforge.net>
	*
	* @param string $element the name of the elements
	* @param string $text the XML string
	*
	* @see get_xml_element(), get_xml_file()
	*/
	function get_xml_array($element, $text){
		$buff = explode("</".$element.">",$text);
		array_splice ($buff, count($buff)-1);
		return $buff;
	}
	
	/**
	* Get an XML file
	*
	* This function return the text contained in a XML file.
	* 
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string $element file path
	* @param bool $text set it to false to get text_and_comments
	*
	* @see get_xml_array(), get_xml_element(), get_file()
	*/
	function get_xml_file($file, $comments = true){
		
		if(!file_exists($file)){
			trigger_error("Non riesco a trovare il file $file", E_USER_ERROR);
		}
		
		# get the file contents excluding PHP execution
		$contents = implode("", file($file));
		
		# delete all comments
		if($comments){
			$contents = eregi_replace("<!- * ->", "", $contents);
		}
		
		# return contents
		return $contents;
	}
	
	/**
	* Get file contents
	*
	* This function can return you the contents of a file
	*
	* @author Simone Vellei <simone_vellei@users.sourceforge.net>
	*
	* @param string $filename path of the file
	*
	* @see get_xml_file()
	*/
	function get_file($filename){
		
		$fd = fopen ("$filename", "r");
		if($fd==""){
			die(_NONPUOI);
		}
		while (!feof ($fd)) {
			$buffer = fgets($fd, 4096);
			$string.=$buffer;
		}
		fclose ($fd);
		return $string;
	}
	
	/**
	* Auto-Generate an RSS file <
	*
	* @author basic source by Marco Segato <segatom@yahoo.it>
	* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
	*
	* @param string $id 
	*/
	function project2RSS($id) {
		global $sitename, $siteurl, $newspp, $admin_mail;
		// tag apertura del feed
		$this->createXMLFile();
		
		$body = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n<rss version=\"2.0\">\n\t<channel>\n";
		# general informations
		$body .= "\t\t<title>$sitename</title>\n\t\t<link>$siteurl</link>\n\t\t<description><![CDATA[\"$sitename\" HEADLINES]]></description>\n";
		$body .= "\t\t<managingEditor>$admin_mail</managingEditor>\n\t\t<generator>Groupware RSS generator - XML class 1.0 by Gigasoft</generator>\n";
		$body .= "\t\t<lastBuildDate>".date("D, d M Y H:i:s",time())." GMT</lastBuildDate>\n";
		# load news sorted by data
		$handle = opendir($id);
		$modlist = "";
		while ($file = readdir($handle)) {
			if (!( $file=="." or $file=="..") and (!ereg("^\.",$file) and ($file!="CVS"))) {
				$modlist .= "$file ";
			}
		}
		closedir($handle);
		$modlist = explode(" ", $modlist);
		rsort($modlist);
		# create a Tag for every news
		for ($i=0; $i < sizeof($modlist)-1; $i++) {
			if ($i>=$newspp)
				break;
			$string = get_file("news/$modlist[$i]");
			$mytitle = get_xml_element("fn:title",$string);
			$mydesc = str_replace("<br>","<br />",get_xml_element("fn:header",$string));
			$id = str_replace(".xml","",$modlist[$i]);
			$body .= "\t\t<item>\n";
			$body .= "\t\t\t<title>$mytitle</title>\n";
			$body .= "\t\t\t<link>$siteurl/index.php?mod=read&amp;id=$id</link>\n\t\t\t<description><![CDATA[$mydesc]]></description>\n";
			$body .= "\t\t\t<pubDate>".date("D, d M Y H:i:s",$id)." GMT</pubDate>\n";
			$body .= "\t\t</item>\n";
		}
		
		# last tag
		$body.="\t</channel>\n</rss>";
		
		# return Feed RSS
		return $body;
	}
	
}

?>