<?php
session_start();
unset($_SESSION["results"]);
unset($_SESSION["sort"]);
header("Location: test.php");
?>