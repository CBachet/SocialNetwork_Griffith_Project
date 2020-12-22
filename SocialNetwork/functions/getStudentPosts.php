<?php
function getStudentPosts($student_no){
	global $connection;
	$sql = "SELECT * FROM posts WHERE id='$student_no' ORDER BY date DESC"; //get all posts of one student ordered by uploaded date
	$result = mysqli_query($connection, $sql);
	return ($result);
}

function getPost($number){
	global $connection;
	$sql = "SELECT * FROM posts WHERE number='$number' ";
	$result = mysqli_query($connection, $sql);
	return($result);	
}
?>