<?php # Script 8.6 - view_users.php #2
include ('includes/session.php');
include ('includes/header.php');
require_once ('mysqli_connect.php');
$page_title = 'Admin Panel';

?>
<div class = "row">
<ul class="nav nav-pills nav-stacked col-md-2">
	<center><h4>ADMIN PANEL</h4></center>
  <li class="active"><a href="#tab_add_game" data-toggle="pill">Add Game</a></li>
  <li><a href="#tab_registered_users" data-toggle="pill">Registered Users</a></li>
</ul>
<div class="tab-content col-md-10">
        <div class="tab-pane active" id="tab_add_game">
             <center><h4>Add A Game</h4></center>
           	<div class = "row gameForm">
            <div>
			   <form class="form-horizontal" id = "addGameForm">
				  <!--title of the game-->
				  <div class="form-group">
				    <label class="control-label col-sm-2" for="game_add_title">Title:</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="game_add_title" name = "title" placeholder="Enter Title" required>
				    </div>
				  </div>
				 	<!--date game was released-->
				  <div class="form-group">
				    <label class="control-label col-sm-2" for="game_add_date">Date Released:</label>
				    <div class="col-sm-10"> 
				      <input type="date" class="form-control" id="game_add_date" name = "date" required>
				    </div>
				  </div>
				 
				 <!--consoles the game is available in-->
				  <div class="form-group">
				  <label class="control-label col-sm-2" for="consoleList">Consoles:</label>
				   	<div class = "col-sm-6" id="myDIV">
					  <select name = "consoles"  class="form-control" id = "consoleList">
						  <option>Playstation</option>
						   <option>XBOX One</option>
						   <option>PC</option>
						</select>
					</div>
					<div class="col-sm-4">
				        <button class = "btn btn-success console" onclick="return false;">Add</button>
				    </div>
				  </div>
				  <!--javascript dynamically adds selected consoles to list, user can either add or delete from list-->
				  <div class="form-group">
				  	<div class = "col-sm-4"></div>
				  	<div class = "col-sm-4">
				  		<ul id="consoleUL"></ul>
				  	</div>
				  	<div class = "col-sm-4"></div>
				  </div>
				  <!-- genres game is available in-->
				   <div class="form-group">
				  <label class="control-label col-sm-2" for="genreList">Genres:</label>
				   	<div class = "col-sm-6" id="myDIV">
					  <select name = "genres"  class="form-control" id = "genreList">
						  <option>Action</option>
						   <option>Adventure</option>
						   <option>Shooter</option>
						</select>
					</div>
					<div class="col-sm-4">
				        <button class = "btn btn-success genre" onclick="return false;">Add</button>
				    </div>
				  </div>
				   <!--javascript dynamically adds selected genres to list, user can either add or delete from list-->
				  <div class="form-group">
				  	<div class = "col-sm-4"></div>
				  	<div class = "col-sm-4">
				  		<ul id="genreUL"></ul>
				  	</div>
				  	<div class = "col-sm-4"></div>
				  </div>
				  <!--brief description of game-->
				  <div class="form-group">
				    <label class="control-label col-sm-2" for="game_add_desc">Description</label>
				    <div class="col-sm-10">
				      <textarea class="form-control" rows="5" id="game_add_desc" placeholder = "Brief Description" required></textarea>
				    </div>
				  </div>
				  
				  <div class="form-group"> 
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-success" id = "game_add_submit_btn"onclick = "return false;">Submit</button>
				    </div>
				  </div>
			</form>

         </div>
    </div>
        </div>
        <div class="tab-pane" id="tab_registered_users">
             <center><h3>Registered Users</h3></center>
            <?php 
            	// Make the query:
				$q = "SELECT CONCAT(last_name, ', ', first_name) AS name, registration_date AS dr FROM user ORDER BY registration_date ASC";		
				$r = @\mysqli_query($dbc, $q); // Run the query.

				// Count the number of returned rows:
				$num = mysqli_num_rows($r);

				if ($num > 0) { // If it ran OK, display the records.

					// Print how many users there are:
					echo "<p>There are currently $num registered users.</p>\n";

					// Table header.
					echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
					<tr><td align="left"><b>Name</b></td><td align="left"><b>Date Registered</b></td></tr>';
					
					// Fetch and print all the records:
					while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						echo '<tr><td align="left">' . $row['name'] . '</td><td align="left">' . $row['dr'] . '</td></tr>';
					}

					echo '</table>'; // Close the table.
					
					mysqli_free_result ($r); // Free up the resources.	

				} else { // If no records were returned.

					echo '<p class="error">There are currently no registered users.</p>';

				}

				mysqli_close($dbc); // Close the database connection.
            ?>
        </div>
</div>
</div>

<?php
include ('includes/footer.html');
?>	   
