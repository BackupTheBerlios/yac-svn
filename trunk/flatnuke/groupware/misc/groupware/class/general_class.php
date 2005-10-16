<?php

require("misc/groupware/config.php");

class groupware_general{
	
	function welcome($text){
		return "<br>".$text."<br>";
	}
	
	function error($text){
		return "$text<br>";
	}
	
	function print_modable($file){
		echo "<br>".implode("", file($file))."<br><br><a href=\"index.php?mod=".GROUPWARE_MOD_PATH."none_admin&amp;file=edit_html.php&amp;what=".$file."\" title=\"Edit ".$file."\">Edit</a>";
	}
}

?>