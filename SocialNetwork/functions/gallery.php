<?php
include "database.php";

?>
<?php


function galleryDelete($path){//delete an image from the gallery
	global $connection;
	$student_no= getStudentFromCookie();
	$myFile = $path;
	
	$sql = "DELETE FROM images where ID='$student_no' and path = '$myFile' ";
	if(mysqli_query($connection,$sql) or die(mysqli_error($connection))){
		
		unlink($myFile) or die("Couldn't delete file");
		$message = "Image deleted";
	
	}
	return $message;

}

function galleryAdd($user_pic, $name_pic){
		if(isset($user_pic)){
			$student_no= getStudentFromCookie();
			galleryPicture($student_no, $user_pic, $name_pic);
			$message = " picture saved";
		}else{
			$message = "no picture";
		}
		return $message;
}
?>