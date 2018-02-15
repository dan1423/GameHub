<html lang="en">
<head>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
        
    <!-- Bootstrap theme -->
    <!-- -->
	<link href="css/theme.css" rel="stylesheet" /> 
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!--<script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>-->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="./js/handle_button_clicks.js"></script>
	

    <!-- Custom CSS -->
	<!-- 
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"> 
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700"> 
	<link rel="stylesheet" href="css/otherstyle.css"> 
	-->
  <link rel="stylesheet" href="css/custom.css"> 
    
    <title><?php echo $page_title; ?></title>	
    
        <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   <!-- <script src="js/custom.js"></script>-->
</head>

<body role="document">
    
    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><?php echo $user_name ?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
                
			<?php 
			if (!isset($_SESSION['user_id'])) {
				echo '<li><a href="register.php">Register</a></li> ';
				echo '<li><a href="login.php">Sign In</a></li>';
			}
			else
			{
				if ($is_admin) {
					echo '<li><a href="admin_panel.php">Admin Panel</a></li>';
				}
				echo '<li><a href="password.php">Change Password</a></li>';
				echo '<li><a href="logout.php">Log Out</a></li>';		
        echo '<li><a href="view_games.php">View Games</a></li>';
        echo '<li><a href="forum.php">Forum</a></li>';
         echo '<li><a href="group.php">Group</a></li>';		
			}
			?>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    
    
    <div class="container theme-showcase" role="main">
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
          <!-- Start of the page-specific content. -->
<!-- Script 8.1 - header.html -->
