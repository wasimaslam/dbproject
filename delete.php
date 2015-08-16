<?php

session_start();    
if(!isset($_SESSION['student']) && !isset($_SESSION['teacher'])){
    die();
}
?>

<?php
require_once 'connect.php';

if(isset($_SESSION['student'])){
    $sid = $_SESSION['id'];
    $sql = "DELETE FROM `student` WHERE `S.sid`=$sid";
    if($con->query($sql)===TRUE){
        session_destroy();
        echo '<meta http-equiv="refresh" content="0;url=index.php">';
    }
    else{
        echo "COULD NOT DELETE YOUR ACCOUNT DUE TO SOME TECHNICAL ERRORS.<br/>";
        echo "<a href=\"index.php\">Go back to main page.</a>";
    }
}
else if(isset ($_SESSION['teacher'])){
    $tid = $_SESSION['id'];
    $sql = "DELETE FROM `teacher` WHERE `T.tid`=$tid";
    if($con->query($sql)===TRUE){
        session_destroy();
        echo '<meta http-equiv="refresh" content="0;url=index.php">';
    }
    else{
        echo "COULD NOT DELETE YOUR ACCOUNT DUE TO SOME TECHNICAL ERRORS.<br/>";
        echo "<a href=\"index.php\">Go back to main page.</a>";
    }
}

?>
