<?php
function updateCookie(){
  global $connection;

  $cookie = stripcslashes($_COOKIE['user_session']);
  $info = json_decode($cookie, true);
  $cookieHash = $info['cookieHash'];
  //Change cookie number
  $newCookieHash = password_hash(sha1(microtime(true).mt_rand(10000,90000)), PASSWORD_ARGON2I);
  $sql = "UPDATE students SET cookie='$newCookieHash' WHERE cookie='$cookieHash'";
  $result = mysqli_query($connection, $sql);
  setcookie('user_session', '', time() - 3600); //Destroy cookie
  createCookie($newCookieHash);
}
?>