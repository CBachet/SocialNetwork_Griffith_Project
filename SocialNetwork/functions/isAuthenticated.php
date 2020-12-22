<?php
function isAuthenticated(){
//check if there is a cookie, then if there is one check if this cookie is linked to a existing user
	global $connection;
	if(isset($_COOKIE['user_session'])){
		$cookieInBrowser = stripcslashes($_COOKIE['user_session']);
		$info = json_decode($cookieInBrowser, true);
		$cookieHash = $info['cookieHash'];
		$result = mysqli_query($connection, "SELECT * FROM students WHERE cookie='$cookieHash'");
		if(mysqli_num_rows($result) == 1){
			return true;
		}
		return false;
	}

	return false;
}  
?>