<?php

include ('includes/session.php');
include ('includes/header.php');
include('mysqli_connect.php');
include('handle_thread_and_comments.php');

$walkthrough_array = array();


if(isset($_SESSION['walkthrough_id'])){

	
	$walkthrough_id = $_SESSION['walkthrough_id'];

	$post_array = array("table_name"=>'walkthrough', 
					"comment_table"=>'walkthrough_comments', 
					"id_name"=>'walkthrough_id',
					"main_id"=> $walkthrough_id,
					);

	
	$walkthrough_array = getAllPosts($post_array,$dbc);
		
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){

		if (isset($_POST['wtext'])){//admin wants to submit walkthrough
			
			$walkthrough_id = $_SESSION['walkthrough_id'];
			$title = mysqli_real_escape_string($dbc, $_POST['wtitle']);
			$text = mysqli_real_escape_string($dbc, $_POST['wtext']);
			
			$res = submitWalkthrough($walkthrough_id,$title,$text,$dbc);

			//if($res == true){
				header('Refresh:0');
			//}else{
				//echo('<script>alert("error updating walkthrough")</script>');
			//}


		}else{//user wants to post comments
		$user_id = $_SESSION['user_id'];
		$thread_id = $_SESSION['walkthrough_id'];
		$text = mysqli_real_escape_string($dbc, $_POST['text']);

		//set associative array to send as parameter to function
		$post_array = array("user_id"=>$user_id, 
					"thread_id"=>$thread_id, 
					"text"=> $text,
					"id_name"=>'walkthrough_id',
					"table_name"=>"walkthrough_comments");

		 $res = postCommentToDatabase($post_array, $dbc);
		 	header("location:walkthrough.php");

		}
	}
?>
	
<?php 
		if($is_admin){//admin will ability to edit walkthrough
			echo('<form class="form-horizontal" action = "walkthrough.php" method = "POST">
								 
			  <!--title of the game-->
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="title">Title:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control title" name = "wtitle"  id = "walkthroughTitle" value = "Test Title"  required readonly>
			    </div>
			  </div>
			 
			  <!--brief description of game-->
			  <div class="form-group" ">
			    <label class="control-label col-sm-2" for="description">steps</label>
			    <div class="col-sm-10">
			      <textarea class="form-control" rows="20" name = "wtext" id="WalkthroughDescription"readonly>'. $walkthrough_array[0]['walkthrough_text'].'</textarea>
			    </div>
			  </div>
			  
			  <!--edit and submit button, check if user is an admin for walkthrough-->
			  <div class="form-group"> 
			   		<div class="col-sm-offset-2 col-sm-10">
					<button  class="btn btn-default" onclick = "return false;" id = "editWalthroughBtn">Edit</button>
						      <button type="submit" class="btn btn-default">Submit</button>
						    </div>
					</div>
				</form>');
		
		}else{//do not display admin functions to non-Admin users
			echo('<div class = "row">
					<h2>'.$walkthrough_array[0]['title'].'</h2>'.
					'<p>'.$walkthrough_array[0]['walkthrough_text'].'</p>
				</div>

				');

		}
?>



<!--form that allows user to reply to walkthrough-->
<div class = "row">
	<button class = "btn btn-primary" id = "replyToWalkthrough">reply to thread</button>
</div>

<div class = "row" id = "formReplyToWalkthrough" hidden>
	<form class = "form-horizontal" action = "walkthrough.php" method = "POST">
		<div class="form-group">
		    <label class="control-label col-sm-2" for="threadText">Comment</label>
		    <div class="col-sm-10">
		      <textarea class="form-control" rows="5" id="threadText" name = "text" required></textarea>
		    </div>
		  </div>
		 <div class="form-group"> 
			<div class="col-sm-offset-2 col-sm-10">
				<button type = "submit" name = "submitted" class="btn btn-success">Submit</button>
			</div>
		</div>		
	</form>
</div>


<div class = "row">
	<div class = "row">
	<table class="table">
    <thead>
      <tr>
        <th>User</th>
        <th>Comment</th>
      </tr>
    </thead>
     <tbody>
	<?php
    	for($i = 0; $i < sizeof($walkthrough_array); $i++){
    ?>
	<tr>
		<td><?php echo $walkthrough_array[$i]['name']?></td>
        <td><?php echo $walkthrough_array[$i]['post_text']?></td>
	</tr>
	<?php
		}
	?>
	</tbody>
	</table>
</div>
</div>
<?php
	include('includes/footer.html');
?>
<script >
	$('#editWalthroughBtn').click(function(){
  document.getElementById('WalkthroughDescription').readOnly = false;
   document.getElementById('walkthroughTitle').readOnly = false;
});
	$('#replyToWalkthrough').click(function(){
      $('#formReplyToWalkthrough').removeAttr('hidden');
   
  });
</script>