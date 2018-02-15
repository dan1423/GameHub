<?php
	
	function fetchGames($keyword,$is_search_from_dropdown){
		include('mysqli_connect.php');

		$game_array = array();
		$sql = "";

		if(!$is_search_from_dropdown){//the post rquest is not from ac dropdown list
			 $keyword = mysqli_real_escape_string($dbc,$_POST['keyword']);
    	 	$sql = "SELECT game.*,walkthrough.* FROM game, walkthrough WHERE game.game_id = walkthrough.game_id AND game.game_title LIKE '%$keyword%'";	

		}else{
			 //either user selected Recently Added or a console from the dropdown list
	       if($keyword == 'Recently Added'){
	    	 	$sql = "SELECT game.*,walkthrough.* FROM game,walkthrough WHERE game.game_id = walkthrough.game_id ORDER BY game.date_added DESC LIMIT 2";//get games added by recent date
	    	 }else if($keyword == 'All'){
	    	 	$sql = "SELECT game.*, walkthrough.* FROM game, walkthrough WHERE game.game_id = walkthrough.game_id ORDER BY game.game_title";

	    	 }else{
	    	 	 $sql = "SELECT game.*, walkthrough.* FROM game, walkthrough WHERE game.game_id = walkthrough.game_id AND game.game_console LIKE '%$keyword%'";//get games that have the selected console
	    	 } 
			 $result = mysqli_query($dbc,$sql) or die("Error: ". mysqli_error($dbc)); 

			 //edit search result heading
			$search_results_heading = 'Search for: '.$keyword.' games';
			 while($row = mysqli_fetch_assoc($result)){
				$game_array[] = $row;
			 }
		}

		$result = mysqli_query($dbc,$sql) or die("Error: ". mysqli_error($dbc)); 
		while($row = mysqli_fetch_assoc($result)){
			$game_array[] = $row;
		}
      
      return $game_array;
    }
?>