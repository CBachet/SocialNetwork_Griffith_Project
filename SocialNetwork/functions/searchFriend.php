<?php 
function searchFriend($friend_no){
	global $connection;
	$result = mysqli_query($connection, "SELECT * FROM students WHERE student_no='$friend_no'");
	if(mysqli_num_rows($result) == 1){ //Check if the friend exists in database
		$exist = 'found';
	}
	
	else{
		$exist = 'Not found';
	}
	return $exist;
}
?>