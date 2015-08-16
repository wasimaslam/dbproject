<?php
require "connect.php";
require "core.php";
session_start();


$sql = "INSERT INTO `student` (`S.fname`, `S.lname`, `S.dno`, `S.username`, `S.password`) VALUES (?,?,?,?,?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("ssiss", $sFname, $sLname, $sDno, $sUsername, $password);
$sFname = $sLname = $sDno = $sUsername = $password = "";
$sUsernameErr = "";
$query_executed = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sFname = strtolower(safeInput($_POST['sFname']));
    $sLname = strtolower(safeInput($_POST['sLname']));
    $sDno = safeInput($_POST['tDno']);
    $sUsername = strtolower(safeInput($_POST['sUsername']));
    $password = md5(safeInput($_POST['sPassword']));

    if (!SUsernameExists($sUsername)) {
        if ($stmt->execute() === TRUE) {
            $query_executed = 1;
        } else {
            $query_executed = 2;
            echo "Query wasn't successful<br>";
        }
    } else {
        $sUsernameErr = "Username already taken. Choose another one.";
    }
}
?>
<div title="student_signup" align="center">
    <h1>Student Signup</h1>
    <form method="post" id="student_signup">
        <b>First Name: </b>
        <input type="text" name="sFname" title="Like Faizan, Wasim etc. Without spaces and special characters." value="<?php if (!$query_executed) echo $sFname; ?>" pattern="^[a-zA-Z\s]+$" required autofocus>
        <span style="color: #FF0000"><sup>*</sup></span>
        <br><br>
        <b>Last Name: </b><input type="text" name="sLname" title="Like Faizan, Wasim etc. Without spaces and special characters." value="<?php if ($query_executed != 1) echo $sLname; ?>" pattern="^[a-zA-Z\s]+$" required>
        <span style="color: #FF0000"><sup>*</sup></span>
        <br><br>
        <b>Username: </b><input type="text" name="sUsername" title="Without space" value="<?php if ($query_executed != 1) echo $sUsername; ?>"  required>
        <span style="color: #FF0000"><sup>*</sup><?php echo ' ' . $sUsernameErr; ?></span>
        <br><br>
        <b>Password: </b><input type="password" title="Upto 50 words" name="sPassword" value=""  required>
        <span style="color: #FF0000"><sup>*</sup></span>
        <br><br>
        <b>Department: </b>
        <select name="tDno" title="Select a department" required>
            <option value=""></option>
            <?php
            $sql1 = "SELECT `D.dname` FROM `department` ORDER BY `D.dno`;";
            $result = $con->query($sql1);
            $dvalue = 1;
            while ($row = $result->fetch_assoc()) {
                $dname = strtoupper($row['D.dname']);
                echo "<option value=\"$dvalue\">$dname</option>";
                $dvalue++;
            }
            ?>
        </select>
        <span style="color: #FF0000"><sup>*</sup></span>
        <br><br>
        <input type="submit" value="Submit">
    </form>
    <?php
    if ($query_executed == 1) {
        echo "<span style=\"color:red\">Account Created Sucessfully. Click below to login: </span><br/> ";
    } else if ($query_executed == 2) {
        echo "<br><span style=\"color:red\">ID Was Not Created</span><br/>";
    }
    ?>
    <a href="login.php">Already have an account? Sign In.</a>
</div>