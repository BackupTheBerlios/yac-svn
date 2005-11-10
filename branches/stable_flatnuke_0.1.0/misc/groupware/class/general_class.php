<?php

require_once("misc/groupware/config.php");

require_once("misc/groupware/class/users_class.php");

$usersClass = new users;

# activate session
session_start();

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
		require("config.php");

		$text = $this->parse_modable(implode("", file("misc/groupware/documents/".YAC_LANG."/".$file)));
		echo $text;
		if(groupware_is_admin()) echo "<br><a href=\"index.php?mod=".GROUPWARE_MOD_PATH."none_admin&amp;file=edit_html.php&amp;what=".$file."\" title=\"Edit `".$file."'\"<img src=\"themes/$theme/images/modify.png\" alt=\"Edit file `".$file."'\"> Edit file</a>";
	}
}

?>
