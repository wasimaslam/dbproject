<?php
require_once "connect.php";
require_once "core.php";
session_start();
session_unset();

$err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = strtolower(safeInput($_POST['username']));
    $password = md5($_POST['password']);
    $sql = "";
    if (isset($_POST['teacher_login'])) {
        $sql = "SELECT * FROM `teacher` WHERE `T.username` = '$username' AND `T.password` = '$password' ORDER BY `T.tid`";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $tuple = $result->fetch_assoc();
            $_SESSION['teacher'] = "";
            $_SESSION['id'] = $tuple['T.tid'];
            $_SESSION['fname'] = $tuple['T.fname'];
            $_SESSION['lname'] = $tuple['T.lname'];
            $_SESSION['dno'] = $tuple['T.dno'];
            $_SESSION['username'] = $tuple['T.username'];
            echo '<meta http-equiv="refresh" content="0;url=index.php">';
        } else {
            $err = "<span style=\"color:red\">Username Or Password Wrong.</span><br>";
        }
    } else if (isset($_POST['student_login'])) {
        $sql = "SELECT * FROM `student` WHERE `S.username` = '$username' AND `S.password` = '$password' ORDER BY `S.sid`";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $tuple = $result->fetch_assoc();
            $_SESSION['student'] = "";
            $_SESSION['id'] = $tuple['S.sid'];
            $_SESSION['fname'] = $tuple['S.fname'];
            $_SESSION['lname'] = $tuple['S.lname'];
            $_SESSION['dno'] = $tuple['S.dno'];
            $_SESSION['username'] = $tuple['S.username'];

            echo '<meta http-equiv="refresh" content="0;url=index.php">';
        } else {
            $err = "<span style=\"color:red\">Username Or Password Wrong.</span><br>";
        }
    }
}
?>

<div title="login_form" align="center">
<h1>Login</h1>
<form method="POST">
    <tr><b>Username: </b><input type="text" name="username" title="Without spaces." required autofocus>
    <br><br>
    <b>Password: </b><input type="password" name="password" title="Upto 50 words." required>
    <br><br>
    <input type="submit" value="Login" name="student_login">
    <input type="submit" value="Login as teacher" name="teacher_login" >
    <br/><br/>
<?php echo $err; ?>
</form>
<p style="color:red">Don't have an account? Sign up right now: </p>
<a href="student_signup.php" style="text-decoration:none"><button>Signup As Student</button> </a>
<a href="teacher_signup.php" style="text-decoration:none"><button>Signup As Teacher</button> </a>
</div>