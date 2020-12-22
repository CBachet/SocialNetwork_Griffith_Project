<?php

$connection1 = mysqli_connect("localhost", "root", "", "mysql")
 or die(mysqli_error($connection1));

# Create database
$sql="CREATE DATABASE Assignment3_2997131_2997138_2997135_2997133";
mysqli_query($connection1,$sql) or die(mysqli_error($connection1));
sleep(1);

include("database.php");

# Create student table
$sql="CREATE TABLE students(
	student_no int,
	firstname varchar(50),
	lastname varchar(50),
	gender char(1),
	password varchar(100),
	cookie varchar(100))";
mysqli_query($connection,$sql) or die(mysqli_error($connection));


#Create friends table
$sql="CREATE TABLE friends(student_no int,friend_no int)";
mysqli_query($connection,$sql) or die(mysqli_error($connection));

// #Create images table
$sql="CREATE TABLE images(ID int, path varchar(100))";
mysqli_query($connection,$sql) or die(mysqli_error($connection));

// #Create messages table
$sql="CREATE TABLE privatemessages(student_no int,friend_no int, message text, time_sent datetime)";
mysqli_query($connection,$sql) or die(mysqli_error($connection));

#Create comments table
$sql = "CREATE TABLE comments(id int, number text, content text, date datetime)";
mysqli_query($connection,$sql) or die(mysqli_error($connection));

#Create posts table
$sql = "CREATE TABLE posts(
id int,
content text,
date datetime,
image text,
react int,
title text,
number text)";
mysqli_query($connection,$sql) or die(mysqli_error($connection));
?>
	