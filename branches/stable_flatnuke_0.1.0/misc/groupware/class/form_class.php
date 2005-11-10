<?php

/**
 * Classe per gestire la creazione dei form
 *
 * Semplifica la creazione e la gestione dei form HTML fornendo semplici API
 *
 * @package Groupware
 *
 * @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
 * @version 0.90-3
 * @copyright Copyright (c) 2003-2005
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License
 */

require_once("misc/groupware/config.php");

/**
 * Classe unica per la gestione dei form
 *
 * @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
 */
class form{

var $useBold = true;

var $usingTable = false;

var $submit = YAC_SUBMIT;

	function openForm($to, $usingTable = true, $method = "POST", $name = "", $target = ""){
		echo "<form action=\"".$to."\" method=\"".$method."\" target=\"".$target."\" name=\"".$name."\">\n";
		if($usingTable){
			$this->usingTable = true;
		}

		if($this->usingTable){
			echo "<table>\n";
		}
	}

	function text($name, $text, $value = "", $size = ""){
		$this->__openTR($text);
		echo "<input type=\"text\" name=\"".$name."\" value=\"".$value."\" size=\"".$size."\">\n";
		$this->__closeTR();
		
	}

	function select($name, $arrays, $text){
		$this->__openTR($text);
		echo "<select name=\"".$name."\">\n";
		
		for($i = 0; $i < count($arrays['0']); $i++){
			echo "<option value=\"".$arrays['0'][$i]."\">".$arrays['1'][$i]."</option>";
		}
		#$this->closeTR();
	}

	function textarea($name, $text="", $value = "", $rows = 25, $cols = 80){
		$this->__openTR($text);
		echo "<textarea name = \"".$name."\" rows = \"".$rows."\" cols = \"".$cols."\">".$value."</textarea>";
		$this->__closeTR();
	}
	
	function readonly($name, $text, $value = "", $rows = 25, $cols = 80){
		$this->__openTR($text);
		echo "<textarea readonly name = \"".$name."\" rows = \"".$rows."\" cols = \"".$cols."\">".$value."</textarea>";
		$this->__closeTR();
	}
	
	function checkbox($name, $text, $value = "", $TRtext = ""){
		$this->__openTR($TRtext);
		echo "<input type=\"checkbox\" name=\"".$name."\" value=\"$value\"> ".$text."";
		$this->__closeTR();
	}	
	
	function only_text($text, $TRtext = " "){
		$this->__openTR($TRtext);
		echo $text;
		$this->__closeTR();
	}

	function submit($text="", $withReset = false, $value = "", $name = "submit"){
		if($value == ""){
			$value = $this->submit;
		}
		$this->__openTR($text);
		echo "<input type=\"submit\" name = \"".$name."\" value = \"".$value."\">";
		if($withReset)
			echo "&nbsp;&nbsp;&nbsp;<input type=\"reset\" name=\"reset\">";
		$this->__closeTR();
	}

	function link_top($text = "<small style=\"float:right;\">^ TOP ^</small>"){
		echo "<a href=\"#\">".$text."</a>";
	}

	function closeTable(){
		if($this->usingTable){
			echo "</table";
			$this->usingTable = false;
		}
	}

	function closeForm(){
		if($this->usingTable){
			echo "</table>";
			$this->usingTable = false;
		}
		echo "\n</form>";
	}

	function __openTR($text = ""){
		if($this->usingTable)
			echo " <tr>\n  <td align=\"right\" valign=\"top\">";
			if($this->useBold) echo "<strong>";
			echo $text;
			if($this->useBold) echo "</strong>";
			echo "</td>\n  <td>";
	}

	function __closeTR(){
		if($this->usingTable)
			"</td>\n </tr>\n";
	}
	
	
}

?>
