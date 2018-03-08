<!DOCTYPE html>
<html lang="en">
<?php session_start();
if($_SESSION['userTypeID'] != 1) {
	 header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/logout.php");
}
require_once('mysteryDB_connect.php');

?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mystery Manila</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation"  style="margin-bottom: 0 ; background-color:black">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-top" href="index.php" >&nbsp <img src="logo2.jpg"></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
			
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw" style="color:white"></i> <i class="fa fa-caret-down" style="color:white"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="userpage.php"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['username'];?></a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                      <li>
                            <a href="index.php"><i class="fa fa-home fa-fw" style="color:white"></i><font color="white"> Home </font></a>
                        </li>
						
							
							<li>
								<a href="#"><i class="fa fa-archive fa-fw" style="color:white"></i><font color="white"> Manage Data </font><span class="fa arrow" style="color:white"></span></a>
								<ul class="nav nav-second-level">
								<li>
                                    <a href="listbranch.php"><font color="white"><i class="fa fa-building fa-fw"></i> View Branches </font></a>
                                </li>
								<li>
                                    <a href="listroom.php"><font color="white"><i class="fa fa-ticket fa-fw"></i> View Rooms </font></a>
                                </li>
								
								<li>
                                    <a href="listrpi.php"><font color="white"><i class="fa fa-chain fa-fw"></i> View Raspberry Pis </font></a>
                                </li>
								<li>
                                    <a href="listsensor.php"><font color="white"><i class="fa fa-bullseye fa-fw"></i> View Sensors </font></a>
                                </li>
								<li>
                                <a href="displayuser.php"><font color="white"><i class="fa fa-users fa-fw"></i> View Users </font></a>
								</li>
								</ul>
                            <!-- /.nav-second-level -->
							</li>
								</ul>
                            <!-- /.nav-second-level -->
							</li>
						</ul>
					<!-- /.nav -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

			<div id="page-wrapper">
				<div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Profile</h2>
                </div>
				<div class="row">
				<div class="col-lg-12">
					<?php
					if (isset($_POST['save'])){
						$message=NULL;
						if (isset($_POST['fname'])){
							$fname = $_POST['fname'];
						}
						if (isset($_POST['sensorID'])){
							$sensorID = $_POST['sensorID'];
						}
						else{
							$branchID = -1;
						}
					}
					?>
					
					<?php
						require_once('mysteryDB_connect.php');
						$query1= "select * from users where userID = '{$_SESSION['userID']}'";
						$result1=mysqli_query($dbc,$query1);
						while($row=mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
							$userID = $row['userID'];
							$fname = $row['firstName'];
							$lname = $row['lastName'];
							$uname = $row['username'];	
							$email = $row['email'];
							$cnumber = $row['contactNumber'];
							$branchID = $row['branchID'];
								echo
													'
														<div class="modal fade" id="myModal'.$userID.'" role="dialog">
															<form action="'.$_SERVER['PHP_SELF'].'" method="post">
																<div class="modal-dialog modal-lg">
																  <div class="modal-content">
																	<div class="modal-header">
																	  <button type="button" class="close" data-dismiss="modal">&times;</button>
																	  <h4 class="modal-title">Change Password</h4>
																	</div>
																	<div class="modal-body">
																	  <div class="form-group">
																		<input type="hidden" name="userID" value="<?php echo '.$userID.'; ?>" /> 
																			<input required type="password" name="oldPass"class="form-control" placeholder="Current Password" ><br>
																			<input required type="password" name="newPass"class="form-control" placeholder="New Password" ><br>
																			<input required type="password" name="newPassa"class="form-control" placeholder="Repeat New Password" ><br>
																			
																			
																	</div>
																	<div class="modal-footer">
																	
																	  <button type="submit" class="btn btn-default btn-info" name="confirm" >Confirm</button>
																	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	</div>
																  </div>
																</div>
															  </div>
															</form>
														</div>
													';
						}
						echo
							'<h6>
							<form action="'.$_SERVER['PHP_SELF'].'" method="post">
							<div class="col-lg-4">
							<h3>First name:</h3><input required class ="form-control" type="text" name="fname" value="'.$fname.'"><br>
							</div>
							<div class="col-lg-4">
							<h3>Last name:</h3><input required class ="form-control" type="text" name="lname" value="'.$lname.'"><br>
							</div>
							<div class="col-lg-4">
							<h3>Email:</h3><input required class ="form-control" type="email" name="email" value="'.$email.'"><br>
							</div>
							<div class="col-lg-4">
							<h3>Contact Number:</h3><input required class ="form-control" type="number" name="cnumber" value="'.$cnumber.'"><br>
							</div>
							<div class="col-lg-4">
							<h3>Username:</h3><input required class ="form-control" type="text" name="uname" value="'.$_SESSION['username'].'"><br>
							</div>
							<div class="col-lg-4">
							<h3>Password:</h3><a data-toggle="modal" data-target="#myModal'.$userID.'" ><input class="form-control" type="submit" name="pass" value="Change Password" role="button" style="border-color:black" /></a><br>
							</div>
							'
					?>
					<?php
						require_once('mysteryDB_connect.php');
						$query2= "select * from branches where branchID = '{$branchID}'";
						$result2=mysqli_query($dbc,$query2);
						while($row=mysqli_fetch_array($result2,MYSQLI_ASSOC)) {
							$branch = $row['branchname'];
						}
							echo'
								<div class="col-lg-6">
								<h3>Branch:</h3><input disabled class ="form-control" type="text" value="'.$branch.'"><br>
								</div>
							'
					?>
					<?php
						require_once('mysteryDB_connect.php');
						$query3= "select * from usertype where usertypeID = '{$_SESSION['userTypeID']}'";
						$result3=mysqli_query($dbc,$query3);
						while($row=mysqli_fetch_array($result3,MYSQLI_ASSOC)) {
							$usertype = $row['userType'];
						}
							echo
								'
								<div class="col-lg-6">
								<h3>User Type:</h3><input disabled class ="form-control" type="text" value="'.$usertype.'"><br>
								</div>
								</h6>
								';
								
								
								
								if(isset($_POST['confirm'])){
									$userID = $_SESSION['userID'];
									$oldPass = $_POST['oldPass'];
									$newPass = $_POST['newPass'];
									$newPassa = $_POST['newPassa'];
									
									
									$query= "select * from users where userID = '{$userID}' and  password = Password('{$oldPass}')  ";
									$result=mysqli_query($dbc,$query);
									
									if(mysqli_num_rows($result) > 0){
									
										if($newPass == $newPassa){
											$query= "update users  
													 set password = PASSWORD('{$newPass}')
													 where userID = '{$userID}'  ";
													 
											$result=mysqli_query($dbc,$query);
											echo'
														<div class="alert alert-success">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Success!</strong> Password Changed!
														</div>
												
														';
										}
										else{
											echo'
														<div class="alert alert-danger">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Error!</strong> Password not changed.
														</div>
														';
											
										}
									
									
									
									
										
									}else{
											echo'
														<div class="alert alert-danger">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Error!</strong> Wrong Current Password.
														</div>
														';
											
										}
								
									
								}
								// for update press
								if(isset($_POST['save'])){
								
								$message=NULL;
											
												 
											 if (isset($_SESSION['userID'])){
												$userID = $_SESSION['userID'];
											}
											else{
												$branchID = -1;
											}
											
											
											$NewcontactNumber = $_POST['cnumber'];
											$Newemail = $_POST['email'];
											$NewfirstName = $_POST['fname'];
											$NewlastName = $_POST['lname'];
											
											$Newusername = $_POST['uname'];
											
											
							
											$query1="update users 
														set firstName = '$NewfirstName', lastName = '$NewlastName', 
														username = '$Newusername'	,email = '$Newemail'	, contactNumber = '$NewcontactNumber'
																									
														where userID = $userID";
															
																  
												$result=mysqli_query($dbc,$query1);
												if ($result) {
													
													/*		
														echo "<meta http-equiv='refresh' content='0'>"; //refresh page
													echo'<script>
															window.href = "listbranch.php";
														</script>
														';
													*/
													echo'
														<div class="alert alert-success">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Success!</strong> Log-Out to apply changes.
														</div>
												
														';
														
												}
												else{
													echo'
														<div class="alert alert-danger">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Error!</strong> Changes not saved.
														</div>
														';
												}	
							}
								
					?>
					</div>
					<div align="center">
					<br>
					<input type="submit" name="save" value="Save" class="btn btn-info" role="button"/>
					</div>
					</form>
					</div>
				</div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<style>
		.btn-info
		{
			background-color: black;
			color: white;
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
