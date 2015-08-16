<?php
session_start();
if (isset($_SESSION['student'])) {
    $name = strtoupper($_SESSION['fname']." ".$_SESSION['lname']);
    echo "Welcome $name<br/><br/>";
    echo "<a href=\"enrollment.php\">Enrol</a><br/><br/>";
    echo "<a href=\"enrolled_subjects.php\">List of enrolled subjects</a><br/><br/>";
    echo "<a href=\"delete.php\">Delete Account</a><br/>";
    echo "<br/><a href=\"logout.php\" ><button>Logout</button></a><br/><br/>";
} else if (isset($_SESSION['teacher'])) {
    echo "Welcome teacher<br><br>";
    echo "<a href = \"enrolled_students.php\">Enrolled Students</a><br><br>";
    echo "<a href=\"delete.php\">Delete Account</a><br/><br/>";
    echo "<br/><a href=\"logout.php\" ><button>Logout</button></a>";
} else {
    session_destroy();
    require_once "login.php";
}
?>
