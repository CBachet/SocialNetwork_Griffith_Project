
<?php
function getStudentFromCookie(){
	global $connection;
	$cookieInBrowser = stripcslashes($_COOKIE['user_session']);
	$info = json_decode($cookieInBrowser, true);
	$cookieHash = $info['cookieHash'];
	$sql = "SELECT student_no  FROM students WHERE cookie='$cookieHash'";
	$result = mysqli_query($connection, $sql);
	$user_assoc = $result->fetch_assoc();
	return ($user_assoc["student_no"]);
}
?>