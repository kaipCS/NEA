<?php
session_start();
session_unset();
session_destroy();

#redirect back to sign in page
header('Location: signin.php');
?>