<?php
session_start();

$_SESSION["sort"] = $_POST["sort"];
header("Location: questionspage.php");
?>