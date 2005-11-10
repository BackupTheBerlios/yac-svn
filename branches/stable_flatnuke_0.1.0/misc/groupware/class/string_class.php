<?php

# this class manage string output style.
class string{

	# return the current date with thetime
	function get_current_date(){
// 		$date = getdate();
// 		$sec = $date['seconds'];
// 		$min = $date['minutes'];
// 		$hours = $date['hours'];
// 		$mday = $date['mday'];
// 		$wday = $date['wday'];
// 		$mon = $date['mon'];
// 		$year = $date['year'];
// 
// 		return $mday.$mond.$year.$hours.$min.$sec;
		return time();
	}
	
	# regular expression to make text to link
	function make_url($string){
		#$string = eregi_replace("(www+).([^[:space:]]*)([[:alnum:]#?/&=])", "<a href=\"http://\\1.\\2\\3\" target=\"_blank\">\\1.\\2\\3</a>", $string);
		$string = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", "<a href=\"\\1://\\2\\3\" target=\"_blank\">\\1://\\2\\3</a>", $string);
		$string = eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))", "<a href=\"mailto:\\1\">\\1</a>", $string);
		return $string;
	}

	# html the code
	function text2html($text){
		$text = eregi_replace("<", "&lt;", $text);
		$text = eregi_replace(">", "&gt;", $text);
		$text = htmlspecialchars($text);
		$text = stripslashes($text);
		$text = $this->make_url($text);
		$text = nl2br($text);
		$text = eregi_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $text);
		$text = eregi_replace("  ", "&nbsp;&nbsp;", $text);
		
		return $text;
	}

	function check_address($addr, $check_dns = false) {
		if(preg_match('/^(\w|\.|\-)+@\w+(\.\w+)*\.[a-zA-Z]{2,4}$/',$addr)) {
			if($check_dns) {
				$host = explode('@', $addr);
				if( checkdnsrr($host[1], 'MX') ) return true;
				if( checkdnsrr($host[1], 'A') ) return true;
				if( checkdnsrr($host[1], 'CNAME') ) return true;
			} else {
			return true;
			}
		}
		return false;
	}
	
	function get_microtime(){
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = doubleval($mtime[1]) + doubleval($mtime[0]);
	return ($mtime);
	}
	
	function get_random_id(){
		$microtime = $this->get_microtime();
		$parsedID = explode(".", $microtime);
		
		return $parsedID['0']{1}.$parsedID['0']{3}.$parsedID['1'].$parsedID['0']{4};
		
	}
	
}

?>