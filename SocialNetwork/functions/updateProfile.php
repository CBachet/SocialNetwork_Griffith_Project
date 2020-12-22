<?php
include "database.php";
include "functions/userPicture.php";
?>
<?php  
function updateProfile($student_no, $firstname, $lastname, $gender){
	global $connection;
	$sql = "UPDATE students SET firstname='$firstname', lastname='$lastname', gender='$gender' WHERE student_no='$student_no'";
  	$result = mysqli_query($connection, $sql);
  	if (!$result){
  		$message = 'There was an error';
  	}else{
  		$message = 'Profile updated';
  	}
  	return $message;
}
?>