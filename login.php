<!DOCTYPE html>
<html lang="en">
<?php session_start();

$_SESSION['userID'] = null; 
$_SESSSION['userTypeID'] = null;
$_SESSION['username'] = null;
require_once('mysteryDB_connect.php'); 

if (isset($_POST['submit'])){ 
 $message=null;
 $userName=null;
					if(preg_match("/([%\$<>#\*]+)/", $_POST['username'])){
											   $message.="<br>do not put any special characters " ;
					}
					else
					{
											  $userName =$_POST['username'];	
					}
											
			$password=$_POST['password']; 
		
			
			$query = "SELECT * FROM users WHERE username = '{$userName}' AND password = PASSWORD('{$password}')";
			$result = mysqli_query($dbc,$query);
			if (mysqli_num_rows($result) > 0) {
				$query = "SELECT * FROM users WHERE username = '{$userName}' AND password = PASSWORD('{$password}')";
				$result = mysqli_query($dbc,$query);
				while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
					$_SESSION['userID'] = $row['userID'];
					$_SESSION['userTypeID'] = $row['userTypeID'];
					$_SESSION['username']  = $row['username'];
					$_SESSION['from'] =0;
					
					if ($row['userTypeID'] == 1) {
						header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
					} else if ($row['userTypeID'] == 2) {
						$_SESSION['branchID']  = $row['branchID'];
						header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/indexGamemaster.php");
					}
			}
			} else $message .= "<br>Username and password do not match.";
			
			
		
			
}

?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mystery Manila Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<link rel="icon" type="image/png" sizes="96x96" href="favicon-96x96.png">

</head>

<body style=background-color:black>
<div align="center">
<img style="width:500px;height:250px;" src="logo.gif" align="top">
</div>
    <div class="container"style=background-color:black>
	
        <div class="row" style=background-color:black>
            <div class="col-md-4 col-md-offset-4"style=background-color:black>
                <div class="login-panel panel panel-default">
                    <div class="panel-body" style=background-color:black>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input required class="form-control" placeholder="Username" name="username" autofocus>
                                </div>
                                <div class="form-group">
                                    <input required class="form-control" placeholder="Password" name="password" type="password" >
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                               <div align="center"><input type="submit" name="submit" value="Login" class="btn btn-info" role="button"/></div>
                            </fieldset>
                        </form>
                    </div>
				
                </div>
					<?php
			//Error Message S
			if (isset($message)){
				
			
			 echo'
											<div class="alert alert-danger">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong>Error!</strong> '.$message.'
											</div>
											';	
			}
			//Error Message E
			?>
            </div>
        </div>
			
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<style>
		.btn-info
		{
			background-color: white;
			color: black;
			border: black;
		
		}
		
		.btn-info:hover{
			color: white;
			background-color: gray; 
			border: gray;
			
		}
		
		
	</style>

</body>

</html>
