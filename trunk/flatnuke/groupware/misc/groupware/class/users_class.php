<?php
/*
* $Id: users_class.php,v 0.30 2005/06/30 14:47:27 gigasoft Exp $
 * Users class for flatnuke
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
 * Users class
 *
 * With this class you can get/modify users info
 *
 * @package Groupware
 *
 * @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
 * @version 1.0
 * @copyright Copyright (c) 2003-2005
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License
 */


class users{
	
	/**
	* Get username
	*
	* This function return username if really exists else return false
	*
	* @param string username optional
	*
	*/
	function get_user($user = ""){
		if($user != ""){
			$_COOKIE['myforum'] = $user;
		}
		if(isset($_COOKIE['myforum'])){
			if(file_exists("forum/users/".$_COOKIE['myforum'].".php")){
				return $_COOKIE['myforum'];
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	/**
	*
	*
	*
	*
	*
	*/
	function profile_link($user){
		return "<a href=\"forum/index.php?op=profile&user=".$this->get_user($user)."\">".$this->get_user($user)."</a>";
	}
	

	
}


/*********************************************************
*        SCRIVI IL CODICE - SCRIVI IL CODICE - SCRIVI IL..          *
*********************************************************/
function groupware_is_admin(){
	return true;
}
?>