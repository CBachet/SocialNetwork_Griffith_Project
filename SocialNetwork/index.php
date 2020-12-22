<?php 
include "database.php";
include "functions/storeRegister.php";
include "functions/verifyLogin.php";
include "functions/createCookie.php";
include "functions/updateCookie.php";
include "functions/userPicture.php";
include "functions/isAuthenticated.php";
include "functions/logout.php";
include "functions/getStudentFromCookie.php";
 ?>
<?php

if(isset($_POST["submit"])){ //Look if there is a submit post
  if($_POST["submit"] == "Register"){ //Then check if submit is "Register"
    $message = storeRegister($_POST['student_no'], $_POST['firstname'], $_POST['lastname'], $_POST['gender'], $_POST['password1'], $_POST['password2'], $_FILES['user_pic']);
    if ($message == 'welcome'){
      include 'html/homePage.html';
      echo '<div class="col-sm-6" style="left: 25%">
        <div class="alert alert-info alert-dismissible">
        Welcome, you are now registered !<br>
        <a href="index.php" class="alert-link">go to the home page</a>
        </div></div>';
    }
    else{
      include 'html/login_register_index.html';
      echo '<div class="col-sm-2">
        <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        '.$message.'
        </div></div>';
    }
    
  }

  elseif($_POST["submit"] == "Login"){ // Check if the submit value is Login
    if(verifyLogin($_POST['student_no'], $_POST['password'])){
      if($_POST['student_no'] == '9999'){
        include 'adminPage.php';
      }
      else {
        include 'html/homePage.html';
        echo '<div class="col-sm-6" style="left: 25%">
        <div class="alert alert-info alert-dismissible">
        Welcome back, you are now logged !<br>
        <a href="index.php" class="alert-link">go to the home page</a>
        </div></div>';
      }
    }
    else{
      include 'html/login_register_index.html';
      echo '<div class="col-sm-2">
        <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Wrong authentication information
        </div></div>';
    }
  }
}
elseif(isset($_GET["logout"])){
  logout(); 
  header("Refresh:0; url=index.php");
}
elseif(isset($_COOKIE['user_session'])){ //if there is no submit, check if there is a cookie
  if(!isAuthenticated()){
    include 'html/login_register_index.html';
  }else{
    if(getStudentFromCookie() == '9999'){
        include 'adminPage.php';
    }
    else{
      include 'homePage.php';
    } 
  }
  updateCookie();
}else{
  include 'html/login_register_index.html';
}

?>