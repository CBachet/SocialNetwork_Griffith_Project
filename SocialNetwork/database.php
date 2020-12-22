<?php
$host="localhost";
$user="root";
$password="";
#$db=""; #for the fisrt time: to create the database 
$db="Assignment3_2997131_2997138_2997135_2997133"; # connect to your own database once it's set up
$port=3306;

$connection = mysqli_connect($host,$user,$password,$db,$port)
 or die(mysqli_error($connection));
?>


