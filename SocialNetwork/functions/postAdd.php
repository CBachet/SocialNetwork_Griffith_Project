<?php 
include "database.php";
?>

<?php  
function postAdd($title, $content, $pic){
	global $connection;
	$student_no = getStudentFromCookie();
	//define the post number
	$sql = "SELECT COUNT(id) AS numbers FROM posts WHERE id = '$student_no'";
	$result=mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$count=mysqli_fetch_row($result);
	$stud_no = strval($student_no);
	$num = rand(1,100000);
	$number = strval($num);
	$number = $stud_no.'_'.$number;
	$path = "images/postsImage/stud".$student_no."_post".$number.".jpeg";//set the path of the cover image
	$picStore = move_uploaded_file($pic['tmp_name'],$path);//store the cover image
	
	$sql1 = " INSERT INTO posts ( ID, content, date, image, react, title, number) VALUES ( '$student_no','$content', now(), '$path', 0, '$title', '$number') ";
	if(mysqli_query($connection, $sql1) or die(mysqli_error($connection))){
		$message = 'New post added';
	}else{
		$message = 'connection error';
	}
	return $message;
}

?>