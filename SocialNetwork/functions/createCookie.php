<?php
function createCookie($cookieHash){
  $info = array(
    'cookieHash' => $cookieHash,
  );
  $json = json_encode($info);
  setcookie('user_session', $json);
}
?>