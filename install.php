<?php
#connect to database
include_once("connection.php");
$stmt = $conn->prepare("DROP TABLE IF EXISTS users;
CREATE TABLE users 
(userid INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(254) NOT NULL,
forename VARCHAR(50) NOT NULL,
surname VARCHAR(50) NOT NULL,
role TINYINT(1) NOT NULL,
schoolID INT(5),
password VARCHAR(255) NOT NULL,
UNIQUE (email))
");
$stmt->execute();
$stmt->closeCursor();
#message indicating successful creation
echo("users table created");
?>


