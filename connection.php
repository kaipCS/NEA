<?php
#login details
$servername = "localhost";
$username="root";
$password="password";
$dbname="step";

$conn =new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
#message indicating successful connection
#echo("connected");
?>

