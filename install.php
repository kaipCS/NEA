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
$stmt = $conn->prepare("DROP TABLE IF EXISTS questionhaskeyword;
CREATE TABLE questionhaskeyword 
(questionid INT(4) NOT NULL,
keyword VARCHAR(50) NOT NULL,
PRIMARY KEY(questionid,keyword))
");
$stmt->execute();
$stmt->closeCursor();
#echo("question has keyword table created");
#create user creates paper table 
$stmt = $conn->prepare("DROP TABLE IF EXISTS usercreatespaper;
CREATE TABLE usercreatespaper 
(paperid INT(5) AUTO_INCREMENT PRIMARY KEY,
userid INT(4) NOT NULL, 
date DATE DEFAULT CURRENT_DATE, 
time INT(3), 
title VARCHAR(100), 
details TEXT,
singlequestion TINYINT(1) NOT NULL)
");
$stmt->execute();
$stmt->closeCursor();
#echo("user creates paper table created");
#create userdoespapertable
$stmt = $conn->prepare("DROP TABLE IF EXISTS userdoespaper;
CREATE TABLE userdoespaper 
(userid INT(4) NOT NULL, 
paperid INT(5) NOT NULL,
singlequestion TINYINT(1) NOT NULL, 
PRIMARY KEY(userid, paperid))
");
$stmt->execute();
$stmt->closeCursor();
#echo("user does paper table created");
#create questioninpaper table
$stmt = $conn->prepare("DROP TABLE IF EXISTS questioninpaper;
CREATE TABLE questioninpaper 
(paperid INT(5) NOT NULL,
questionid INT(4) NOT NULL,
questionnumber INT(2) NOT NULL,
singlequestion TINYINT(1) NOT NULL, 
PRIMARY KEY(questionid, paperid))
");
$stmt->execute();
$stmt->closeCursor();
#echo("question in paper table created");
#create userdoespaperdoesquestion table 
$stmt = $conn->prepare("DROP TABLE IF EXISTS userdoespaperdoesquestion;
CREATE TABLE userdoespaperdoesquestion 
(userid INT(4) NOT NULL, 
questionid INT(4) NOT NULL,
paperid INT(5) NOT NULL,
mark INT(2),
note TEXT,
complete TINYINT(1) NOT NULL,
singlequestion TINYINT(1) NOT NULL, 
PRIMARY KEY(userid, questionid, paperid))
");
$stmt->execute();
$stmt->closeCursor();
echo("all tables created")
?>



