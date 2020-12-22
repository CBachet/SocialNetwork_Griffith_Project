<?php
include "database.php";
include "functions/searchFriend.php";
include "functions/deleteUser.php";

?>

<?php
include 'html/admin_page.html';


if(isset($_POST["submit"])){
	if($_POST["submit"] == "Search" || $_POST["submit"] == "View profile"){//search a friend
			$friend_no = $_POST['friend_no'];
			$fetch = searchFriend($friend_no);
			if(file_exists('./images/users/'.$friend_no.'.jpeg')){
				$path1 ='./images/users/'.$friend_no.'.jpeg'.'?t='.'';
			}else{
				$path1 ='images/users/userpic.png'.'?t='.'';
			}
			if($fetch == 'found'){
				if($friend_no != "9999"){
					if(file_exists('./images/users/'.$friend_no.'.jpeg')){
						$path1 ='./images/users/'.$friend_no.'.jpeg'.'?t='.'';
					}
					else{
						$path1 ='images/users/userpic.png'.'?t='.'';
					}
					$result = mysqli_query($connection, "SELECT * FROM students WHERE student_no='$friend_no'")or die (mysqli_error($connection));
					$fetch = mysqli_fetch_row($result);
					echo '<div class="col-sm-9" style="left: 5%; top: 75px; background-color: rgb(170,216,219);" >
					<div id="text">
					<center><br><img src="'.$path1.''.time().'" width="250" height="200" class="img-rounded" alt="Picture : "></center><hr>
					<h4>Student number: '.$fetch[0].'</h4><br>
					<h4>Firstname: '.$fetch[1].'</h4><br>
					<h4>Lastname: '.$fetch[2].'</h4><br>
					<h4>Gender: '.$fetch[3].'</h4><br>
					<form action="adminPage.php" method="POST">
					<input type="hidden" name="friend_no" value="'.$friend_no.'">
					<center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Delete Student"></center><br>
					</form>
					<form action="adminPage.php" method="POST">
					<input type="hidden" name="friend_no" value="'.$fetch[0].'">
					<input type="hidden" name="firstname" value="'.$fetch[1].'">
					<input type="hidden" name="lastname" value="'.$fetch[2].'">
					<input type="hidden" name="gender" value="'.$fetch[3].'">
					<center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Edit Student"></center>
					</form>
					</div>
					</div>';	
				}
				else{
					include "functions/getStudentFromCookie.php";
					echo'<div class="col-sm-9" style="left: 5%; top: 75px; background-color: rgb(170,216,219);" >
					<div id="text">
					<center><h2>Admin account</h2></center><hr>
					<h4>Student number: 9999</h4><br>
					<h4>Firstname: Admin</h4><br>
					<h4>Lastname: Admin</h4><br>';
					if(getStudentFromCookie() == "9999"){
						echo'<h4>Password: admin</h4><br>';
					}
					echo'
					<center>Admin information are non-editable</center>
					</div></div>';
				}
					
			}
			else{//not found
				echo '<div class="col-sm-9" style="left: 5%; top: 50px; background-color: rgb(170,216,219);" >
				<div id="text">
				<center><h3>'.$fetch.'</h3></center><br>
				</div>
				</div>';
			}
			
	}
	elseif($_POST["submit"] == "Delete Student"){
		$friend_no = $_POST['friend_no'];
		$message = deleteUser($friend_no);
		$sql = "DELETE FROM friends WHERE friend_no='$friend_no'";
		echo '<div class="col-sm-9" style="left: 5%; top: 75px; background-color: rgb(170,216,219);" >
			<div id="text">
			<center><h3>'.$message.'</h3></center><br>
			</div>
			</div>';
	}
	elseif($_POST["submit"] == "Edit Student"){
		$fname = $_POST["firstname"];
		$lname = $_POST["lastname"];
		$gen = $_POST["gender"];
		$friend_no = $_POST["friend_no"];
		echo '<form action="adminPage.php" method="POST" enctype="multipart/form-data">
		<div class="col-sm-9" style="left: 5%; top: 75px; background-color: rgb(170,216,219);" >
			<div id="text">
				<center><h2>Edit the profile</h2></center>
			</div><br><hr>
			<div class="form-group">
  				<label for="usr"><div id="text"><h4>Firstname: </h4></div></label>
  				<input type="text" class="form-control" name="fname" value = '.$fname.'>
			</div>
			<div class="form-group">
  				<label for="usr"><div id="text"><h4>Lastname: </h4></div></label>
  				<input type="text" class="form-control" name="lname" value = '.$lname.'>
			</div>
			<div class="form-group">
  				<label for="usr"><div id="text"><h4>Gender: </h4></div></label>
  				<input type="text" class="form-control" name="gen" value = '.$gen.'>
			</div><hr>
			<form action="adminPage.php" method="POST">
			<input type="hidden" name="friend_no" value="'.$friend_no.'">
			<center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Change the profile image"></center>
			<br><hr><br>
			</form>
			<center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Update profile"></center>
		</div></form>';
	}
}
elseif(isset($_GET["students"])){
	$result1 = mysqli_query($connection, "SELECT student_no, firstname, lastname FROM students ")or die (mysqli_error($connection));
	echo '<div class="col-sm-9" style="left: 5%; top: 75px; background-color: rgb(170,216,219);" >
		<div id="text">
		';
	while($row = $result1->fetch_assoc()){
		$student_no = $row['student_no'];
		$fname = $row['firstname'];
		$lname = $row['lastname'];
		if(file_exists('./images/users/'.$student_no.'.jpeg')){
			$path ='./images/users/'.$student_no.'.jpeg'.'?t='.'';
		}else{
			$path ='images/users/userpic.png'.'?t='.'';
		}
		
		echo  '
			<h4><img src="'.$path.''.time().'" width="60" height="50" class="img-rounded" alt="Picture : ">  Student number: '.$student_no.'  |  Firstname: '.$fname.'  |  Lastname: '.$lname.'  
			<form action="adminPage.php" method="POST">
	        <input type="hidden" name="friend_no" value="'.$student_no.'"/>
	      	<center><input id="view" type="submit" class="btn btn-primary" name="submit" value="View profile" class="button"></center>
	  		</form>
	  		</h4><hr>';
	}
	echo '</div>
	</div>';
}

?>
