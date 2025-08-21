<?php
#connect to database
include_once("connection.php");
#delete existing users table
$stmt = $conn->prepare("DROP TABLE IF EXISTS users");
$stmt->execute();
$stmt->closeCursor();
#create users table
$stmt = $conn->prepare("CREATE TABLE users 
(userid INT AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(254) NOT NULL,
forename VARCHAR(50) NOT NULL,
surname VARCHAR(50) NOT NULL,
role TINYINT(1) NOT NULL,
schoolID VARCHAR(5),
password VARCHAR(255) NOT NULL,
UNIQUE (email))
");
$stmt->execute();
$stmt->closeCursor();
#message indicating successful creation
#echo("users table created");
#delete existing questions table
$stmt = $conn->prepare("DROP TABLE IF EXISTS questions");
$stmt->execute();
$stmt->closeCursor();
#create questions table
$stmt = $conn->prepare("CREATE TABLE questions 
(questionid INT AUTO_INCREMENT PRIMARY KEY,
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
#delete existing keywords table
$stmt = $conn->prepare("DROP TABLE IF EXISTS keywords");
$stmt->execute();
$stmt->closeCursor();
#create keywords table
$stmt = $conn->prepare("CREATE TABLE keywords 
(keyword VARCHAR(100) PRIMARY KEY NOT NULL)
");
$stmt->execute();
$stmt->closeCursor();
#echo("keyword table created");
#delete existing question has keyword table
$stmt = $conn->prepare("DROP TABLE IF EXISTS questionhaskeyword");
$stmt->execute();
$stmt->closeCursor();
#create question has keyword table
$stmt = $conn->prepare("CREATE TABLE questionhaskeyword 
(questionid INT NOT NULL,
keyword VARCHAR(100) NOT NULL,
PRIMARY KEY(questionid,keyword))
");
$stmt->execute();
$stmt->closeCursor();
#echo("question has keyword table created");
#delete existing user creates paper table
$stmt = $conn->prepare("DROP TABLE IF EXISTS usercreatespaper");
$stmt->execute();
$stmt->closeCursor();
#create user creates paper table 
$stmt = $conn->prepare("CREATE TABLE usercreatespaper 
(paperid INT AUTO_INCREMENT PRIMARY KEY,
userid INT NOT NULL, 
dateedited DATE,
time INT(3),
title VARCHAR(100) NOT NULL, 
details TEXT)
");
$stmt->execute();
$stmt->closeCursor();
#echo("user creates paper table created");
#delete existing user does paper table
$stmt = $conn->prepare("DROP TABLE IF EXISTS userdoespaper");
$stmt->execute();
$stmt->closeCursor();
#create userdoespapertable
$stmt = $conn->prepare("CREATE TABLE userdoespaper 
(userid INT NOT NULL, 
paperid INT NOT NULL,
singlequestion TINYINT(1) NOT NULL, 
PRIMARY KEY(userid, paperid))
");
$stmt->execute();
$stmt->closeCursor();
#echo("user does paper table created");
#delete existing question in paper table
$stmt = $conn->prepare("DROP TABLE IF EXISTS questioninpaper");
$stmt->execute();
$stmt->closeCursor();
#create question in paper table
$stmt = $conn->prepare("CREATE TABLE questioninpaper 
(paperid INT NOT NULL,
questionid INT NOT NULL,
questionnumber INT(3) NOT NULL,
singlequestion TINYINT(1) NOT NULL, 
PRIMARY KEY(questionid, paperid))
");
$stmt->execute();
$stmt->closeCursor();
#echo("question in paper table created");
#delete existing user does paper does question table
$stmt = $conn->prepare("DROP TABLE IF EXISTS userdoespaperdoesquestion");
$stmt->execute();
$stmt->closeCursor();
#create user does paper does question table 
$stmt = $conn->prepare("CREATE TABLE userdoespaperdoesquestion 
(userid INT NOT NULL, 
questionid INT NOT NULL,
paperid INT NOT NULL,
mark INT(2),
note TEXT,
complete TINYINT(1) NOT NULL,
singlequestion TINYINT(1) NOT NULL, 
datecompleted DATE,
PRIMARY KEY(userid, questionid, paperid))
");
$stmt->execute();
$stmt->closeCursor();
echo("all tables created")
?>



