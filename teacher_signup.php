<?php
require_once "connect.php";
require_once "core.php";
include 'header.html';

$sql = "INSERT INTO `teacher` (`T.fname`, `T.lname`, `T.dno`, `T.username`, `T.password`) VALUES (?,?,?,?,?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("ssiss", $tFname, $tLname, $tDno, $tUsername, $tPassword);
$tFname = $tLname = $tDno = $tUsername = $tPassword = "";
$tUsernameErr = "";
$query_executed = 0;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tFname = strtolower(safeInput($_POST['tFname']));
    $tLname = strtolower(safeInput($_POST['tLname']));
    $tDno = $_POST['tDno'];
    $tUsername = strtolower(safeInput($_POST['tUsername']));
    $tPassword = md5($_POST['tPassword']);

    if (!tUsernameExists($tUsername)) {
        if ($stmt->execute() === TRUE) {
            $query_executed = 1;
        } else {
            $query_executed = 2;
            echo "Query wasnt successful<br>";
        }
    } else {
        $tUsernameErr = "Username Already Exists.<br>";
    }
}
?>
<div class="container">
    <h1>Teacher Signup</h1>
    <form method="POST" id="teacher_signup">
        <b>First Name: </b>
        <input type="text" name="tFname" title="Like Faizan, Wasim etc. Without spaces and special characters." pattern="^[a-zA-Z\s]+$" required autofocus>
        <span style="color: #FF0000"><sup>*</sup></span>
        <br><br>
        <b>Last Name: </b><input type="text" title="Like Faizan, Wasim etc. Without spaces and special characters." name="tLname" pattern="^[a-zA-Z\s]+$" required>
        <span style="color: #FF0000"><sup>*</sup></span>
        <br><br>
        <b>Username: </b><input type="text" title="Without space" name="tUsername" required>
        <span style="color: #FF0000"><sup>*</sup><?php echo ' ' . $tUsernameErr; ?></span>
        <br><br>
        <b>Password: </b><input type="password" title="Upto 50 words" name="tPassword" required>
        <span style="color: #FF0000"><sup>*</sup></span>
        <br><br>
        <b>Department: </b>
        <select name="tDno" title="Select a department" required>
            <option value=""></option>
<?php
$sql = "SELECT `D.dname` FROM `department` ORDER BY `D.dno`;";
$result = $con->query($sql);
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
        <br><br>
    </form>

<?php
if ($query_executed == 1) {
    echo "<span style=\"color:red\">Account Created Sucessfully. Click below to login: </span><br/>";
} else if ($query_executed == 2) {
    echo "<br><span style=\"color:red\">ID Was Not Created</span><br/>";
}
?>

    <a href="login.php">Already have an account? Sign In.</a>
</div>
