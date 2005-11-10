<?php

require_once("misc/groupware/class/string_class.php");

require_once("misc/groupware/class/xml_class.php");

require_once("misc/groupware/class/users_class.php");

require_once("misc/groupware/class/form_class.php");

require_once("misc/groupware/config.php");


class projects_general extends users{

var $box_type = 0;
	
	function create_project($name, $category, $intro, $description, $by){
		$stringClass = new string;
		$date = $stringClass->get_current_date();
	}
	
	function idea_short_preview($data, $dir){
		
		
		if(is_array($data)){
			sort($data);
			$counted_data = count($data);
			for($i = 0; $i <= $counted_data; $i++){
				$file = $data[$i];
				$this->__internal_preview($file, $dir);
				if($i % 2){
				
					#initialize Form Class
					$formClass = new form;
				
					# create TOP link
					$formClass->link_top();
					echo "<br>";
				}
			}
		}else{
// 			$this->__internal_preview($data, $dir);
		}
		
		
	}
	
	function __internal_preview($file, $dir, $type = "adoption"){
		
		# initialize XML class
		$xmlClass = new xml;
		
		# get XML file without comments
		$xml_contents = $xmlClass->get_xml_file($dir.$file, true);
		
		# get the main element
		$project = $xmlClass->get_xml_element("project", $xml_contents);
		
		# get the project name
		$name = $xmlClass->get_xml_element("name", $project);
		
		# get project category
		$appType = $xmlClass->get_xml_element("appType", $project);
		
		# get the project ideator
		$by = $xmlClass->get_xml_element("by", $project);
		
		# get the project short description
		$intro = $xmlClass->get_xml_element("intro", $project);
		
		# get the project main description
		// $main = get_xml_element("main", $project);
		
		# initialize string class
		$stringClass = new string;
		
		# execute text2html function
		$name = $stringClass->text2html($name);
		$by = $stringClass->text2html($by);
		$intro = $stringClass->text2html($intro);
		// $main = $this->string::text2html($main);
		
		if($name != "" OR $by != "" OR $intro != ""){
			# printout informations
			echo "<br><h2>Nome: <a href=\"index.php?mod=".$_GET['mod']."&file=view.php&id=".eregi_replace(".xml", "", $file)."&type=adoption\">$name</a></h2>";
			echo "<blockquote><strong>By</strong>: ".users::profile_link($by)." <span style=\"margin-left:10%;\"><strong>Type</strong>: $appType</span><br>";
			echo "$intro <br>";
			$this->__option_box($file, $type);
			echo "</blockquote>";
		}else{
			# if there isn't informations
// 			echo "errore";
		}
	}
	
	function idea_big_preview($file, $dir, $type = "adoption", $optionbox = true){
		
		# initialize XML class
		$xmlClass = new xml;
		
		# get XML file without comments
		$xml_contents = $xmlClass->get_xml_file($dir.$file, true);
		
		# get the main element
		$project = $xmlClass->get_xml_element("project", $xml_contents);
		
		# get the project name
		$name = $xmlClass->get_xml_element("name", $project);
		
		# get project category
		$appType = $xmlClass->get_xml_element("appType", $project);
		
		# get the project ideator
		$by = $xmlClass->get_xml_element("by", $project);
		
		# get the project short description
		$intro = $xmlClass->get_xml_element("intro", $project);
		
		# get the project main description
		$main = $xmlClass->get_xml_element("main", $project);
		
		# initialize string class
		$stringClass = new string;
		
		# execute text2html function
		$name = $stringClass->text2html($name);
		$by = $stringClass->text2html($by);
		$intro = $stringClass->text2html($intro);
		$main = $stringClass->text2html($main);
		
		if($name != "" OR $by != "" OR $intro != ""){
			# printout informations
			echo "<h2>$name</h2>";
			echo "<strong>By</strong>: ".users::profile_link($by)." <span style=\"margin-left:10%;\"><strong>Type</strong>: $appType</span><br><br><div align=\"left\">";
			echo "$intro <br><br>";
			echo "$main </div>";
			if($optionbox == true){
				$this->__option_box($file, $type);
			}
		}
	}
	
	function __option_box($file, $type){
		echo "<br><div class=\"under\">";
		if($this->box_type == 1){
			echo "<a href=\"index.php?mod=".GROUPWARE_MOD_PATH."none_project&type=$type&id=".eregi_replace(".xml", "", $file)."\">Visualizza</a>";
		}else{
			echo "<a href=\"index.php?mod=".GROUPWARE_MOD_PATH."none_mantainer&type=$type&id=".eregi_replace(".xml", "", $file)."\">Diventa il mantainer!</a>";
		}
		echo " <a href=\"index.php?mod=".GROUPWARE_MOD_PATH."none_sign_prj_man&type=$type&id=".eregi_replace(".xml", "", $file)."\">Segnala cambiamenti</a>";
		if(groupware_is_admin()){
			echo " <span style=\"color:red\">";
			echo " <a href=\"index.php?##\">Modifica</a>";
			echo " <a href=\"#\" onclick=\"check('verify.php?mod=delnews&file=misc/groupware/writeable/projects/$type/$file')\">Elimina</a>";
			echo "</span>";
		}
		echo "</div><br>";
	}
	
	function check_list($id, $type){
		if($type != "adoption" OR $type != "orfan"){
			return false;
		}elseif(!file_exists("misc/groupware/writeable/projects/$type/$id")){
			return false;
		}else{
			return true;
		}
		
	}
	
	function make_aviable(){
		
	}
	
	# create project menu
	function create_project_menu($id, $contents_up = "", $with_logo = true){
		$main = (string) "";
		if($with_logo){
			$main .= "<img src=\"misc/groupware/writeable/projects/shared/".$id."/images/logo.png\" alt=\"$id project logo\" style=\"float:right; padding: 2px;\" width=\"64\" height=\"64\">";
		}
		$main .= $contents_up;
		
		return $main;
	}
}

?>
