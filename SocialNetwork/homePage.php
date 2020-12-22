<?php  
include "functions/getFriends.php";
?>
<?php  
include 'html/homePage.html';

$result = getFriends();
$student_no= getStudentFromCookie();
$sql = "SELECT * FROM posts ORDER by date DESC";
$result1 = mysqli_query($connection, $sql);
$i=0;
while($row=mysqli_fetch_row($result)){
	if($row[0] == $student_no ){
		$friends[$i] = $row[1];
	}
	
	$i= $i + 1;
}
$len = count($friends);

echo'<div class="col-sm-11" style="left: 4%; top: -30px; background-color: rgb(140,200,205);" >
	<div id="text">
	<center><h3>Recent Friend Posts</h3></center><hr>';

while($row1 = $result1->fetch_assoc()){	
	$j = 0;
	$exist = false;
		while ( $j < $len){
			if ($friends[$j] == $row1["id"]){
					$exist = true;
			}
			if($exist == true ){
				echo "<div class='col-sm-12' style='background-color: white; height:200px'>
				<div class = 'col-sm-4'>
					<center><img src='".$row1["image"]."' width='300px' height='200px'  alt='Picture :'' /></center>
				</div>
				<div class='col-sm-8'>
				<center><strong><h5>". $row1["title"] ."</h5></strong></center><hr>
					<div class='col-sm-12' style ='height:60px; overflow: hidden; background-color: rgb(209,239,245)'><h6>".$row1["content"]."</h6></div>
					<div class='col-sm-12' style ='height:40px; overflow: hidden'>
						<form action='#' method='POST'>
							<input type='hidden' name='post_no' value='".$row1["number"]."'>
							<div class='col-sm-4' style='top:2px'><center><input id='btn' type='submit' class='btn btn-primary' name='submit' value='Read more' class='button'></center>
							</div>
						</form>
						<form action='#' method='POST'>
							<input type='hidden' name='post_no' value='".$row1["number"]."'>
							<div class='col-sm-4' style='top:2px'><center><input id='btn' type='submit' class='btn btn-primary' name='submit' value='Comment' class='button'></center>
							</div>
						</form>
						<form action='#' method='POST'>
							<input type='hidden' name='post_no' value='".$row1["number"]."'>
							<div class='col-sm-4' style='top:2px'><center><input id='btn' type='submit' class='btn btn-primary' name='submit' value='Like' class='button'></center>
							</div>
						</form>
					</div>
					<div class='col-sm-12' style ='height:25px; top:2px; overflow: hidden'>
					<div class='col-sm-10'>Posted on : " . $row1["date"]. " By student n° " . $row1["id"]. "</div>
					<div class='col-sm-2'>likes: " . $row1["react"]."</div>
					</div>
				</div>";

				echo'<div class="col-sm-12" style="height:10px"></div>';

			}
			$j = $j +1;
		}
	}
echo '</div>
	</div>';

?>