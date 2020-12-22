<?php
include "database.php";
include "functions/getStudentFromCookie.php";
include "functions/updateProfile.php";
include "functions/searchFriend.php";
include "functions/storeFollowFriend.php";
include "functions/storeUnfollowFriend.php";
include "functions/isFollowed.php";
include "functions/getFriends.php";
include "functions/gallery.php";
include "functions/postAdd.php";
include "functions/getStudentPosts.php";
include "functions/postDelete.php";
?>

<?php
	include 'html/profilePage.html';//layout display

	// put all useful values in variables
	$student_no= getStudentFromCookie(); // search the student number with the function "getstudentFromCookie"
	$sql = " Select * FROM students where student_no ='$student_no' ";
	$result = mysqli_query($connection,$sql) or die (mysqli_error($connection));
	$row = mysqli_fetch_row($result);
	$fname = $row[1];
	$lname = $row[2];
	$gen = $row[3];


	// check if the student have an user picture and define the path of this picture consequently
	if(file_exists('images/users/'.$student_no.'.jpeg')){
		$path ='images/users/'.$student_no.'.jpeg'.'?t='.'';
	}else{
		$path ='images/users/userpic.png'.'?t='.'';
	}


	///left page display:
	//Display the user picture, 
	//the name , 
	//buttons to display user informations, list of friends and picture gallery
	// and a label to search friends
	echo '<div class="col-sm-2" style="left: 2%; top: 75px; background-color: rgb(140,200,205);" >
	  
	  <center><br><img src="'.$path.''.time().'" width="220" height="180" class="img-circle" alt="Picture :'.$fname.' '.$lname.'"></center><br>   
	  <div id="text">
	  
	  <center><h3>'.$fname.' '.$lname.'</center></h3>
	  
	  <hr>
	  	<ul>
	  		<li><a href="profilePage.php?about" style="color: inherit;">About</li></a>
	  		<li><a href="profilePage.php?friends" style="color: inherit;">Friends</li></a>
	  		<li><a href="profilePage.php?gallery" style="color: inherit;">Gallery</li></a>
	  	</ul>
	  </div>
	  <hr>

	  <form action="profilePage.php" method="POST">
	    <div id="header">
	      <center><div id="text"><h4>Follow/Search a friend</h4></div></center>
	      <br>
	      <div class="form-group" style="width: 100%;">
	        <input type="text" class="form-control" name="friend_no" placeholder="Student number of your friend*" required/><br/>
	      </div>
	      <center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Search" class="button"></center>
	    </div>
	  </form><br>

	</div>';


	///right page display: 
	//display the icone of the site (the unicorn image),
	//buttons to display posts or create a new post,
	//a button to go chat with a friend
	echo '<div class="col-sm-2" style="left: 65%; top: 75px; background-color: rgb(140,200,205);" >
		<center><br><img src="websiteImage/unicorn.png"class="img-rounded" width="200"></center><br>
		<hr>
		
		<div id="text">
			<ul>
	  		<li><a href="profilePage.php?newPost" style="color: inherit;">Add a new post</li></a>
	  		<li><a href="profilePage.php?posts" style="color: inherit;">My posts</li></a>
	  	</ul>

	  	<hr><br>
	  	<form action="chatPage.php" method="POST">
		    <div id="header">
		      <center><div id="text"><h4>Chat with your friends</h4></div></center>
		      <br>
		      <center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Go to chat" class="button"></center>
			</div>
		</form><br>

		</div>
	</div>';


	//main content ( in the center of the page)

	//Display all the student posts
	if(isset($_GET["posts"])){
		$student_no= getStudentFromCookie();
		$result = getStudentPosts($student_no);
		echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
			<div id="text">
			<center><h4>All your Posts </h4></center><hr>';
		while($row = mysqli_fetch_row($result)){
			$title = $row[5];
			$content = $row[1];
			$path = $row[3];
			$number = $row[6];
			$likes = $row[4];
			echo'
			<div class="col-sm-12" style="background-color: white; height: 175px;">
				<div class = "col-sm-4">
					<br>
					<img src="'.$path.'" width="250px" height="150px"  alt="Picture :" />
				</div>
				<div class="col-sm-8">
					<center><strong><h5>'.$title.'</h5></strong></center><hr>
					<div class="col-sm-12" style =" height:65px; overflow: hidden; background-color: rgb(209,239,245)"><h6>'.$content.'</h6></div>
					<div class="col-sm-12" style =" height:40px; overflow: hidden">
						<form action="profilePage.php" method="POST">
						<input type="hidden" name="post_no" value="'.$number.'">
						<div class="col-sm-5" style="top:2px"><center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Read more" class="button"></center>
						</div></form>
						<form action="profilePage.php" method="POST">
						<input type="hidden" name="image" value="'.$path.'">
						<div class="col-sm-5" style="top:2px"><center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Delete" class="button"></center>
						</div></form>
						<center><div class="col-sm-2">Likes: '.$likes.'</div></center>
					</div>
				</div>
			</div>';
			echo'<div class="col-sm-12" style="height:10px"></div>';
			
		}
		echo '</div>
			</div>';
		
	}
	
	//Write a new post, using summernote wysiwyg editor
	if(isset($_GET["newPost"])){
		echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
			<div id="text">
				<center><h2>Add a new post</h2></center><hr>
				<form action="profilePage.php" method="POST" enctype="multipart/form-data">
				<center><div class="form-group" style="width: 75%;">
		        	<input type="text" class="form-control" name="title" placeholder="Title of your post" required><br>
		        	<textarea class="form-control" name="content" rows="15" required></textarea><br>
		        	<label>Choose a cover image for your post</label><input type="file" name="post_pic" required>
		      	</div></center><hr>
				<center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Upload"></center>
				</form>
			</div>
			</div>
			';
	}

	if(isset($_GET["about"])){//about
		//display user informations and a button to go edit profil
		echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
			<div id="text">
			<h4>Firstname: </h4></div> <h5>'.$fname.'</h5><br>
			<div id="text">
			<h4>Lastname: </h4></div><h5>'.$lname.'</h5><br>
			<div id="text">
			<h4>Gender: </h4> </div><h5>'.$gen.'</h5><br>
			<hr><br>
			<center><a href="profilePage.php?editProfile"><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Edit profile"></a></center>
		</div>';
	}
	elseif(isset($_GET["editProfile"])){//edit the profile
		// display all user informations in labels which can be edit 
		echo '<form action="profilePage.php" method="POST" enctype="multipart/form-data">
		<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
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
			</div>
			<div id="text"><h4>Change your profile image<a href="profilePage.php?changeProfileImage"> here</h4></div></a>
			<br><hr><br>
			<center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Update profile"></center>
		</div></form>';
	}
	elseif(isset($_GET["changeProfileImage"])){//update the profile image
		echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
		<div id="text">
			<center><h2>Change your profile image</h2></center>
			<hr>
			<center><br><img src="'.$path.''.time().'" width="250" height="200" class="img-rounded" alt="Picture : "></center><br>
			<center><h4>Current profile image</h4></center>
			<hr>
		</div>
		<form action="profilePage.php" method="POST" enctype="multipart/form-data">
		<center><input type="file" name="user_picture" required/><hr>
		<input id="btn" type="submit" class="btn btn-primary" name="submit" value="Update profile image"></center>
		</form>
		</div>';

	}
	elseif(isset($_GET["gallery"])){//display your gallery
		$sql = " Select * FROM images";
		$result = mysqli_query($connection,$sql) or die (mysqli_error($connection));
		// display a button to add a new image
		echo " <div class='col-sm-7' style='left: -12%; top: 75px; background-color: rgb(170,216,219);' >
			<div id='text'>
			<center><h2>Your Gallery</h2></center>
			<form action='profilePage.php' method='POST'>
			<center><input id='btn' type='submit' class='btn btn-primary' name='submit' value='Add new image'></center>
			</form>
			<hr>";


		$rows = array();
		$j = 1;
		//count number of images
    	while($row = mysqli_fetch_row($result)) {
        $rows[$j] = $row[1];
        $rows[0]= $row[0];
        $j= $j + 1;
    	}
    	$len = count($rows) - 1;
    	$i = 1;
    	
    	if(isset($rows[0])){
			$ID = $rows[0];
		}
		while($i<=$len){// display picture 3 by 3
			$path =  $rows[$i];
			$next = $i+1;
			$next2 = $next + 1;
			if(isset($rows[$next])){
				$path2 = $rows[$next];
			}else{
				$path2 = null;
			}
			if(isset($rows[$next2])){
				$path3 = $rows[$next2];
			}else{
				$path3 = null;
			}

			// if you are the student who post the image you can delete this image ( display a delete button)
			if($ID == $student_no){	
					echo "	
						<div class='row'>
							<div class='col-sm-4'>
								$path  <br>
								<img src='$path' max-width='80%' height='140px'  alt='Picture :".$path."' />
								<form action='profilePage.php' method='POST'> 
								<input type='hidden' value='$path' name='path'>
								<input id='btn' type='submit' class='btn btn-primary' name='submit' value='Delete image'>
								</form>
							</div>";
				if($path2 != null){
					echo "<div class='col-sm-4'>
								<center>$path2  <br>
								<img src='$path2' max-width='80%' height='140px'  alt='Picture :".$path2."' />
								<form action='profilePage.php' method='POST'> 
								<input type='hidden' value='$path2' name='path'>
								<input id='btn' type='submit' class='btn btn-primary' name='submit' value='Delete image'>
								</form></center>
							</div>";
				}
				if($path3 != null){
					echo"<div class='col-sm-4'>
								$path3  <br>
								<img src='$path3' max-width='80%' height='140px'alt='Picture :".$path3."' />
								<form action='profilePage.php' method='POST'> 
								<input type='hidden' value='$path3' name='path'>
								<input id='btn' type='submit' class='btn btn-primary' name='submit' value='Delete image'>
								</form>
							</div>";
				}
				echo "<div>
						</div>
						</div>"; 
				
			}
			$i = $i +3;
		}
	}
	elseif(isset($_GET["friends"])){//display list of friends
		$result = getFriends();
		echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
		<div id="text">
		<h3><center>Followed Friends</center></h3><hr>';
		while($row = $result->fetch_assoc()){// for each friends you follow
			$friend_no = $row['friend_no'];
			if(file_exists('./images/users/'.$friend_no.'.jpeg')){// check if the student have an user picture 
				$path2 ='./images/users/'.$friend_no.'.jpeg'.'?t='.'';//and define the path of this picture consequently
			}else{
				$path2 ='images/users/userpic.png'.'?t='.'';
			}
			$result2 = mysqli_query($connection, "SELECT * FROM students WHERE student_no='$friend_no'")or die (mysqli_error($connection));
			$fetch = mysqli_fetch_row($result2);
			//display  picture, student number , firstname and lastname of your friend and a button to view his profile
			echo  '
			<h4><img src="'.$path2.''.time().'" width="60" height="50" class="img-rounded" alt="Picture : ">  Student number: '.$friend_no.'  |  Firstname: '.$fetch[1].'  |  Lastname: '.$fetch[2].'  
			<form action="profilePage.php" method="POST">
	        <input type="hidden" name="friend_no" value="'.$friend_no.'"/>
	      	<center><input id="view" type="submit" class="btn btn-primary" name="submit" value="View profile" class="button"></center>
	  		</form>
	  		</h4><hr>';
		}
		echo '</div>
		</div>';
	}
	elseif(isset($_POST["submit"])){
		if($_POST["submit"] == "Update profile"){//update profile
			// put all useful values in variables
			$firstname = $_POST['fname'];
			$lastname = $_POST['lname'];
			$gender = $_POST['gen'];
			$message = updateProfile($student_no, $firstname, $lastname, $gender);// update the profil in the database 
			//display a message when the profil was updated
			echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
			<div id="text">
			<center><h3>'.$message.'</h3></center><br>
			</div>
			<hr>
			<center><a href="profilePage.php"><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Back to the Profile page"></a></center>
			</div>';
		}
		elseif($_POST["submit"] == "Update profile image"){//update profile image
			userPicture($student_no, $_FILES['user_picture']);
		}
		elseif($_POST["submit"] == "Search" || $_POST["submit"] == "View profile" ){//search a friend
			$friend_no = $_POST['friend_no'];
			$fetch = searchFriend($friend_no);
			if(file_exists('./images/users/'.$friend_no.'.jpeg')){	// check if the student have an user picture 
				$path1 ='./images/users/'.$friend_no.'.jpeg'.'?t='.'';//and define the path of this picture consequently
			}else{
				$path1 ='images/users/userpic.png'.'?t='.'';
			}
			if($fetch == 'found'){
				if($friend_no != "9999"){// if the friend isn't the administrator
					if(file_exists('./images/users/'.$friend_no.'.jpeg')){// check if the student have an user picture 
						$path1 ='./images/users/'.$friend_no.'.jpeg'.'?t='.'';//and define the path of this picture consequently
					}else{
						$path1 ='images/users/userpic.png'.'?t='.'';
					}
					$result = mysqli_query($connection, "SELECT * FROM students WHERE student_no='$friend_no'")or die (mysqli_error($connection));
					$fetch = mysqli_fetch_row($result);
					//display information about the friend you search (picture, student number, name, gender)
					echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
					<div id="text">
					<center><br><img src="'.$path1.''.time().'" width="250" height="200" class="img-rounded" alt="Picture : "></center><hr>
					<h3>Student number: '.$fetch[0].'</h3><br>
					<h3>Firstname: '.$fetch[1].'</h3><br>
					<h3>Lastname: '.$fetch[2].'</h3><br>
					<h3>Gender: '.$fetch[3].'</h3><br>';
					$message = isFollowed($friend_no);// check if you follow this student or not
					if ($message == "Not friends"){// if you don't follow this student
					//create a button to follow him
						echo'<form action="profilePage.php" method="POST">
					<input type="hidden" name="friend_no" value="'.$friend_no.'">';

					echo'<center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Follow"></center>
					</form>
					</div>
					</div>';
					}
					elseif($message == "Friends"){// if you follow this student
					//create a button to unfollow him
						echo'<form action="profilePage.php" method="POST">
					<input type="hidden" name="friend_no" value="'.$friend_no.'">
					<center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Unfollow"></center>
					</form>
					</div>
					</div>';
					}
				}
				else{// if your are searching the administrator
					//display "informations" about admin ( show that's the administrator account)
					echo'<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
					<div id="text">
					<center><h2>Admin account</h2></center><hr>
					<h4>Student number: 9999</h4><br>
					<h4>Firstname: Admin</h4><br>
					<h4>Lastname: Admin</h4><br>';
					if(getStudentFromCookie() == "9999"){
						echo'<h4>Password: admin</h4><br>
						<center>Admin information are non-editable</center>';
					}
					//no one can follow the admin
					echo'
					<center>Admin cannot be followed</center>
					</div></div>';
				}
				
			}
			else{//if not found
				// show a "not found" message
				echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
				<div id="text">
				<center><h3>'.$fetch.'</h3></center><br><hr>
				<center><a href="profilePage.php"><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Back to the Profile page"></a></center>
				</div>
				</div>';
			}
			
		}
		elseif($_POST["submit"] == "Follow"){// if you want to add a friend
			$friend_no = $_POST['friend_no'];
			$message = storeFollowFriend($friend_no);// store him in your friend list
			//and display a message
			echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
				<div id="text">
				<center><h3>'.$message.'</h3></center><br><hr>
				<center><a href="profilePage.php"><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Back to the Profile page"></a></center>
				</div>
				</div>';
		}
		elseif($_POST["submit"] == "Unfollow"){// if you want to delete a friend
			$friend_no = $_POST['friend_no'];
			storeUnfollowFriend($friend_no);// delete him from your friend list
			//and display a message
			echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
				<div id="text">
				<center><h3>Friend unfollowed</h3></center><br><hr>
				<center><a href="profilePage.php"><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Back to the Profile page"></a></center>
				</div>
				</div>';
		}
		elseif($_POST["submit"] == "Delete image"){// if you want to delete an image
			$message = galleryDelete($_POST['path'] );// delete the image from the database and image file
			echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
				<div id="text">
				<center><h3>'.$message.'</h3></center><br><hr>
				<center><a href="profilePage.php?gallery"><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Back to the Gallery"></a></center>
				</div>
				</div>';
		}
		elseif($_POST["submit"] == "Add new image"){// if you want to add an image (form)
			echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
			<div id="text">
				<center><h2>Add a new image</h2></center><hr>
				<form action="profilePage.php" method="POST" enctype="multipart/form-data">
				<center><input type="file" name="user_pic" required  /><br><hr>
				<center><div class="form-group" style="width: 75%;">
		        	<input type="text" class="form-control" name="name_pic" placeholder="Name of the picture" required/><br/>
		      	</div></center>
				<center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Add to your gallery"></center>
				</form>
			</div>
			</div>
			';
		}
		elseif($_POST["submit"] == "Add to your gallery"){// if you want to add an image (result)
			$pic = $_FILES['user_pic'];
			$name = $_POST['name_pic'];
			$message = galleryAdd($pic, $name );// add the image in the database and in the image file
			echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
				<div id="text">
				<center><h3>'.$message.'</h3></center><br><hr>
				<center><a href="profilePage.php?gallery"><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Back to the Gallery"></a></center>
				</div>
				</div>';
		}
		elseif($_POST["submit"] == "Upload"){//upload a post
			$title = $_POST["title"];
			$content = $_POST["content"];
			$pic = $_FILES['post_pic'];
			$message = postAdd($title, $content, $pic);
			echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
				<div id="text">
				<center><h3>'.$message.'</h3></center><br><hr>
				<center><a href="profilePage.php?posts"><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Back to Profile page"></a></center>
				</div>
				</div>';
		}
		elseif($_POST["submit"] == "Delete"){//delete a post
			$image = $_POST['image'];
			$message = postDelete($image);
			echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
				<div id="text">
				<center><h3>'.$message.'</h3></center><br><hr>
				<center><a href="profilePage.php?posts"><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Back to Profile page"></a></center>
				</div>
				</div>';
		}
		elseif($_POST["submit"] == "Read more"){//display a post
			$number = $_POST['post_no'];
			$result = getpost($number);
			$post = mysqli_fetch_row($result);
			echo '<div class="col-sm-7" style="left: -12%; top: 75px; background-color: rgb(170,216,219);" >
				<div id="text">
				<center><h2>'.$post[5].'</h2></center><hr>
				<center><img src="'.$post[3].'" width="250" height="200" alt="Picture : "></center><br>
				</div>
				<center><textarea style="width: 75%;" name="content" rows="10" readonly>'.$post[1].'</textarea></center><hr>
				<div id="text">
				Posted by student n°'.$post[0].' on '.$post[2].'<br>
				Likes : '.$post[4].'
				</div></div>';
		}
	}

?>