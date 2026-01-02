<?php
session_start();

$_SESSION["pie-options"] = $_POST["pie-options"];
header("Location: stats.php");
?>