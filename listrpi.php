<!DOCTYPE html>
<?php session_start();
if($_SESSION['userTypeID'] != 1) {
	 header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/logout.php");
}
$_SESSION['from'] =3;
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View Raspberry Pis</title>

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
									<a href=\"roomslist.php?branchID={$branchID}&branchname= {$branchname}\"><font color=\"white\"><i class=\"fa fa-arrow-circle-right\"></i> $branchname <span class=\"pull-right\">{$row1['num']} </font></span></a>
											</li>";
									}else{
										echo "
											<li>
											<a href=\"roomslist.php?branchID={$branchID}&branchname= {$branchname}\"><font color=\"white\"> <i class=\"fa fa-arrow-circle-right\"></i> $branchname <span class=\"pull-right\">0 </span></font></a>
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
								
								<h3>Raspberry Pis <a data-toggle="modal"  data-target="#Modal"><span role="button"><i class="fa fa-plus-square fa-fw" style="color:black"></i>	</span></a> </h3>
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
																  <h4 class="modal-title">Add RPi</h4>
																</div>
																<div class="modal-body">
																  <div class="form-group">
																	<input type="hidden" name="branchID" value="<?php echo $branchID; ?>" /> 
																		<input required name="rpi"class="form-control" placeholder="Raspberry Pi Name" ">
																		<br>
																		<input required name="ipAddress"class="form-control" placeholder="IP Address" ">
																		<br>
																		<label>Room</label>
																		<select name="room" class="form-control" id="rooms">';
																				$query1= "select * from rooms where status = 0"; // Run your query
																				$result1=mysqli_query($dbc,$query1);
																				echo "<option value='default'> -select- </option>"; 
																				while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
																					$roomName = $row['roomName'];
																					$id = $row['roomID'];
																				
																					echo "<option value=". $id .">".$roomName."</option>";
																				}
																			
																		echo '</select>

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
										$sql = "SELECT * 
												 FROM rpi  
														where rpi.status = 0";
										$result = mysqli_query($dbc,$sql);
										
										echo 	
												'
												<table class="table table-striped table-bordered table-hover" id="rpitable">
												<thead>
													<tr>
													
													<th class="text-center">Name</th>
													<th class="text-center">IP Address</th>
													<th class="text-center">Room</th>
													<th class="text-center"><i class="fa fa-edit fa-fw" style="color:black"></i></th>
													<th class="text-center"><i class="fa fa-trash-o fa-fw" style="color:black"></i></th>
													</tr>
												</thead>
												<tbody>
												
												';
										
										while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
											$rpiID = $row['rpiID'];
											$rpiName = $row['rpiName'];
											$ipAddress = $row['ipAddress'];	
											
											$roomID = $row['roomID'];
											
											$sql1 = "SELECT *
												 FROM rooms
												where status = 0 and roomID = {$roomID}";
											$result1 = mysqli_query($dbc,$sql1);
											if($result1){
												$row1=mysqli_fetch_array($result1,MYSQLI_ASSOC);
												$roomName = $row1['roomName'];
											}else{
												$roomName = "N/A";
											} 
											$null=null;
											// <tr class='clickable-row' data-href='url:index.php'>
											echo 
												'
												<tr>
													
													<td class="text-center"><a href="rpilist.php?roomID='.$roomID.'&roomName='.$roomName.'"><span role="button"><font color="blue">'.$rpiName	.'</font></span></a></td>
													<td class="text-center">'.$ipAddress.'</td>
													<td class="text-center">'.$roomName.'</td>
													<td class="text-center"><a data-toggle="modal" data-target="#myModal'.$rpiID.'" ><span role="button"><i class="fa fa-edit fa-fw" style="color:blue"></span></i></a></td>
													<td class="text-center"><a data-toggle="modal" data-target="#myModald'.$rpiID.'" ><span role="button"><i class="fa fa-trash-o fa-fw" style="color:blue"></span></i></td>
												</tr>
												';
											echo
													'
														<div class="modal fade" id="myModal'.$rpiID.'" role="dialog">
															<form action="'.$_SERVER['PHP_SELF'].'" method="post">
																<div class="modal-dialog modal-lg">
																  <div class="modal-content">
																	<div class="modal-header">
																	  <button type="button" class="close" data-dismiss="modal">&times;</button>
																	  <h4 class="modal-title">Edit Rpi</h4>
																	</div>
																	<div class="modal-body">
																	  <div class="form-group">
																		<input type="hidden" name="rpiID" value="<?php echo $rpiID; ?>" /> 
																			<b>Name:</b>
																			<input required name="rpiName"class="form-control" placeholder="Edit Rpi Name" value="'.$rpiName.'"><br>
																			<b>IPAddress:</b>
																			<input required  name="ipAddress"class="form-control" placeholder="Edit Ip Address" value="'.$ipAddress.'"><br>
																				<b>Room:</b>
																				<select name="room" class="form-control">';
																			
												
																				$query1= "select * from rooms where status = 0"; // Run your query
																				$result1=mysqli_query($dbc,$query1);
																				while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
																					$roomName = $row['roomName'];
																					$id = $row['roomID'];
																					
																					echo "<option value=".$id."";
																					if($id == $roomID ){ echo" selected";};
																					echo ">".$roomName."</option>";
																					
																					
																					
																				}
																			
																					if($roomName == "Null"){
																							echo'<option selected  value='.$null.' >N/A</option>';	
																					}else{
																							echo'<option value='.$null.'>N/A</option>';
																					}
																					
																			
																		echo '</select>
																			
																			<input name="rpiID" class="form-control hidden" placeholder="Room ID" value="'.$rpiID.'">
																			<br>
																	</div>
																	<div class="modal-footer">
																	
																	  <button type="submit" class="btn btn-default btn-info" name="submit" >Edit</button>
																	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	</div>
																  </div>
																</div>
															  </div>
															</form>
														</div>
													';
													echo
													'
														<div class="modal fade" id="myModald'.$rpiID.'" role="dialog">
															<form action="'.$_SERVER['PHP_SELF'].'" method="post">
																<div class="modal-dialog modal-lg">
																  <div class="modal-content">
																	<div class="modal-header">
																	  <button type="button" class="close" data-dismiss="modal">&times;</button>
																	  <h4 class="modal-title">Delete this Raspberry Pi?</h4>
																	</div>
																	<div class="modal-body">
																	  <div class="form-group">
																		<input type="hidden" name="rpiID" value="<?php echo $rpiID; ?>" /> 
																			<input disabled name="newbranchName"class="form-control" placeholder="Delete Rpi Name" value="'.$rpiName.'"><br>
																			<input disabled name="newbranchName"class="form-control" placeholder="Delete Ip Address" value="'.$ipAddress.'"><br>
																			';
																				$query1= "select * from rooms where status = 0 and roomID = '$roomID'"; // Run your query
																			
																				if ($result1=mysqli_query($dbc,$query1)) {
																					$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
																					$roomName = $row['roomName'];
																					$id = $row['roomID'];
																					
																					
																					
																					if($roomName != null){ echo' 	
																					<input disabled name="newbranchName"class="form-control" placeholder="Delete Room Name" value="'.$roomName.'"><br>';
																					}
																					else {
																					 echo' 	
																					<input disabled name="newbranchName"class="form-control" placeholder="Delete Room Name" value="Null"><br>';
																		
																				}
																				}
																				
																		echo'
																			
																			<input  name="brpiID" class="form-control hidden" placeholder="Room ID" value="'.$rpiID.'">
																			<br>
																	</div>
																	<div class="modal-footer">
																		<b>*All sensors inside the chosen RPI will also be unassigned</b>
																	
																	  <button type="submit" class="btn btn-default btn-info" name="delete" >Delete</button>
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
									//AFTER BUTTON PRESS 
										if (isset($_POST['submit'])){
											
											$message=NULL;
											
												 
											 if (isset($_POST['rpiID'])){
												$rpiID = $_POST['rpiID'];
												
											}
											else{
												$rpiID = -1;
											}
											
											$rpiName = null;
											$ipAddress = null;
											
											if(preg_match("/([%\$<#\*]+)/", $_POST['rpiName'])){
											   	$message= "<br> do not put any special characters";
											}
											else
											{
											  $rpiName = $_POST['rpiName'];
											}
											if(preg_match("/([%\$<#\*]+)/", $_POST['ipAddress'])){
											   	$message= "<br> do not put any special characters";
											}
											else
											{
											  $ipAddress = $_POST['ipAddress'];
											}

												$query1="update rpi	
														set rpiName = '$rpiName', ipAddress = '$ipAddress', roomID='$room'
														where rpiID = $rpiID";
															  
																  
												$result=mysqli_query($dbc,$query1);
												if($room == null){
												
													$query2="update rpi	
														set roomID= NULL
														where rpiID = $rpiID";
															  
																  
												$result2=mysqli_query($dbc,$query2);
													
												}
												if (!isset($message)) {
														echo "<meta http-equiv='refresh' content='2'>"; //refresh page
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
															<strong>Success!</strong> Success Editing '.$rpiName.' rpi.
														</div>
												
														';
														
												}
												else{
													echo'
														<div class="alert alert-danger">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Error!</strong> Did not change '.$rpiName.' rpi.
														</div>
														';
												}	
										}
										
										if(isset($_POST['delete'])){
											
										
											$rpiID = $_POST['brpiID'];
											
											$query1="select * from sensors where rpiID = $rpiID";
											$result1=mysqli_query($dbc,$query1);
											while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
													$query1="update sensors	
														set rpiID = null
														where sensorID = {$row['sensorID']}";
				
													$result=mysqli_query($dbc,$query1);
												
											}
											
											$query1="update rpi	
														set status = 1
														where rpiID = $rpiID";
																  
																  
												$result=mysqli_query($dbc,$query1);
												if ($result) {
														echo "<meta http-equiv='refresh' content='2'>"; //refresh page
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
															<strong>Success!</strong> Rpi deleted.
														</div>
												
														';
														
												}
												else{
													echo'
														<div class="alert alert-danger">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Error!</strong> No change occured to Rpi.
														</div>
														';
												}	
											
											
											
											
											
										}
										
										if (isset($_POST['add'])){
							
											$message=NULL;
							
											if($_POST['room'] == 'default'){
												 $message .= '<p>Empty room';
												 $roomID=FALSE;
											}else $roomID = $_POST['room'];
											
											
											$rpi = null;
											$ipAddress = null;
											
											
											if(preg_match("/([%\$<#\*]+)/", $_POST['rpi'])){
											   	$message= "<br> do not put any special characters";
											}
											else
											{
											  $rpi =$_POST['rpi'];	
											}
											if(preg_match("/([%\$<#\*]+)/", $_POST['ipAddress'])){
											   	$message= "<br> do not put any special characters";
											}
											else
											{
											  $ipAddress =$_POST['ipAddress'];	
											}
										
											
										
											
								
										if(!isset($message)){
												echo "<meta http-equiv='refresh' content='2'>"; //refresh page
													$query1="insert into rpi(rpiName,ipAddress,roomID) values ('$rpi','$ipAddress','$roomID')";
													$result=mysqli_query($dbc,$query1);
											echo'
											<div class="alert alert-success">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong>Success!</strong> New RPI Added.
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

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
		
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	
		<script> 
		$(document).ready(function(){
			$('#rpitable').DataTable({
				ordering: false
			});
		});
		</script>
		
		<script> 
			$(document).ready(function(){
			$('#rooms').editableSelect()
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
