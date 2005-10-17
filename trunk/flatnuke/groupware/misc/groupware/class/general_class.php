<?php

require("misc/groupware/config.php");

class groupware_general{
	
	function welcome($text){
		return "<br>".$text."<br>";
	}
	
	function error($text){
		return "$text<br>";
	}
	
	function parse_modable($text){
		$text = ereg_replace("{YAC_SECTION}", GROUPWARE_MOD_PATH, stripslashes($text));
		$text =ereg_replace("%7BYAC_SECTION%7D",  GROUPWARE_MOD_PATH, $text);
		$text = ereg_replace("%7E", "~", $text);
		
		return $text;
	}
	
	function print_modable($file){
		$text = $this->parse_modable(implode("", file($file)));
		echo "<br>".$text."<br><br><a href=\"index.php?mod=".GROUPWARE_MOD_PATH."none_admin&amp;file=edit_html.php&amp;what=".$file."\" title=\"Edit ".$file."\">Edit</a>";
	}
}

?>