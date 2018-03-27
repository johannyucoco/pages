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

    <title>View Users</title>

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
	
	<link rel="icon" type="image/png" sizes="96x96" href="favicon-96x96.png">

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
									$sql1 = "SELECT  count(r.roomID) as num from branches b join rooms r 
																			on r.branchID = b.branchID
																			where b.status = 0 and b.branchID = '{$branchID}'
																			group by b.branchID";
									$result1 = mysqli_query($dbc,$sql1);
									$row1=mysqli_fetch_array($result1,MYSQLI_ASSOC);
									if($row1){
									echo "
											<li>
									<a href=\"roomslist.php?branchID={$branchID}&branchname= {$branchname}\"><font color=\"white\">{$row1['num']} <i class=\"fa fa-arrow-circle-right\"></i> $branchname </font> </a>
											</li>";
									}else{
										echo "
											<li>
											<a href=\"roomslist.php?branchID={$branchID}&branchname= {$branchname}\"><font color=\"white\">0 <i class=\"fa fa-arrow-circle-right\"></i> $branchname </font> </a>
											</li>";
										
									}
									}
								?>
								</ul>
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

            <div class="row">
                <div class="col-lg-12">
					<h3>Users <a data-toggle="modal"  data-target="#Modal"><span role="button"><i class="fa fa-plus-square fa-fw" style="color:black"></i></span></a> </h3>
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
												$query1= "select * from branches where status=0"; // Run your query
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

					$sql = "SELECT *, u.userTypeID as uti, b.branchID as branchID, u.userID as ID 
							  from users u join usertype t on u.userTypeID = t.userTypeID
											join branches b on u.branchID = b.branchID
											
											";
						
					$result = mysqli_query($dbc,$sql);
					
					echo 	
							'
							<table class="table table-bordered table-striped table-hover" id="usertable">
							<thead>
								<tr>
								
								<th class="text-center">Username</th>
								<th class="text-center">Name</th>
								<th class="text-center">Contact Number</th>
								<th class="text-center">Email</th>
								<th class="text-center">Type</th>
								<th class="text-center">Branch</th>
								<th class="text-center"><i class="fa fa-edit fa-fw" style="color:black"></i></th>
											
								
								</tr>
							</thead>
							<tbody>
							
							';
					
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {	
						$branchID = $row['branchID'];
						$uti = $row['uti'];
						$userID = $row['ID'];
						
						echo 
							"
							<tr>
								<td class='text-center'> {$row['username']} </td>
								<td class='text-center'> {$row['firstName']} {$row['lastName']}  </td>
								<td class='text-center'> {$row['contactNumber']} </td>
								<td class='text-center'> {$row['email']} </td>
								<td class='text-center'> {$row['userType']} </td>
								<td class='text-center'> {$row['branchname']} </td>
								<td class='text-center'> <a data-toggle='modal' data-target='#myModal".$userID."' ><span role='button'> <i class='fa fa-edit fa-fw'style='color:blue'></span></i></a> </a></td>
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
																	<input type="hidden"  name="newuserID" value=" '.$userID.'" /> 
																		<b> Username: </b>
																		<input required name="Newusername"class="form-control" placeholder="Username" value="'.$row['username'].'"">
																		<br>
																		<b> First Name: </b> 
																		<input required name="NewfirstName"class="form-control" placeholder="First Name" value="'.$row['firstName'].'">
																		<br>
																		<b> Last Name: </b> 
																		<input required name="NewlastName"class="form-control" placeholder="Last Name" value="'.$row['lastName'].'">
																		<br>
																		<b> Contact Number: </b> 
																		<input required name="NewcontactNumber"class="form-control" placeholder="Contact Number"value="'.$row['contactNumber'].'">
																		<br>
																		<b> Email: </b> 
																		<input required type="email" name="Newemail"class="form-control" placeholder="Email" value="'.$row['email'].'">
																		<br>
																		<b> Password: </b> 
																		<input disabled type="password" name="password"class="form-control" placeholder="Password" value="'.$row['email'].'">
																		<br>
																		 
																		<label>User Type</label>
																				<select name= "NewuserType" class="form-control">
																	
																			';
																			$query1= "select * from usertype"; // Run your query
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
																		<select name="Newbranch" class="form-control" id="bran">
												
																			';
																			$query1= "select * from branches where status=0;"; // Run your query
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
																
																  <button type="submit" class="btn btn-default btn-info" name="edit"  >Edit</button>
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
											
												 
											 if (isset($_POST['newuserID'])){
												$userID = $_POST['newuserID'];
												
											}
											else{
												$userID = -1;
											}
											
											$Newbranch = $_POST['Newbranch'];
											$NewcontactNumber = null;
											$Newemail = $_POST['Newemail'];
											$NewfirstName = null;
											$NewlastName = null;
											$NewuserType = $_POST['NewuserType'];
											$Newusername = null;
											
											if(preg_match("/([%\$<#\*]+)/", $_POST['NewcontactNumber'])){
											   	$message= "<br> do not put any special characters";
											}
											else
											{
											  $NewcontactNumber = $_POST['NewcontactNumber'];	
											}
											if(preg_match("/([%\$<#\*]+)/", $_POST['NewfirstName'])){
											   	$message= "<br> do not put any special characters";
											}
											else
											{
											  $NewfirstName = $_POST['NewfirstName'];	
											}
											if(preg_match("/([%\$<#\*]+)/", $_POST['NewlastName'])){
											   	$message= "<br> do not put any special characters";
											}
											else
											{
											  $NewlastName = $_POST['NewlastName'];	
											}
											if(preg_match("/([%\$<#\*]+)/", $_POST['Newusername'])){
											   	$message= "<br> do not put any special characters";
											}
											else
											{
											  $Newusername = $_POST['Newusername'];	
											}
											
										
							
											$query1="update users 
														set firstName = '$NewfirstName', lastName = '$NewlastName', 
														username = '$Newusername'	,email = '$Newemail'	, contactNumber = '$NewcontactNumber',
														branchID = $Newbranch	, userTypeID = $NewuserType												
														where userID = '$userID'";
															
																 
												$result=mysqli_query($dbc,$query1);
												if (!isset($message)) {
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
									
									if(preg_match("/([%\$<#\*]+)/", $_POST['username'])){
										$message.= "<p> do not put any special characters";
									}
									else
									{
										$username = $_POST['username'];	
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
								$firstName = null;
								$lastName = null;
								$email = $_POST['email'];
								$contactNumber = $_POST['contactNumber'];
								if(preg_match("/([%\$<#\*]+)/", $_POST['firstName'])){
									$message= "<br> do not put any special characters";
								}
								else
								{
									$firstName = $_POST['firstName'];	
								}
								if(preg_match("/([%\$<#\*]+)/", $_POST['lastName'])){
									$message= "<br> do not put any special characters";
								}
								else
								{
									$lastName = $_POST['lastName'];	
								}
									if(preg_match("/([%\$<#\*]+)/", $_POST['lastName'])){
									$message= "<br> do not put any special characters";
								}
								else
								{
									$lastName = $_POST['lastName'];	
								}
								
								if(!isset($message)){
									echo "<meta http-equiv='refresh' content='2'>"; //refresh page
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
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
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
	<script src="../dist/js/jquery.searchabledropdown-1.0.8.min.js"></script>
	
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	
		<script> 
		$(document).ready(function(){
			$('#usertable').DataTable({
				ordering: false
			});
		});
		</script>
		<script> 
				$(document).ready(function() {
			$('#newBranch').searchable({
				maxListSize: 100,                       // if list size are less than maxListSize, show them all
				maxMultiMatch: 50,                      // how many matching entries should be displayed
				exactMatch: false,                      // Exact matching on search
				wildcards: true,                        // Support for wildcard characters (*, ?)
				ignoreCase: true,                       // Ignore case sensitivity
				latency: 200,                           // how many millis to wait until starting search
				warnMultiMatch: 'top {0} matches ...',  // string to append to a list of entries cut short by maxMultiMatch
				warnNoMatch: 'no matches ...',          // string to show in the list when no entries match
				zIndex: 'auto'                          // zIndex for elements generated by this plugin
			});
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
