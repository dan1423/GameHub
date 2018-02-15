<?php
	
	//resposible for posting comments in both walkthrough_comments and thread_comments table
	function postCommentToDatabase($post_array, $dbc){
		$thread_id = $post_array['thread_id'];
		$user_id = $post_array['user_id'];
		$text = $post_array['text'];
		$id_name = $post_array['id_name'];
		$table_name = $post_array['table_name'];
		
		$sql = "INSERT INTO $table_name($id_name,user_id,post_text) VALUES('$thread_id','$user_id','$text')";
		$result = mysqli_query($dbc, $sql) or die("Error: ".mysqli_error($dbc));

		return $result;
	}

	//Admin wants to submit or uodate walkthrough
	function submitWalkthrough($walkthrough_id,$title,$text,$dbc){

		$sql = "UPDATE walkthrough SET title = '$title',walkthrough_text = '$text' 
				WHERE walkthrough_id = '$walkthrough_id'";	
		
		 $result = mysqli_query($dbc,$sql) or die("Error: ". mysqli_error($dbc)); 
		 if(mysqli_affected_rows($dbc) <= 0){
		 	return false;
		 }
		 return true;
	}

	//querries all threads from table(walkthrough or forum posts)
	//both table share similar characteristics, so this fuction can be used more than once
	function getAllPosts($post_array,$dbc){

		$table = $post_array['table_name'];
		$comment_table = $post_array['comment_table'];
		$id_name = $post_array['id_name'];
		$main_id = $post_array['main_id'];

		/*THe reason for two query statement is that i don't know how to triple join the tables
	*so we try the first query that selects comments
	*if there are no comments, we try the second query
	*/


		$sql = "SELECT $table.*, $comment_table.*, CONCAT(user.first_name,' ',user.last_name) AS name 
			FROM $table, $comment_table,user 
			WHERE $table.$id_name = '$main_id' 
			AND $comment_table.$id_name = $table.$id_name
			AND user.user_id = $comment_table.user_id";

			$result = mysqli_query($dbc,$sql) or die(mysqli_error($dbc));
			
			//if query returns null, we try a different select statement
			if(mysqli_num_rows($result) <= 0){
	            $sql = "SELECT * from $table WHERE $table.$id_name = '$main_id' ";
	            $result = mysqli_query($dbc,$sql) or die(mysqli_error($dbc));
			}
			

		while($r = mysqli_fetch_assoc($result)){
			$return_array[] = $r;
		}

		return $return_array;
		
	}
?>