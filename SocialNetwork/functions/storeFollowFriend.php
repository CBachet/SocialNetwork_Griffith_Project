<?php

function storeFollowFriend($friend_no){
	global $connection;
	$friend_no = mysqli_real_escape_string($connection, $friend_no);
  $student_no = getStudentFromCookie();
  //echo $friend_no;
  //echo "<br>" . $student_no . '<br>';
  $result2 = mysqli_query($connection, "SELECT * FROM friends WHERE student_no='$student_no' AND friend_no='$friend_no'");
  //echo mysqli_num_rows($result2) . "<br>";
  if(mysqli_num_rows($result2) > 0){ //Check if the student is already friend with him/her
    $message = "You are already friends";
  }
  else {
    $sql = "INSERT INTO friends (student_no, friend_no) VALUES ('$student_no', '$friend_no')"; //Insert the student to the database
    mysqli_query($connection, $sql);
    $message = "You are now following ".$friend_no;
  }
  return $message;
}

?>