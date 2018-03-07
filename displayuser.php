<!DOCTYPE html>
<html lang="en">
<?php session_start(); 
if($_SESSION['userTypeID'] != 1) {
	 header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/logout.php");
}

$_SESSION['alert'] = 1;
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Display Users</title>

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
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"></link>
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
                            <a href="#"><i class="fa fa-wrench fa-fw" style="color:white"></i><font color="white"> Tools </font><span class="fa arrow" style="color:white"></span></a>
                            <ul class="nav nav-second-level">
                            <li>
								<a href="addsensortype.php"><font color="white"> Add Sensor Type </font></a>
                            </li>
							<li>
                                <a href="sensorTypePage.php"><font color="white"> Edit Status Details </font></a>
                            </li>
							<li>
                                <a href="displayuser.php"><font color="white"> Display Users </font></a>
                            </li>
                            </ul>
							<li>
								<a href="#"><i class="fa fa-sitemap fa-fw" style="color:white"></i><font color="white"> Branches </font><span class="fa arrow" style="color:white"></span></a>
								<ul class="nav nav-second-level">
								<?php 
									require_once('mysteryDB_connect.php');
									$sql = "SELECT *
											from branches where status = 0";
									$result = mysqli_query($dbc,$sql);
									while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
										$branchID = $row['branchID'];
										$branchname = $row['branchname'];	
									echo "
											<li>
											<a href='roomslist.php?branchID='.$branchID.'&branchname='.$branchname.'><font color=\"white\">$branchname </font></a>
											</li>";
									}
								?>
								</ul>
							</li>
							<li>
								<a href="#"><i class="fa fa-archive fa-fw" style="color:white"></i><font color="white"> Manage Data </font><span class="fa arrow" style="color:white"></span></a>
								<ul class="nav nav-second-level">
								<li>
                                    <a href="listbranch.php"><font color="white"> View Branches </font></a>
                                </li>
								<li>
                                    <a href="listroom.php"><font color="white"> View Rooms </font></a>
                                </li>
							
								<li>
                                    <a href="listrpi.php"><font color="white"> View Raspberry Pis </font></a>
                                </li>
								<li>
                                    <a href="listsensor.php"><font color="white"> View Sensors </font></a>
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
                    <h3 class="page-header">Users <a data-toggle="modal"  data-target="#Modal" class="btn btn-info"><i class="fa fa-plus-circle fa-fw" style="color:white"></i></a></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
				<?php
					require_once('mysteryDB_connect.php');
					
				
					
					echo
												'
													<div class="modal fade" id="Modal" role="dialog">
														<form action="'.$_SERVER['PHP_SELF'].'" method="post">
															<div class="modal-dialog modal-lg">
															  <div class="modal-content">
																<div class="modal-header">
																  <button type="button" class="close" data-dismiss="modal">&times;</button>
																  <h4 class="modal-title">Add User</h4>
																</div>
																<div class="modal-body">
																  <div class="form-group">
																	<input type="hidden" name="branchID" value="<?php echo $branchID; ?>" /> 
																		<input required name="username"class="form-control" placeholder="User Name" ">
																		<br>
																		<input required name="firstName"class="form-control" placeholder="First Name" ">
																		<br>
																		<input required name="lastName"class="form-control" placeholder="Last Name" ">
																		<br>
																		<input required name="contactNumber"class="form-control" placeholder="Contact Number" ">
																		<br>
																		<input required type="email" name="email"class="form-control" placeholder="Email" ">
																		<br>
																		<input required type="password" name="password"class="form-control" placeholder="Password" ">
																		<br>
																		<label>User Type</label>
																				<select name= "userType" class="form-control">
																	
																			';
																			$query1= "select * from usertype;"; // Run your query
																			$result1=mysqli_query($dbc,$query1);
																			echo "<option value='default'> -Select- </option>"; 
																			while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
																			$userType = $row['userType'];
																			$id = $row['userTypeID'];
																			echo "<option value=". $id .">".$userType."</option>";
																			}
																echo'
																		</select>
																		
																		<label>Branch</label>
																		<select name="branch" class="form-control">
												
												';
												$query1= "select * from branches;"; // Run your query
												$result1=mysqli_query($dbc,$query1);
												echo "<option value='default'> -Select- </option>"; 
												while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
												$branchName = $row['branchname'];
												$id = $row['branchID'];
												echo "<option value=". $id .">".$branchName."</option>";
												}
											echo'
                                            </select>
																		<br>
																</div>
																<div class="modal-footer">
																
																  <button type="submit" class="btn btn-default btn-info" name="add" >Add</button>
																  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																</div>
															  </div>
															</div>
														  </div>
														</form>
													</div>
												';

					$sql = "SELECT *, u.userTypeID as uti, b.branchID as branchID
							  from users u join usertype t on u.userTypeID = t.userTypeID
											join branches b on u.branchID = b.branchID
											";
						
					$result = mysqli_query($dbc,$sql);
					
					echo 	
							'
							<table class="table table-stipend table-bordered table-hover" id="usertable">
							<thead>
								<tr>
								<th class="text-center">User Name</th>
								<th class="text-center">Name</th>
								<th class="text-center">Contact Number</th>
								<th class="text-center">Email</th>
								<th class="text-center">User Type</th>
								<th class="text-center">Branch</th>
								
								</tr>
							</thead>
							<tbody>
							
							';
					
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {	
						$branchID = $row['branchID'];
						$uti = $row['uti'];
						$userID = $row['userID'];
						echo 
							"
							<tr>
								<td class='text-center'> <a data-toggle='modal' data-target='#myModal".$userID."' >{$row['username']} </a></td>
								<td class='text-center'> {$row['firstName']},{$row['lastName']}  </td>
								<td class='text-center'> {$row['contactNumber']} </td>
								<td class='text-center'> {$row['email']} </td>
								<td class='text-center'> {$row['userType']} </td>
								<td class='text-center'> {$row['branchname']} </td>
							</tr>
							";
							
							
								echo
												'
													<div class="modal fade" id="myModal'.$userID.'" role="dialog">
														<form action="'.$_SERVER['PHP_SELF'].'" method="post">
															<div class="modal-dialog modal-lg">
															  <div class="modal-content">
																<div class="modal-header">
																  <button type="button" class="close" data-dismiss="modal">&times;</button>
																  <h4 class="modal-title">Edit User</h4>
																</div>
																<div class="modal-body">
																  <div class="form-group">
																	<input type="hidden" name="branchID" value="<?php echo $branchID; ?>" /> 
																		<input required name="Newusername"class="form-control" placeholder="Username" value="'.$row['username'].'"">
																		<br>
																		<input required name="NewfirstName"class="form-control" placeholder="First Name" value="'.$row['firstName'].'">
																		<br>
																		<input required name="NewlastName"class="form-control" placeholder="Last Name" value="'.$row['lastName'].'">
																		<br>
																		<input required name="NewcontactNumber"class="form-control" placeholder="Contact Number"value="'.$row['contactNumber'].'">
																		<br>
																		<input required type="email" name="Newemail"class="form-control" placeholder="Email" value="'.$row['email'].'">
																		<br>
																		<input disabled type="password" name="password"class="form-control" placeholder="Password" value="'.$row['email'].'">
																		<br>
																		<label>User Type</label>
																				<select name= "NewuserType" class="form-control">
																	
																			';
																			$query1= "select * from usertype;"; // Run your query
																			$result1=mysqli_query($dbc,$query1);
																			echo "<option value='default'> -Select- </option>"; 
																			while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
																			$userType = $row['userType'];
																			$id = $row['userTypeID'];
																			
																			echo "<option value=".$id."";
																					if($uti == $id){ echo" selected";};
																					echo ">".$userType."</option>";
														
																			}
																echo'
																		</select>
																		
																		<label>Branch</label>
																		<select name="Newbranch" class="form-control">
												
												';
												$query1= "select * from branches;"; // Run your query
												$result1=mysqli_query($dbc,$query1);
												echo "<option value='default'> -Select- </option>"; 
												while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
												$branchName = $row['branchname'];
												$id = $row['branchID'];
												echo "<option value=".$id."";
																					if($id == $branchID){ echo" selected";};
																					 echo ">".$branchName."</option>";
												}
											echo'
                                            </select>
																		<br>
																</div>
																<div class="modal-footer">
																
																  <button type="submit" class="btn btn-default btn-info" name="edit" >Edit</button>
																  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																</div>
															  </div>
															</div>
														  </div>
														</form>
													</div>
												';
					}
					
					echo '</tbody> </table>';
					//edit press
						if (isset($_POST['edit'])){
											
											$message=NULL;
											
												 
											 if (isset($_POST['userID'])){
												$userID = $_POST['userID'];
											}
											else{
												$branchID = -1;
											}
											
											$Newbranch = $_POST['Newbranch'];
											$NewcontactNumber = $_POST['NewcontactNumber'];
											$Newemail = $_POST['Newemail'];
											$NewfirstName = $_POST['NewfirstName'];
											$NewlastName = $_POST['NewlastName'];
											$NewuserType = $_POST['NewuserType'];
											$Newusername = $_POST['Newusername'];
											
											
							
											$query1="update users 
														set firstName = '$NewfirstName', lastName = '$NewlastName', 
														username = '$Newusername'	,email = '$Newemail'	, contactNumber = '$NewcontactNumber',
														branchID = '$Newbranch'	, userTypeID = '$NewuserType'												
														where userID = $userID";
															
																  
												$result=mysqli_query($dbc,$query1);
												if ($result) {
													echo "<meta http-equiv='refresh' content='2'>"; //refresh page
													/*		
														
													echo'<script>
															window.href = "listbranch.php";
														</script>
														';
													*/
										
												
													echo'
														<div class="alert alert-success">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Success!</strong> Success Editing '.$Newusername.'.
														</div>
												
														';
													
												
												}
												else{
													echo'
														<div class="alert alert-danger">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Error!</strong> Changes not made for username:'.$Newusername.'.
														</div>
														';
												}	
										}
										
					//add press
					if (isset($_POST['add'])){
							
						//check if username already exists 
								$message=NULL;
																
								if(empty($_POST['username'])){
									 $username=FALSE;
								}else{
									$query= "select * from users where username = '{$_POST['username']}' "; // Run your query
									$result=mysqli_query($dbc,$query);
									$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
									if(empty($row)){
										$username = $_POST['username'];
									}else {
										$message .= '<p>UserName already Exists';
									}
								}
								
								if($_POST['userType'] == 'default'){
									 $message .= '<p>Empty user Type';
									 $userTypeID=FALSE;
								}else $userTypeID = $_POST['userType'];

								if($_POST['branch']== 'default'){
									 $message .= '<p>Empty branch';
									 $branchID=FALSE;
								}else $branchID = $_POST['branch'];

								$password = $_POST['password'];
								$firstName = $_POST['firstName'];
								$lastName = $_POST['lastName'];
								$email = $_POST['email'];
								$contactNumber = $_POST['contactNumber'];
								
								
								if(!isset($message)){
									
									$query1="insert into users(username,firstName,lastName,email,contactNumber,password,userTypeID,branchID)
											 values ('$username ','$firstName','$lastName','$email','$contactNumber',password('$password'),'$userTypeID','$branchID')";
									$result=mysqli_query($dbc,$query1);
									echo'
									<div class="alert alert-success">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong>Success!</strong> User Added.
									</div>';
																	
								}

								if(isset($message)){
									echo'
									<div class="alert alert-danger">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong>Error!</strong> '.$message.'
									</div>
									';	
									
								}																										
													/*	echo "<meta http-equiv='refresh' content='0'>"; //refresh page
													echo'<script>
															window.href = "listbranch.php";
														</script>
														';*/
														
				
						
						
					}
					//end of add
					
				?>
        </div>
        <!-- /#page-wrapper -->

    </div>
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
	
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	
		<script> 
		$(document).ready(function(){
			$('#usertable').DataTable();
		});
		</script>
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
