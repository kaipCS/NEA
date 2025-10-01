<?php
session_start();

if ($_SESSION['role'] == 0){
    header('Location: papers-student.php');
    exit();
}
else{
    header('Location: papers-teacher.php');
    exit();
}
?>