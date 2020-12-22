<?php
function logout(){
	setcookie('user_session', '', time() - 3600); //Destroy cookie
}
?>