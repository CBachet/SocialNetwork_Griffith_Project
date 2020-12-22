<?php  
function isFollowed($friend_no){
	global $connection;
	$friend_no = mysqli_real_escape_string($connection, $friend_no);
  	$student_no = getStudentFromCookie();
  	$result2 = mysqli_query($connection, "SELECT * FROM friends WHERE student_no='$student_no' AND friend_no='$friend_no'");
  	if(mysqli_num_rows($result2) > 0){ //Check if the student is already friend with him/her
    	$message = "Friends";
  	}
  	else{
  		$message = "Not friends";
  	}
  	return $message;
  }
?>