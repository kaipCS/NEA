<?php
session_start();
unset($_SESSION["results"]);
unset($_SESSION["sort"]);
unset($_SESSION["questionid"]);
header("Location: questionspage.php");
?>