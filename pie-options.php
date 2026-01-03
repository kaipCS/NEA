<?php
session_start();

#set option selected in the session 
$_SESSION["pie-options"] = $_POST["pie-options"];

#redirect back to the stats page
header("Location: stats.php");
?>