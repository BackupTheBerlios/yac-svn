<?php

# require config file
require("misc/groupware/config.php");

# require users class
require("misc/groupware/class/users_class.php");

class groupwareConfig extends users{
	
	function is_active(){
		if(GROUPWARE_ISACTIVE){
			// [ continue ] //
			return true;
		}else{
			die(GROUPWARE_NOTACTIVE);
			return false;
		}
	}
	
	function guest_allowed(){
		if(!GROUPWARE_ALLOW_GUEST AND !users::get_user()){
			die(GROUPWARE_ALLOW_GUEST_TEXT);
		}
	}
	
}

?>