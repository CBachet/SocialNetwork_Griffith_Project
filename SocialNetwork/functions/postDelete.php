<?php


function postDelete($path){//delete an image from the gallery
	global $connection;
	$student_no = getStudentFromCookie();
	
	$sql="DELETE FROM posts WHERE image='$path' AND id='$student_no'";
	if(mysqli_query($connection,$sql) or die(mysqli_error($connection))){
		unlink($path);
		$message = "Post deleted";
	}else{
		$message = "Deleting error";
	}
	return $message;

}
?>