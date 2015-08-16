<?php
    require_once 'connect.php';
	function safeInput($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	function sUsernameExists($user){
		$sql = "SELECT * FROM `student` WHERE `S.username` = '$user';";
		$result = $GLOBALS['con']->query($sql);
		if($result->num_rows>0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	function tUsernameExists($user){
		$sql = "SELECT * FROM `teacher` WHERE `T.username` = '$user';";
		$result = $GLOBALS['con']->query($sql);
		if($result->num_rows>0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
        
	function isEnrolled($sid,$cid){
		$sql = "SELECT * FROM `student_enrols_course`"
				. "WHERE `En.cid`=$cid AND `En.sid`=$sid";
		$result = $GLOBALS['con']->query($sql);
		if($result->num_rows>0){
			return true;
		}
		else{
			return false;
		}
	}
?>