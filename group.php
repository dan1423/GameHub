<?php
include ('includes/session.php');
include ('includes/header.php');
include('mysqli_connect.php');
include('select_options.php');

$group_array = array();
$dropdown_list = optionsForSelectMembers($dbc);


$sql = "SELECT * FROM group_table";
$result = mysqli_query($dbc, $sql) or die("Error: ".mysqli_error($dbc));

while($row = mysqli_fetch_assoc($result)){
	$group_array[] = $row;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	//if user wants to view group, send to group page
	if(isset($_POST['viewGroup'])){
		$_SESSION['group_id'] = mysqli_real_escape_string($dbc,$_POST['viewGroup']);
		header("location:view_group.php");
	
	}else if(isset($_POST['deleteGroup'])){//admin wants to delete group
		$group_id = mysqli_real_escape_string($dbc,$_POST['deleteGroup']);

		//delete members from group_members and delete group table
		$delete_query = "DELETE FROM group_table WHERE group_id = '$group_id';";
		$delete_query.= "DELETE FROM group_members WHERE group_id = '$group_id';";

		$result = mysqli_multi_query($dbc, $delete_query) or die(mysqli_error($dbc));

		if( mysqli_affected_rows($dbc) > 0){
			header("Refresh:0");
		}
		
		
	
	}else if(isset( $_POST['group'])){
		//else user wants to create a new group
		$group_name = mysqli_real_escape_string($dbc, $_POST['group']);
		$group_members = mysqli_real_escape_string($dbc, $_POST['members']);
		$group_desc = mysqli_real_escape_string($dbc, $_POST['description']);
		$user_id = $_SESSION['user_id'];

		$sql = "INSERT INTO group_table(user_id,group_name,group_desc) 
				VALUES('$user_id','$group_name','$group_desc')";
		
		$result = mysqli_query($dbc,$sql) or die("Error: ".mysqli_error($dbc));
		
		$id_of_last_group_created = mysqli_insert_id($dbc);//get primary key of the group the user just created
		$member_array = explode(',', $group_members);//convert string of members separated by commas into an array

		//multiple inserts
		$insert_members = '';
		for($x = 0; $x < sizeof($member_array); $x++){
			$email = preg_replace('/\s+/', '',$member_array[$x]);
			//append query for each email in the array
			if($email != "," && $email !=''){
				$insert_members.="INSERT INTO group_members(group_id,user_email)
								  VALUES('$id_of_last_group_created','$email');";
			}
		}
		
		$result2 = mysqli_multi_query($dbc,$insert_members) or die("Error: ".mysqli_error($dbc));
		if( mysqli_affected_rows($dbc) > 0){
			header("Refresh:0");
		}

		}
}

?>

<div class = "row">
	<button class = "btn btn-primary" id = "createGroup">Create Group</button>
</div>

<div class = "row" id = "formCreateGroup" hidden>
	<form class = "form-horizontal" action = "group.php" method = "POST">
		<div class = "form-group">
			 <label class="control-label col-sm-2" for="groupName">Group Name:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control title" id="groupName" name = "group" placeholder="Enter group name" required>
			    </div>
		</div>
		<div class="form-group">
		    <label class="control-label col-sm-2" for="desc">Group Description</label>
		    <div class="col-sm-10">
		      <textarea class="form-control" rows="5" id="desc" name = "description" required></textarea>
		    </div>
		  </div>
		  <div class = "form-group">
			 <label class="control-label col-sm-2" for="members">Members</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control title" id="members" name = "members" placeholder="Members" required>
			    </div>
		</div>
		
		 <div class="form-group"> 
			<div class="col-sm-offset-2 col-sm-10">
				<button type = "submit" name = "submitted" class="btn btn-success">Submit</button>
			</div>
		</div>		
	</form>
	<div class = "form-group">
			 <label class="control-label col-sm-2" for="memberList">Add members</label>
			    <div class="col-sm-4">
					<select name id = "currentlySelected">
						  <?php echo $dropdown_list;?>
					</select>
					<button class = "btn btn-success" id = "addMember">Add Member</button>
			    </div>
		</div>
</div>

<div class = "row">
	<div class = "row">
	<table class="table">
    <thead>
      <tr>
        <th>Group</th>
        <th>Description</th>
        <th></th>
      </tr>
    </thead>
     <tbody>
	<?php
    	for($i = 0; $i < sizeof($group_array); $i++){
    ?>
	<tr>
		<td><?php echo $group_array[$i]['group_name']?></td>
        <td><?php echo $group_array[$i]['group_desc']?></td>
        <td>
        <form action = "group.php" method = "POST">
        <button type = "submit" class = "btn btn-success" name = "viewGroup" value = "<?php echo $group_array[$i]['group_id']?>">View Group</button>
        <form>
        </td>
        <?php
        if($is_admin){//admin should be able to delete group
	        echo(	
	        '<td>
	        <form action = "group.php" method = "POST">
	        <button type = "submit" class = "btn btn-danger" name = "deleteGroup" value ="'.$group_array[$i]["group_id"].'">Delete Group</button>
	        <form>
	        </td>');
    	}
        ?>
	</tr>
	<?php
		}
	?>
	</tbody>
	</table>
</div>
</div>

<?php
include ('includes/footer.html');
?>
<script>
$('#createGroup').click(function(){
   		$('#formCreateGroup').removeAttr('hidden');
   		});
	$('#addMember').click(function(){
		var selected = $("#currentlySelected :selected").text();
		var input = $( "#members" );
		input.val( input.val() + selected+',');

	});
</script>