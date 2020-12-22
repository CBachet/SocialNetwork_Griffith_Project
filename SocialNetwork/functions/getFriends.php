<?php

function getFriends(){
	global $connection;
  $student_no = getStudentFromCookie();
  $result = mysqli_query($connection, "SELECT * FROM friends WHERE student_no='$student_no'");
  return $result; // return all friends linked to the student number
}

?>