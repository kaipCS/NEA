<?php
#connect to database
include_once("connection.php");
#create users table
$stmt = $conn->prepare("DROP TABLE IF EXISTS users;
CREATE TABLE users 
(userid INT(4) AUTO_INCREMENT PRIMARY KEY,
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
#echo("users table created");
#create questions table
$stmt = $conn->prepare("DROP TABLE IF EXISTS questions;
CREATE TABLE questions 
(questionid INT(4) AUTO_INCREMENT PRIMARY KEY,
year INT(4) NOT NULL,
paper TINYINT(1) NOT NULL,
topic VARCHAR(50) NOT NULL,
code TEXT NOT NULL,
solution VARCHAR(200),
area TINYINT(1) NOT NULL)
");
$stmt->execute();
$stmt->closeCursor();
#echo("questions table created");
#create keywords table
$stmt = $conn->prepare("DROP TABLE IF EXISTS keywords;
CREATE TABLE keywords 
(keyword VARCHAR(50) PRIMARY KEY NOT NULL,
UNIQUE (keyword))
");
$stmt->execute();
$stmt->closeCursor();
#echo("keyword table created")
#create question has keyword table
?>


