<?php
include "database.php";
include "functions/getStudentFromCookie.php";
include "functions/getFriends.php";
include "functions/getAllFromStudent_no.php";
?>
<?php  
include "html/chatPage.html";
$result = getFriends();
echo '<div class="col-sm-3" style="right: 48%; top: 215px; background-color: rgb(140,200,205);" >
<div id="text">
<center><h3>Open a discussion with a friend</h3></center><hr>';
while($row = $result->fetch_assoc()){   //Creates a loop to loop through results & display all your friend with a button to display the chat with him
    $friend_no = $row["friend_no"];
    echo '<center><form action="chatPage.php" method="POST">';
    $friend_assoc = getAllFromStudent_no($friend_no);
    echo "<h4>".$friend_assoc["firstname"] . " " . $friend_assoc["lastname"] ."</h4>";
    echo ' <input type="hidden" name="friend_no" value="' . $friend_no . '"
    <center><input id="btn" type="submit" class="btn btn-primary" name="submit" value="Chat with him"></center>
    </form></center><br>';
}
echo '</div></div>';

if(isset($_POST["submit"])){
	if($_POST["submit"] == "Chat with him"|| $_POST["submit"] == "Send message" ){
    	echo'<div class="col-sm-7" style="left: 30%; top: -285px; background-color: rgb(170,216,219);" >';
    	$student_no = getStudentFromCookie();
    	$friend_no = mysqli_real_escape_string($connection, $_POST['friend_no']);
		if($_POST["submit"] == "Send message"){//put the sent message to the database
    		$message = mysqli_real_escape_string($connection, $_POST['message']);
		    $sql = "INSERT INTO privatemessages (student_no, friend_no, message, time_sent) VALUES ('$student_no', '$friend_no', '$message', now())"; //Insert the message to the database
      		mysqli_query($connection, $sql) or die(mysqli_error($connection));
		}
    	$friend_assoc = getAllFromStudent_no($friend_no);
    	//main content displays all latest messages between you and the selected friend
    	echo '<div id="text">
    	<center><h3><strong>Your messages with ' . $friend_assoc["firstname"] . ' '. $friend_assoc["lastname"] . '</strong></h3></center><hr>';
    	echo '<div class="col-sm-12" style=" top: 330px; background-color: rgb(170,216,219);" ><hr>
	    <form action="chatPage.php" method="POST">
            <input type="hidden" name="friend_no" value="' . $friend_no . '" readonly>
            <input type="textarea" name="message" rows="8" maxlength="128" style="outline:none; width:615px;" autofocus required>
            <input id="button" type="submit" class="btn btn-primary" name="submit" value="Send message">
       	</form></div></div>';
    	$sql = "SELECT * FROM privatemessages WHERE 
	    (student_no='$student_no' AND friend_no='$friend_no')
	    OR
	    (student_no='$friend_no' AND friend_no='$student_no')
	    ORDER BY time_sent ASC";
	    $result = mysqli_query($connection, $sql);
	    echo'<div class="col-sm-10" style="left: 7%; top: -75px; background-color: white;" >
	    <p><strong>&nbsp;&nbsp;&nbsp; Him/Her &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You</strong></p><hr>
	    	<div id="text">';
	    while($messages = $result->fetch_assoc()){
	    	if($messages["student_no"] == $student_no){//if is the own user message
		        echo '<br><div class="col-sm-6" style="left: 50%; background-color: white; text-align: right;" >' . $messages["message"].'</div>';
		    }
	      	else{//if is not the user message
	        	echo '<br><div class="col-sm-6" style="background-color: white;" ><div id="txt">' . $messages["message"].'</div></div>';
	      	}
	    }
	    echo '</div></div></div>';
		
	}
	elseif($_POST["submit"] == "Go to chat"){
	echo '<div class="col-sm-7" style="left: 30%; top: -285px; background-color: rgb(170,216,219);" >
    	<div id="text">
		Choose one friend to see the private messages
		</div></div>';
	}
}
	
?>