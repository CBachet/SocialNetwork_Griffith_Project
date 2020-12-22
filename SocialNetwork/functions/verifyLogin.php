<?php
function verifyLogin($student_no, $password){
  global $connection;

  $student_no = mysqli_real_escape_string($connection, $student_no);
  $password = mysqli_real_escape_string($connection, $password);
  $sql = "SELECT password, firstname, cookie FROM students WHERE student_no='$student_no'";
  $result = mysqli_query($connection, $sql);
  $user_assoc = $result->fetch_assoc();
  if(password_verify($password, $user_assoc["password"])){
    // echo '<h1>Welcome ' . $user_assoc["firstname"] . '</h1>';
    if(!isset($_COOKIE['user_session'])){
      createCookie($user_assoc["cookie"]);
      return true;
    }
  }
  else
    return false;
    // echo '<h1>Incorrect Student number or Password</h1>';
}
?>