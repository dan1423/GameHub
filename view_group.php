<?php
include ('includes/session.php');
include ('includes/header.php');
include('mysqli_connect.php');


$group_array = array();

if(isset($_SESSION['group_id'])){

	$group_id = $_SESSION['group_id'];

	$sql = "SELECT CONCAT(user.first_name,' ',user.last_name) AS name, user.email,group_table.group_name 
			FROM user,group_members,group_table
			WHERE user.email = group_members.user_email 
			AND group_members.group_id = '$group_id'
			AND group_table.group_id = group_members.group_id";

	$result = mysqli_query($dbc, $sql) or die("Error: ".mysqli_error($dbc));

	while($row = mysqli_fetch_assoc($result)){
		$group_array[] = $row;
	}

}
?>
<div class = "row">
	<h1><?php echo $group_array[0]['group_name']?></h1>
</div>

<div class = "row">
	<div class = "row">
	<table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th></th>
      </tr>
    </thead>
     <tbody>
	<?php
    	for($i = 0; $i < sizeof($group_array); $i++){
    ?>
	<tr>
		<td><?php echo $group_array[$i]['name']?></td>
        <td><?php echo $group_array[$i]['email']?></td>
        
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