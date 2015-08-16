<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "dbproject";

$con = new mysqli($server, $user, $password, $db);
if($con->connect_error){
	die("Connection to Database Failed");
}




?>