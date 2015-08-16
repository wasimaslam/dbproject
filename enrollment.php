<?php
session_start();
if (!isset($_SESSION['student'])) {
    die();
}
?>
<?php
require_once "connect.php";
require_once 'core.php';

function isLimitFull() {
    $sid = $_SESSION['id'];
    $sql = "SELECT COUNT(*) AS `total` FROM `student_enrols_course` WHERE `En.sid`=$sid";
    $result = $GLOBALS['con']->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total = $row['total'];
        if ($total < 6) {
            return false;
        } else {
            return true;
        }
    }
}

$limitErr = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!isLimitFull()) {
        $sql = "INSERT INTO `student_enrols_course`(`En.cid`, `En.sid`) VALUES(?,?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $cid, $sid);
        $cid = safeInput($_POST['enrolled']);
        $sid = $_SESSION['id'];
        if (!($stmt->execute() === TRUE)) {
            echo "Subject wasn't enrolled due to some technical issues.<br/>";
        }
    } else {
        $limitErr = "You cannot enrol in more than 6 subjects<br/>";
    }
}
?>

<!DOCTYPE html>
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
        <h1>Enrollment Form</h1>
        <?php echo "<span style=\"color:red\">$limitErr</span><br/><br/>"; ?>
        <form method="POST">
            <table>
                <tr><th>Course Name</th><th>Enrol</th></tr>
                <?php
                require_once 'connect.php';
                require_once 'core.php';

                $sid = $_SESSION['id'];
                $dno = $_SESSION['dno'];
                $sql = "SELECT * FROM `course` WHERE `C.dno` = $dno";
                $result = $con->query($sql);
                if (($result->num_rows) > 0) {
                    while ($tuple = $result->fetch_assoc()) {
                        $cid = $tuple['C.cid'];
                        $cname = strtoupper($tuple['C.cname']);
                        if (!isEnrolled($sid, $cid)) {
                            echo "<tr>"
                            . "<td>$cname</td>"
                            . "<td>"
                            . "<button type=\"submit\" name=\"enrolled\" value=\"$cid\">Enroll</button>"
                            . "</td>"
                            . "</tr>";
                        }
                    }
                } else {
                    echo '<tr><th colspan="2">No courses to show</th></tr>';
                }
                ?>
            </table>
        </form>
    </center>
</body>
</html>