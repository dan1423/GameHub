<?php
include ('includes/session.php');
include ('includes/header.php');
include('mysqli_connect.php');
include('handle_thread_and_comments.php');
	
$thread_array = array();
$page_title = 'Thread';

if(isset($_SESSION['thread_id'])){
	
	$thread_id = $_SESSION['thread_id'];

	$post_array = array("table_name"=>'thread', 
				"comment_table"=>'thread_comments', 
				"id_name"=>'thread_id',
				"main_id"=> $thread_id
				);

	$thread_array = getAllPosts($post_array,$dbc);
		
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$user_id = $_SESSION['user_id'];
	$thread_id = $_SESSION['thread_id']; 
	$text = mysqli_real_escape_string($dbc, $_POST['text']);

	//set associative array to send as parameter to function
	$post_array = array("user_id"=>$user_id, 
				"thread_id"=>$thread_id, 
				"text"=> $text,
				"id_name"=>'thread_id',
				"table_name"=>"thread_comments");

	 $res = postCommentToDatabase($post_array, $dbc);

	 // if($res){
	 	header("Refresh:0");
	// }

}




?>
<div class = "row">
	<h3>Title: <?php echo $thread_array[0]['title']; ?></h3>
</div>

<div class = "row">
	<p><?php echo $thread_array[0]['thread_text']; ?></p>
</div>
<div class = "row">
	<button class = "btn btn-primary" id = "replyToThread">reply to thread</button>
</div>
<div class = "row" id = "formReplyThread" hidden>
	<form class = "form-horizontal" action = "view_thread.php" method = "POST">
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
    	for($i = 0; $i < sizeof($thread_array); $i++){
    ?>
	<tr>
		<td><?php echo $thread_array[$i]['name']?></td>
        <td><?php echo$thread_array[$i]['post_text']?></td>
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
<script>
	$('#replyToThread').click(function(){
   		$('#formReplyThread').removeAttr('hidden');
   
  });
</script>