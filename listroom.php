<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if($_SESSION['userTypeID'] != 1) {
	 header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/logout.php");
}





?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View Rooms</title>

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
									echo "
											<li>
											<a href='roomslist.php?branchID='.$branchID.'&branchname='.$branchname.'><font color=\"white\"><i class=\"fa fa-arrow-circle-right\"></i> $branchname</font></a>
											</li>";
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
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-1">
								</div>
								<div class="col-lg-10">
								<h3>Rooms <a data-toggle="modal"  data-target="#Modal"><span role="button"><i class="fa fa-plus-square fa-fw" style="color:black"></i></span></a> </h3>
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
																  <h4 class="modal-title">Add Room</h4>
																</div>
																<div class="modal-body">
																  <div class="form-group">
																	<input type="hidden" name="branchID" value="<?php echo $branchID; ?>" /> 
																		<input required name="roomName"class="form-control" placeholder="Room Name" ">
																		<br>
																		<input required name="roomDescription"class="form-control" placeholder="Room Description" ">
																		
																		<br>
																		<label>Branch</label>
																				<select name= "branch" class="form-control" id="branchie">
																	
																			';
																			$query1= "select * from branches where status =0"; // Run your query
																			$result1=mysqli_query($dbc,$query1);
																			echo "<option value='default'> -select- </option>"; 
																			while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
																			$branch = $row['branchname'];
																			$id = $row['branchID'];
																			echo "<option value=". $id .">".$branch."</option>";
																			}
																echo'
																		</select>
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
												
											$sql = "SELECT r.roomID as roomID, r.roomName as roomName, r.roomDescription as roomDescription, b.branchname as branchname, r.status as status,b.branchID as branchID
												  from rooms r join branches b
															on r.branchID = b.branchID where r.status = 0";
													 
											//echo '<h1 class="page-header">Rooms'."".$roomName.'</h1>':		 
												
											$result = mysqli_query($dbc,$sql);
											
											echo 	
													'
													<table class="table table-striped table-bordered table-hover" id="roomtable">
													<thead>
														<tr>
													
														<th class="text-center">Name</th>
														<th class="text-center">Description</th>
														<th class="text-center">Branch</th>
														<th class="text-center">Rpi</th>
														<th class="text-center"><i class="fa fa-edit fa-fw" style="color:black"></i></th>
														<th class="text-center"><i class="fa fa-trash-o fa-fw" style="color:black"></i></th>
														
														</tr>
													</thead>
													<tbody>
													
													';
											
											while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
												$roomID = $row['roomID'];
												$roomName = $row['roomName'];
												$roomDescription = $row['roomDescription'];	
												$branchname = $row['branchname'];	
												$branchID = $row['branchID'];												
												// <tr class='clickable-row' data-href='url:index.php'>
												$sql1 = "SELECT count(i.rpiID) as num from rooms r join rpi i 
												on r.roomID = i.roomID 
											where r.status = 0 and r.roomID= '{$roomID}' 
												group by r.roomID";	
										
											$result1 = mysqli_query($dbc,$sql1);
											$row1=mysqli_fetch_array($result1,MYSQLI_ASSOC);
												echo 
													'
													<tr>
												
														<td class="text-center"><a href="rpilist.php?roomID='.$roomID.'&roomName='.$roomName.'"><span role="button"><font color="blue">'.$roomName.'</font></span></a></td>
														<td class="text-center">'.$roomDescription.'</td>
														<td class="text-center">'.$branchname.'</td>';
														
														if($row1){
																echo'<td class="text-center"> '.$row1['num'].'</td>';
														}else{
															echo'<td class="text-center"> 0</td>';
														}
														echo'
														<td class="text-center"><a data-toggle="modal" data-target="#myModal'.$roomID.'" ><span role="button"> <i class="fa fa-edit fa-fw" style="color:blue"></span></i></a></td>
														<td class="text-center"><a data-toggle="modal" data-target="#myModald'.$roomID.'" ><span role="button"> <i class="fa fa-trash-o fa-fw" style="color:blue"></span></i></td>
													</tr>
													';
													
													echo
													'
														<div class="modal fade" id="myModal'.$roomID.'" role="dialog">
															<form action="'.$_SERVER['PHP_SELF'].'" method="post">
																<div class="modal-dialog modal-lg">
																  <div class="modal-content">
																	<div class="modal-header">
																	  <button type="button" class="close" data-dismiss="modal">&times;</button>
																	  <h4 class="modal-title">Edit Room</h4>
																	</div>
																	<div class="modal-body">
																	  <div class="form-group">
																		<input type="hidden" name="roomID" value="<?php echo $roomID; ?>" /> 
																			<input required name="newRoomName"class="form-control" placeholder="Edit Room Name" value="'.$roomName.'"><br>
																			<input required name="newDescription"class="form-control" placeholder="Edit Room Description" value="'.$roomDescription.'"><br>
																		<select name="branch" class="form-control">';
																			
												
																				$query1= "select * from branches where status = 0"; // Run your query
																				$result1=mysqli_query($dbc,$query1);
																				while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
																					$branchName = $row['branchname'];
																					$id = $row['branchID'];
																					echo "<option value=".$id."";
																					if($id == $branchID){ echo" selected";};
																					echo ">".$branchName."</option>";
																				
																				}
																			
																		
																		echo '
																		</select>
																			
																			<input required name="roomID" class="form-control hidden" placeholder="Room ID" value="'.$roomID.'">
																			<br>
																	</div>
																	<div class="modal-footer">
																	
																	  <button type="submit" class="btn btn-default btn-info" name="confirm" >Edit</button>
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
														<div class="modal fade" id="myModald'.$roomID.'" role="dialog">
															<form action="'.$_SERVER['PHP_SELF'].'" method="post">
																<div class="modal-dialog modal-lg">
																  <div class="modal-content">
																	<div class="modal-header">
																	  <button type="button" class="close" data-dismiss="modal">&times;</button>
																	  <h4 class="modal-title">Delete this room?</h4>
																	</div>
																	<div class="modal-body">
																	  <div class="form-group">
																		<input type="hidden" name="roomID" value="<?php echo $roomID; ?>" /> 
																			<input disabled name="newbranchName"class="form-control" placeholder="Delete Room Name" value="'.$roomName.'"><br>
																			<input disabled name="newbranchName"class="form-control" placeholder="Delete Room Description" value="'.$roomDescription.'"><br>
																			<input disabled name="newbranchName"class="form-control" placeholder="Delete Branch Name" value="'.$branchname.'">
																			<input  name="roomID" class="form-control hidden" placeholder="Room ID" value="'.$roomID.'">
																			<br>
																	</div>
																	<div class="modal-footer">
																	
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
										if (isset($_POST['confirm'])){
											
											$message=NULL;
											
												 
											 if (isset($_POST['roomID'])){
												$roomID = $_POST['roomID'];
											}
											else{
												$branchID = -1;
											}
											
											$newRoomName = $_POST['newRoomName'];
											$newDescription = $_POST['newDescription'];
											$branch = $_POST['branch'];
											$query1="update rooms	
														set roomName = '$newRoomName', roomDescription = '$newDescription',branchId ='$branch'														
														where roomID = $roomID";
															
																  
												$result=mysqli_query($dbc,$query1);
												if ($result) {
														echo "<meta http-equiv='refresh' content='2'>"; //refresh page
														
													/*	echo "<meta http-equiv='refresh' content='0'>"; //refresh page
													echo'<script>
															window.href = "listbranch.php";
														</script>
														'; */
														
													echo'
														<div class="alert alert-success">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Success!</strong> Success Editing '.$newRoomName.' branch.
														</div>
												
														';
														
												}
												else{
													echo'
														<div class="alert alert-danger">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Error!</strong> Did not change name to '.$newRoomName.' branch.
														</div>
														';
												}	
										}
										
										if(isset($_POST['delete'])){
											
											
											
											$roomID = $_POST['roomID'];
									
											$query1=" update rooms	
														set status = 1
														where roomID = $roomID";
																  
																  
												$result=mysqli_query($dbc,$query1);
												if ($result) {
														echo "<meta http-equiv='refresh' content='2'>"; //refresh page
															
													/*	echo "<meta http-equiv='refresh' content='0'>"; //refresh page
													echo'<script>
															window.href = "listbranch.php";
														</script>
														';*/
														
													echo'
														<div class="alert alert-success">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Success!</strong> Room deleted.
														</div>
															';								
										
														
												}
												else{
													echo'
														<div class="alert alert-danger">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Error!</strong> No change occured to room.
														</div>
														';
												}	
											
											
											
											
											
										}
										
								if (isset($_POST['add'])){
							
											$message=NULL;
							
								
									
											if($_POST['branch']== 'default'){
												 $message .= '<p>Empty branch';
												 $branchID=FALSE;
											}else $branchID = $_POST['branch'];

											$roomName = $_POST['roomName'];
											$roomDescription = $_POST['roomDescription'];
										
											
								
										if(!isset($message)){
											
												$query1="insert into rooms(roomName,roomDescription,branchID) values ('$roomName','$roomDescription','$branchID')";
												$result=mysqli_query($dbc,$query1);
											echo'
											<div class="alert alert-success">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong>Success!</strong> Room Added.
											</div>';
												echo "<meta http-equiv='refresh' content='2'>"; //refresh page
																			
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
							//end of after button press 
										
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
			$('#roomtable').DataTable({
				ordering: false,
				 scrollCollapse: true
			});
		});
		
		
		</script>
		<script> 
			$(document).ready(function(){
			$('#branchie').editableSelect()
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
