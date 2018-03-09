

 <!DOCTYPE html>
<html lang="en">
<?php
 session_start();

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

    <title>View Branches</title>

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
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css"></link>
	
  


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
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
                                <div class="col-lg-2">
								</div>
								<div class="col-lg-8">


								<h3>Branches <a data-toggle="modal"  data-target="#Modal"><span role="button"><i class="fa fa-plus-square fa-fw" style="color:black"></i></span></a> </h3> 
									<?php
									echo
												'
													<div class="modal fade" id="Modal" role="dialog">
														<form action="'.$_SERVER['PHP_SELF'].'" method="post">
															<div class="modal-dialog modal-lg">
															  <div class="modal-content">
																<div class="modal-header">
																  <button type="button" class="close" data-dismiss="modal">&times;</button>
																  <h4 class="modal-title">Add Branch</h4>
																</div>
																<div class="modal-body">
																  <div class="form-group">
																	<input type="hidden" name="branchID" value="<?php echo $branchID; ?>" /> 
																		<input required name="branchName"class="form-control" placeholder="Branch Name" ">
																		<input name="branchID" class="form-control hidden" placeholder="Edit Branch Name" ">
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
									
									
										echo 	
												'
												<table class="table table-striped table-bordered table-hover" id="branchtable">
												<thead>
													<tr>
												
													<th class="text-center">Name</th>
													<th class="text-center">Rooms</th>
													<th class="text-center"><i class="fa fa-edit fa-fw" style="color:black"></i></th>
													<th class="text-center"><i class="fa fa-trash-o fa-fw" style="color:black"></i></th>
													
													</tr>
												</thead>
												<tbody>
												
												';
										$sql = "SELECT b.branchID, branchname
												  from branches b 
												  where b.status = 0
                                                  group by b.branchID";
											// join rooms r 
											//	  on r.branchID = b.branchID
											//, count(roomID) as num
										$result = mysqli_query($dbc,$sql);
										
										while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
											$branchID = $row['branchID'];
											$branchname = $row['branchname'];
											//$num = $row['num'];
											$sql1 = "SELECT count(r.roomID) as num from branches b join rooms r 
												on b.branchID = r.branchID
										where b.status = 0 and b.branchID= {$branchID}
                                                  group by b.branchID";
										
											$result1 = mysqli_query($dbc,$sql1);
											$row1=mysqli_fetch_array($result1,MYSQLI_ASSOC);
											
											echo 
												'
												<tr class="clickable-row" href="index.php">
												
													<td class="text-center"><a href="roomslist.php?branchID='.$branchID.'&branchname='.$branchname.'"><font color="blue">'.$branchname.'</font></span></a></td>
													';
													if($row1){
																echo'<td class="text-center"> '.$row1['num'].'</td>';
													}else{
														echo'<td class="text-center"> 0</td>';
													}
													echo'
													<td class="text-center"><a data-toggle="modal" data-target="#myModal'.$branchID.'" ><span role="button"> <i class="fa fa-edit fa-fw" style="color:blue"></i></span></td>
													<td class="text-center"><a data-toggle="modal" data-target="#myModald'.$branchID.'" ><span role="button"> <i class="fa fa-trash-o fa-fw" style="color:blue"></span></i></td>
													
													
												</tr>
												';
												
												
												echo
												'
													<div class="modal fade" id="myModal'.$branchID.'" role="dialog">
														<form action="'.$_SERVER['PHP_SELF'].'" method="post">
															<div class="modal-dialog modal-lg">
															  <div class="modal-content">
																<div class="modal-header">
																  <button type="button" class="close" data-dismiss="modal">&times;</button>
																  <h4 class="modal-title">Edit Branch</h4>
																</div>
																<div class="modal-body">
																  <div class="form-group">
																	<input type="hidden" name="branchID" value="<?php echo $branchID; ?>" /> 
																		<input required name="newbranchName"class="form-control" placeholder="Edit Branch Name" value="'.$branchname.'">
																		<input name="branchID" class="form-control hidden" placeholder="Edit Branch Name" value="'.$branchID.'">
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
													<div class="modal fade" id="myModald'.$branchID.'" role="dialog">
														<form action="'.$_SERVER['PHP_SELF'].'" method="post">
															<div class="modal-dialog modal-lg">
															  <div class="modal-content">
																<div class="modal-header">
																  <button type="button" class="close" data-dismiss="modal">&times;</button>
																  <h4 class="modal-title">Delete this branch?</h4>
																</div>
																<div class="modal-body">
																  <div class="form-group">
																	<input type="hidden" name="branchID" value="<?php echo $branchID; ?>" /> 
																		<input disabled name="dnewbranchName" class="form-control" placeholder="Edit Branch Name" value="'.$branchname.'"><br>
																		<input  name="dbranchID" class="form-control hidden" placeholder="Delete Branch Name" value="'.$branchID.'">
																		
																		<b>*All rooms inside this branch will also be deleted</b>';
																		
																	
											echo'
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
									
									

										
										require_once('mysteryDB_connect.php');
										
										
										//AFTER BUTTON PRESS 
										if (isset($_POST['submit'])){
											
											$message=NULL;
											
												 
											 if (isset($_POST['branchID'])){
												$branchID = $_POST['branchID'];
											}
											else{
												$branchID = -1;
											}
											
											$newbranchName = $_POST['newbranchName'];		  
											
											
											$query1="update branches	
														set branchname = '$newbranchName'
														where branchID = $branchID";
																  
																  
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
															<strong>Success!</strong> Success Editing '.$newbranchName.' branch.
														</div>
												
														';
														
												}
												else{
													echo'
														<div class="alert alert-danger">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Error!</strong> Did not change name to '.$newbranchName.' branch.
														</div>
														';
												}	
										}
										
										if(isset($_POST['delete'])){
											
										
											$branchID = $_POST['dbranchID'];
										
											$query="select roomID from rooms where branchID = $branchID";
											$result=mysqli_query($dbc,$query);
											while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
													$query1="update rooms	
														set status = 1
														where roomID = {$row['roomID']}";
				
													$result=mysqli_query($dbc,$query1);
												
											}
											
											$query1="update branches	
														set status = 1
														where branchID = $branchID";
																  
																  
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
															<strong>Success!</strong> branch deleted.
														</div>
												
														';
														
												}
												else{
													echo'
														<div class="alert alert-danger">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Error!</strong> No change occured to branch.
														</div>
														';
												}	
											
											
											
											
											
										}
										if (isset($_POST['add'])){
							
											$message=NULL;
							
								
									

											$branchName = $_POST['branchName'];
								
										
											
								
										if(!isset($message)){
												echo "<meta http-equiv='refresh' content='2'>"; //refresh page
												$query1="insert into branches(branchName) values ('$branchName')";
												$result=mysqli_query($dbc,$query1);
											echo'
											<div class="alert alert-success">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong>Success!</strong> New Branch Added.
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
									
									
									<!-- Modal -->
										  
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
	
	
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
	
		<script> 
		$(document).ready(function(){
			$('#branchtable').DataTable({
				ordering: false
			});
			
		});
		</script>
		<script> 
		$(document).ready(function(){
			$(".clickable-row")click(function(){}
				
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
