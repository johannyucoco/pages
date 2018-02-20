<!DOCTYPE html>
<html lang="en">
<?php session_start(); 
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
        <nav class="navbar navbar-default navbar-static-top" role="navigation"  style="margin-top: 0 ; background-color:black">
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
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['username'];?></a>
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
                            <!-- /input-group -->
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw" style="color:black"></i> Home</a>
                        </li>
                            <li>
                            <a href="#"><i class="fa fa-wrench fa-fw" style="color:black"></i> Tools<span class="fa arrow" style="color:black"></span></a>
                            <ul class="nav nav-second-level">
                               <li>
                                    <a href="addsensortype.php">Add Sensor Type</a>
                                </li>
								<li>
                                    <a href="sensorTypePage.php">Edit Status Details</a>
                                </li>
								<li>
                                    <a href="displayuser.php">Display Users</a>
                                </li>
                            </ul>
							 <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw" style="color:black"></i> Branches<span class="fa arrow" style="color:black"></span></a>
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
									<a href='roomslist.php?branchID='.$branchID.'&branchname='.$branchname.'>$branchname </a>
                                </li>";
						}
								?>
							
                            </ul>
							<li>
                            <a href="#"><i class="fa fa-archive fa-fw" style="color:black"></i> Manage Data<span class="fa arrow" style="color:black"></span></a>
                            <ul class="nav nav-second-level">
                               <li>
                                    <a href="listroom.php">View Rooms</a>
                                </li>
								<li>
                                    <a href="listbranch.php">View Branches</a>
                                </li>
								<li>
                                    <a href="listrpi.php">View Raspberry Pis</a>
                                </li>
								<li>
                                    <a href="listsensor.php">View Sensors</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
						<li>
						<a href="logout.php"><i class="fa fa-sign-out fa-fw" style="color:black"></i> Logout</a>
						</li>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Users <a data-toggle="modal"  data-target="#Modal" class="btn btn-info">+</a></h3>
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
																		<input required name="newbranchName"class="form-control" placeholder="User Name" ">
																		<br>
																		<input required type="password" name="newPassword"class="form-control" placeholder="Password" ">
																		<br>
																		<label>User Type</label>
																				<select name= "userType" class="form-control">
																	
																			';
																			$query1= "select * from usertype;"; // Run your query
																			$result1=mysqli_query($dbc,$query1);
																			echo "<option value='default'> select </option>"; 
																			while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
																			$userType = $row['userType'];
																			$id = $row['userTypeID'];
																			echo "<option value=". $id .">".$userType."</option>";
																			}
																echo'
																		</select>
																		<br>
																</div>
																<div class="modal-footer">
																
																  <button type="submit" class="btn btn-default btn-info" name="add" >Confirm</button>
																  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																</div>
															  </div>
															</div>
														  </div>
														</form>
													</div>
												';

					$sql = "SELECT *
							  from users u join usertype t on u.userTypeID = t.userTypeID
											join branches b on u.branchID = b.branchID
											join usertype r on u.userTypeID = r.userTypeID";
						
					$result = mysqli_query($dbc,$sql);
					
					echo 	
							'
							<table class="table table-stipend table-bordered table-hover" id="usertable">
							<thead>
								<tr>
								<th class="text-center">User Name</th>
								<th class="text-center">User Type</th>
								<th class="text-center">Branch</th>
								
								</tr>
							</thead>
							<tbody>
							
							';
					
					while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
											
						
						echo 
							"
							<tr>
								<td class='text-center'> {$row['username']} </td>
								<td class='text-center'> {$row['branchname']} </td>
								<td class='text-center'> {$row['userType']} </td>
							</tr>
							";
					}
					
					echo '</tbody> </table>';
					
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
