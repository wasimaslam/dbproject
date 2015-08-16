<!DOCTYPE html>
<?php 
    session_start();
    if(!isset($_SESSION['teacher'])){
        die();
    }
?>
<?php require_once 'connect.php';?>
<html>
    <head>
        <meta charset="UTF-8">
        <style>
            table, th, td {
                border: 1px solid black;
            }

            th, td {
                padding-left: 10px;
                padding-right: 20px;
                text-align: center;
            }
        </style>
        <title></title>
    </head>
    <body>
    <center>
        <form name="course_select" method = "POST">
            <select name="cid" required>
                <option value=""></option>
                <?php
                $tid = $_SESSION['id'];
                $sql = "SELECT * FROM `course` WHERE `C.tid` = $tid";
                $result = $con->query($sql);
                if($result->num_rows){
                while ($row = $result->fetch_assoc()) {
                    $cname = strtoupper($row['C.cname']);
                    $cid = $row['C.cid'];
                    echo "<option value=\"$cid\">$cname</option>";
                }
                }
                ?>
            </select>
            <input type="submit" value="Load Students">
        </form>
        <br/><br/><br/>
        <?php
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $cid = $_POST['cid'];
            $sql = "SELECT `S.fname`,`S.lname`,`S.sid` FROM `student`,`student_enrols_course` WHERE `S.sid` = `En.sid` AND `En.cid` = $cid";
        
            $result = $con->query($sql);
            echo "<table>";
			echo "<tr><th>Student ID</th><th>Name</th></tr>";
			while($row = $result->fetch_assoc()){
                $sname = $row['S.fname']." ".$row['S.lname'];
                $sname = strtoupper($sname);
                $sid = $row['S.sid'];
                echo "<tr><td>$sid</td><td>$sname</td></tr>";
            }
			echo "</table>";
        }
        
        ?>
        </center>
    </body>
</html>