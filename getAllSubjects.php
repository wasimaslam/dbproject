<?php
	require_once 'connect.php';
    require_once 'core.php';
	session_start();
	$sid = $_SESSION['id'];
    $dno = $_SESSION['dno'];
    $sql = "SELECT * FROM `course` WHERE `C.dno` = $dno";
    $result = $con->query($sql);
	$array = "";
    if (($result->num_rows) > 0) {
        $i = 0;
		while ($tuple = $result->fetch_assoc()) {
            $cid = $tuple['C.cid'];
            $cname = strtoupper($tuple['C.cname']);
			if (!isEnrolled($sid, $cid)) {
				$array[$i] = $tuple;
				$i++;
            }
        }
    }
	echo json_encode($array);
?>