<?php

function storeUnfollowFriend($friend_no){
	global $connection;
	$friend_no = mysqli_real_escape_string($connection, $friend_no);
  $student_no = getStudentFromCookie();
  $result = mysqli_query($connection, "DELETE FROM friends WHERE student_no='$student_no' AND friend_no='$friend_no'");
}

?>