<?php
	include('mysqli_connect.php');
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$title = mysqli_real_escape_string($dbc,$_POST['game_title']);
		$date_released = mysqli_real_escape_string($dbc,$_POST['date_released']);
		$consoles = mysqli_real_escape_string($dbc,$_POST['consoles']);
		$genres = mysqli_real_escape_string($dbc,$_POST['genres']);
		$description = mysqli_real_escape_string($dbc,$_POST['description']);

		$sql = "INSERT INTO game(game_title, game_desc, game_genre, date_added, game_console) VALUES('$title','$description','$genres','$date_released','$consoles')";

		$result = mysqli_query($dbc, $sql) or die("Error: ".mysqli_error($dbc));
		 
		if( mysqli_affected_rows($dbc) > 0){
			echo("success");
		}else{
			echo("could not add game");
		}
	}
?>