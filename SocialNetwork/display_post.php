<?php
include "database.php";
include "functions/getStudentFromCookie.php";
include "functions/updateProfile.php";
include "functions/searchFriend.php";
?>
<?php
		if ($connection->connect_error) {
			die("Connection failed: " . $connection->connect_error);
		}

		$sql = "SELECT content, title, date, image, react FROM post";
		$result = $connection->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo "title: " . $row["title"] . "<br>" . " content: " . $row["content"] .  $row["image"] . "<br>" .  "Posted on : " . $row["date"]. "<br>" . "reaction " . $row["react"] . "<br><br>";
			}
		} 
		else {
			echo "0 results";
		}
?>
<form action="profilePage.php" method="POST">
	<input type="submit" value="return">
</form>