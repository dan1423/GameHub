<?php
	include('mysqli_connect.php');
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$walkthrough_id = mysqli_real_escape_string($dbc, $_POST['walkthrough_id']);
		$title = mysqli_real_escape_string($dbc, $_POST['title']);
		$text = mysqli_real_escape_string($dbc, $_POST['text']);

		$sql = "UPDATE walkthrough SET title = '$title',walkthrough_text = '$text' WHERE walkthrough_id = '$walkthrough_id'";	
		 $result = mysqli_query($dbc,$sql) or die("Error: ". mysqli_error($dbc)); 

		 if($result > 0){
		 	echo($text);
		 }else{
		 	echo("could not update walkthrough");
		 }
	}
?>