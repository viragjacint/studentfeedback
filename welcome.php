<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Jacint Virag">
    <title>Online Student Module Feedback</title>
	<!-- Bootstrap Core JavaScript -->
	<!-- jQuery Version 3.2.1 -->
	<!-- Custom Font -->
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link rel="stylesheet" href="https://bootswatch.com/simplex/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel='stylesheet' href='mf.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Online Module Feedback</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container" style="padding-top:50px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center">
				<form class="login col-md-12" style="background-color:rgba(231,231,231,0.8) ;padding-top:20px;">
				
					<h1>Please enter your student number!</h1>
					<?php if(isset($_GET["error"]) == 1){ 
						echo "<h4 style='color:red;'>Invalid number!</h4>";
						}
					?>
					<div class="input-group" style="padding-bottom:25px;">
						<input name='u' type="text" class="form-control" placeholder="e.g.:50200036">
						<span style='background-color:white;' class='input-group-addon'>
						<button type='submit'>
						<i class="fa fa-sign-in" aria-hidden="true"></i>
						</button>
						</span>					
					</div>				
				</form>		
			</div>	
        <!-- /.row -->
		</div>
    </div>
    <!-- /.container -->
</body>
</html>


