<?php # Script 8.5 - register.php #2
include ('includes/session.php');

$page_title = 'Available Games';
//when user clicks an option in dropdown menu, we will use this to save that option
$selected_option_for_dropdown = 'Recently Added';
//heading to display after searching for games
$search_results_heading = 'Recently Added';
//will store results of game search query
$game_array = array();


include ('includes/header.php');
include('select_options.php');
include('mysqli_connect.php');
include('get_games_from_database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//send user to walkthrough page
	if(isset($_POST['viewWalkthrough'])){
		$_SESSION['walkthrough_id'] = mysqli_real_escape_string($dbc, $_POST['viewWalkthrough']);
		header('location:walkthrough.php');
	}

	$is_search_from_dropdown = false;
	
	if(isset($_POST['consoles'])){
		$keyword = mysqli_real_escape_string($dbc,$_POST['consoles']);
		$selected_option_for_dropdown = $keyword;//set currently selected dropdown option
		$is_search_from_dropdown = true;
	}else{
		$keyword = mysqli_real_escape_string($dbc,$_POST['keyword']);
	}
    	$search_results_heading = 'Search for: '.$keyword.' games';
     	$game_array = fetchGames($dbc,$keyword, $is_search_from_dropdown);	
     	
} else{//on page load we want to display recently added games
	 $game_array = fetchGames($dbc,'Recently Added',true);
	 
	 
}

?>
<div class = "row games">
  <form class="form-inline " action = "view_games.php" method = "POST" >
    <input class="form-control mr-sm-2" type="search" placeholder="Search" name = "keyword">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
  </form>
   <form  action = "view_games.php" class="form-inline styled-select" id = "games_form" name="games_form" method="POST" >
  		<select name = "consoles" onchange="this.form.submit()">
		  <?php echo optionsForSelectTag($selected_option_for_dropdown);?>
		</select>
  </form>
</div>
<hr>

<div class="page-header">
    <h2><?php echo $search_results_heading ?></h2>
</div>

<div class = "row">
	<!--Begining of the loop. We go through the game_aray within div row -->
	<?php 
		for($i = 0; $i < sizeof($game_array); $i++){
	?>
		<!--we want four games per line, so each div is of class col-mid-3
		we set each div to the attributes of each game that we got from the database-->
		<div class = "col-md-3">
			<!--<div class = "row" style = "margin-bottom: 5px">-->
				<div class = "row">
					<h4> <?php echo $game_array[$i]['game_title']?></h4>
				</div>
				<div class = "row" style = "margin-bottom: 5px">
					<img src= "images/<?php echo $game_array[$i]['game_title']?>.jpg"class="img-rounded" alt="Cinque Terre" style = "width:200px;height:200px;overflow: hidden">
				</div>
			<!--</div>	-->
			<div class = "row">
				<div class="btn-group" role="group" aria-label="Group of Buttons">
					<form class="form-inline " action = "view_games.php" method = "POST">						
					  <button type="submit" class="btn btn-primary" name = "viewWalkthrough" value = <?php echo$game_array[$i]["game_id"]?>>Walkthrough</button>
					 </form>
				  <button type="button" class="btn btn-primary" data-toggle="modal"  data-target="#btn<?php echo$game_array[$i]["game_id"]?>">View Info</button>
				</div>
			</div>
		</div>
		
		 <!-- create a modal for each game-->
	   <div id= "btn<?php echo $game_array[$i]['game_id']?>" class="modal fade">
	       
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                    <h4 class="modal-title">Game Info</h4>
	                </div>
	                <div class="modal-body">
	                    <div class = "row"><center><h2> <?php echo $game_array[$i]['game_title']?></h2></center></div>
	                    <div class = "row">
	                    	<div class = "col-md-8">
	                    		<img src= "images/<?php echo $game_array[$i]['game_title']?>.jpg"class="img-rounded" alt="Cinque Terre" style = "width:100%;height:50%;overflow:hidden;">
	                    	</div>
	                    	<div class = "col-md-4">
	                    		<div class = "row">
	                    			<label for="genre">Genre:</label>
									<p id ="genre"><?php echo $game_array[$i]['game_genre']?></p>
	                    		</div>
	                    		<div class = "row">
	                    			<label for="desc">Description:</label>
									<p id ="desc"><?php echo $game_array[$i]['game_desc']?></p>
	                    		</div>
	                    		<div class = "row">
	                    			<label for="console">Console:</label>
									<p id ="console"><?php echo $game_array[$i]['game_console']?></p>
	                    		</div>
	                    		<div class = "row">
	                    			<label for="date">Date Added:</label>
									<p id ="date"><?php echo $game_array[$i]['date_added']?></p>
	                    		</div>
	                    	</div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                </div>
	            </div>
	        </div>
	    </div>

	



		<!--hide modal here put all info inside modal, and display on button click-->
		<!--if user is admin, display edit game info button, edit/create walkthrough, and delete game-->

		<!--this is the end of the for loop, we close it by declaring a php block and
		adding a closing brace-->
	<?php
		}
	?>	
</div>

<?php
include ('includes/footer.html');
?>

