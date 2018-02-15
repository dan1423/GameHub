<?php 
include ('includes/session.php');
include ('includes/header.php');
include('mysqli_connect.php');

$page_title = 'Forum';
$forum_array = array();
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])){//make sure user is logged in

	if(isset($_POST['viewThread'])){//user wants to go to a thread
		$_SESSION['thread_id'] = mysqli_real_escape_string($dbc, $_POST['viewThread']);
		header('location:view_thread.php');//send user to thread page with thread_id

	
	}else{//user wants to start a new thread
		$thread_title = mysqli_real_escape_string($dbc, $_POST['title']);
		$thread_text = mysqli_real_escape_string($dbc, $_POST['text']);
		$user_id = $_SESSION['user_id'];

		$sql = "INSERT INTO thread(title, thread_text,user_id) VALUES('$thread_title','$thread_text','$user_id')";
		$result = mysqli_query($dbc, $sql) or die("Error: ".mysqli_error($dbc));

		if(mysqli_affected_rows($dbc) > 0){
			header("Refresh:0");
		}else{
			echo'<script>alert("please check for errors and re-submit")</script>';
		}
	}

}else{//display list of created forums
	$sql = "SELECT thread.*,CONCAT(user.first_name,' ',user.last_name) AS name FROM thread,user WHERE user.user_id = thread.user_id";

	$result = mysqli_query($dbc, $sql) or die("Error: ".mysqli_error($dbc));
	while($row = mysqli_fetch_assoc($result)){
		$forum_array[] = $row;			
	}
	
}

?>

<div class = "row">
	<button class = "btn btn-primary btn-lg" id = "createThreadBtn">New Thread</button>
</div>
<div class = "row" id = "threadDiv" hidden>
	<form class = "form-horizontal" action = "forum.php" method = "POST">
		<div class = "form-group">
			 <label class="control-label col-sm-2" for="title">Title:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control title" id="title" name = "title" placeholder="Enter Title" required>
			    </div>
		</div>
		<div class="form-group">
		    <label class="control-label col-sm-2" for="threadText">Content</label>
		    <div class="col-sm-10">
		      <textarea class="form-control" rows="15" id="threadText" name = "text" required></textarea>
		    </div>
		  </div>
		 <div class="form-group"> 
			<div class="col-sm-offset-2 col-sm-10">
				<button type = "submit" name = "submitted" class="btn btn-success">Submit</button>
			</div>
		</div>		
	</form>
</div>
<!--display forums inside table-->
<div class = "row">
	<table class="table">
    <thead>
      <tr>
        <th>Author</th>
        <th>Title</th>
        <th>Replies</th>
      </tr>
    </thead>
     <tbody>
	<?php
		for($i = 0; $i < sizeof($forum_array); $i++){
	?>
	<tr>
		<td><?php echo $forum_array[$i]['name']?></td>
        <td><?php echo $forum_array[$i]['title']?></td>
        <td><?echo "#replies";//php echo $forum_array[$i]['replies']?></td>
        <td>
        <form action = "forum.php" method = "POST"> 
        <button type = "submit" class = "btn btn-md btn-success" name = "viewThread" value = "<?php echo $forum_array[$i]['thread_id']?>"> View Thread</button>
        </form>
        </td>
	</tr>
		
	<?php
	}		
	?>
	</tbody>
	</table>
</div>
<?php
include ('includes/footer.html');
?>
<script>
	$('#createThreadBtn').click(function(){
   		$('#threadDiv').removeAttr('hidden');
   
  });
</script>
