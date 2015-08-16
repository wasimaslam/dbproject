<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['student'])) {
    die();
}
?>

<?php
    require_once 'connect.php';
    $query_executed = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sid = $_SESSION['id'];
        $cid = $_POST['enrolled'];
        $sql = "DELETE FROM `student_enrols_course` WHERE `En.sid`=$sid AND `En.cid`=$cid";
        if($con->query($sql) === TRUE){
            $query_executed = 1;
        }
        else{
            $query_executed = 2;
        }
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
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
    </head>
    <body>
        <form method = "POST">
            <h1 align="center">Enrolled Subjects</h1>
            <table align="center">
                <tr><th>Course ID</th><th>Course Name</th><th>Deroll</th></tr>
                <?php
                require_once 'connect.php';
                $sid = $_SESSION['id'];
                $sql = "SELECT `C.cname`, `C.cid` FROM `course`, `student_enrols_course`"
                        . "WHERE `C.cid`=`En.cid` AND `En.sid`=$sid";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    while ($tuple = $result->fetch_assoc()) {
                        $cid = $tuple['C.cid'];
                        $cname = strtoupper($tuple['C.cname']);
                        echo "<tr><td>$cid</td><td>$cname</td><td><button type=\"submit\" name=\"enrolled\" value=\"$cid\">Deroll</button></td></tr>";
                    }
                } else {
                    echo '<tr><th colspan=3>No courses to show</th></tr>';
                }
                ?>

            </table>
        </form>
    </body>
</html>
