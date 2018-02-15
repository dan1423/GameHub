<?php
	/*sets the option list for a select tag.
	*sets the parameter passed in currently selected in dropsown option list
	*/
	function optionsForSelectTag($selectedOptionForDropdown){
		$selections = array('Recently Added','All','Playstation 4','XBOX One','PC','Nintendo');
		$options = '';
		for($i = 0; $i < sizeof($selections); $i++){

			if($selectedOptionForDropdown == $selections[$i]){//get the clicked option and set at selected for the selection list
				$options.='<option selected>'.$selections[$i].'</option>';
			}else{
				$options.='<option>'.$selections[$i].'</option>';
			}
			
		}
		return $options;
	}
	//when adding members to grooup, query all users and set to potions tag for dropdown menu
	function optionsForSelectMembers($dbc){
		$array = array();
		$sql = "SELECT user.email FROM user";
		$result = mysqli_query($dbc,$sql) or die(mysqli_error($dbc));
		while($row = mysqli_fetch_assoc($result)){
			$array[] = $row;
		}
		$options = '';
		for($i = 0; $i < sizeof($array); $i++){
			$options.='<option>'.$array[$i]['email'].'</option>';
		}

		return $options;
		
	}
?>