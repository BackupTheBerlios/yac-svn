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
 
 class files {
 
 	function __write($where, $mode = "w+", $contents = ""){
		$fp = fopen($where, $mode);
		fputs($fp, $contents);
		fclose($fp);
	}

	function create_file(){
		
	}
 
 }
 
 ?>