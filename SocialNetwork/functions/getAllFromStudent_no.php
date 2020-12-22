<?php
function getAllFromStudent_no($student_no){
	global $connection;
	$sql = "SELECT firstname, lastname FROM students WHERE student_no='$student_no'"; //Do not select cookie and password for security reasons
	$result = mysqli_query($connection, $sql);
	$user_assoc = $result->fetch_assoc();
	return ($user_assoc);
}
?>