<?php
function userPicture($student_no, $user_pic){
global $connection;

$nom = "images/users/".$student_no.".jpeg";
$resultat = move_uploaded_file($user_pic['tmp_name'],$nom);

}

function galleryPicture($student_no, $user_pic, $name_pic){
global $connection;

$path = "images/gallery/".$student_no."_".$name_pic.".jpeg";

	$exist = 'no';
	$sql1 = " SELECT * FROM images";
	$result = mysqli_query($connection,$sql1) or die (mysqli_error($connection));
	while ($row = mysqli_fetch_row($result)){
		if( $row[1] == $path ){
			//echo "image already exist, image uploaded";
			$exist = "yes";
		}
	}
	
	if($exist == "yes"){
		$resultat = move_uploaded_file($user_pic['tmp_name'],$path);
		
	}elseif($exist == "no"){
		$sql = "INSERT INTO images (ID, path ) VALUES ('$student_no', '$path')"; //Insert the image to the database
		if(mysqli_query($connection, $sql) or die(mysqli_error($connection))){ //Check if the insertion was good
			   $result = move_uploaded_file($user_pic['tmp_name'],$path);
		}else{
			 echo '<h1>SQL connection error</h1>';
		}

		
	}

}

?>