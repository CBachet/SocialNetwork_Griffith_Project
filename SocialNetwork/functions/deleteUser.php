<?php
include "database.php";
?>
<?php
function deleteUser($student_no){
	global $connection;

    $sql = "DELETE FROM students WHERE student_no='$student_no'";
    if (mysqli_query($connection, $sql))
     	$message = '<h3>Student number ' . $student_no. ' deleted</h3>';
     	if(file_exists('./images/users/'.$student_no.'.jpeg')){
     		unlink('./images/users/'.$student_no.'.jpeg')or die("Couldn't delete the image");
     	}
    else{
      $message = "Error";
    }
    return $message;
}
	

?>