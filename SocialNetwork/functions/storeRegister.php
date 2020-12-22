<?php
function storeRegister($student_no, $firstname, $lastname, $gender, $password1, $password2, $user_pic){
  global $connection;
  $student_no = mysqli_real_escape_string($connection, $_POST['student_no']);
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $password1 = mysqli_real_escape_string($connection, $_POST['password1']);
    $password2 = mysqli_real_escape_string($connection, $_POST['password2']);
  //$image = mysqli_real_escape_string($connection, $_POST['user_pic']);

    if ($password1 == $password2){ //Check if password and confirm password are equals
      $result = mysqli_query($connection, "SELECT * FROM students WHERE student_no='$student_no'");
      if(mysqli_num_rows($result) > 0){ //Check if the student number already exists in database
        $message = 'Student already exists';
      }
      else{ //Else continue
        $passwordHash = password_hash($password1, PASSWORD_ARGON2I); //Hash password given
        /* Create a random number for cookie storage */
        $cookieHash = password_hash(sha1(microtime(true).mt_rand(10000,90000)), PASSWORD_ARGON2I); //Hash cookie number

        if ($passwordHash && $cookieHash){ //If both hashing worked, continue
          $sql = "INSERT INTO students (student_no, firstname, lastname, gender, password, cookie) VALUES ('$student_no', '$firstname', '$lastname', '$gender', '$passwordHash', '$cookieHash')"; //Insert the student to the database
          if(mysqli_query($connection, $sql) or die(mysqli_error($connection))){ //Check if the insertion was good
            createCookie($cookieHash);
            $message = 'welcome';
          }else{
          $message = 'SQL connection error';}
      
        userPicture($student_no, $user_pic);
    
        }
        else
          $message = 'Could not hash password';
      }
    }
    else{
      $message = 'PASSWORDS DID NOT MATCH';
    }
    return $message;
}

?>