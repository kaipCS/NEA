<?php
session_start();

#set option selected in the session 
$_SESSION["student"] = $_POST["student"];

#redirect back to the stats page
header("Location: stats.php");
?>