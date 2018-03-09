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

    <title>Home</title>

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
                <div class="col-lg-12">
                    <h3 class="page-header">Dashboard</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<div class="row">
				<div class="clearfix"></div>
				<div class="col-lg-3">
					<div class="row">
						<ul class="list-group">
						<?php
						$sql = "SELECT sn.sensorName as sensorName, st.timestamp as timestamp
														from sensors sn
															join status st
														on sn.sensorID = st.sensorID
                                                        group by sensorName
                                                        ORDER BY timestamp DESC";
														
						$result = mysqli_query($dbc,$sql);
						while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$sensorName = $row['sensorName'];
							$timestamp = strtotime($row['timestamp']);
							$date = strtotime(date('Y-m-d H:i:s'));
							$datediff = $date - $timestamp;
							
							if(round($datediff / (60 * 60 * 24)) <= 2){
								echo'<li class="list-group-item">'.$sensorName.'<span class="pull-right"><i class="fa fa-bullseye fa-fw" style = "color:green"></i></span></li>';
							}
							else {
								echo'<li class="list-group-item">'.$sensorName.'<span class="pull-right"><i class="fa fa-bullseye fa-fw" style = "color:red"></i></span></li>';
							}
						}
						?>

							
						</ul>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="row">
			<?php 
			//Loop per Branch 
			
			$sql = "SELECT * from branches where status = 0";
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
					
				echo'	<div class="col-lg-4">
							<div class="panel panel-primary"  >
								<div class="panel-heading" style="background-color:black">
									<div class="row" >
										<div class="col-xs-3" >
											<i class="fa fa-building fa-5x"> </i>
										</div>
										<div class="col-xs-9 text-right">';		
								if($row1){
											echo '<div class="huge">'.$row1['num'].'</div>';
									}else {
											echo' <div class="huge"> 0 </div>';
									} 
										echo'	<div>Rooms</div>
										</div>
									</div>
								</div>
								<a href="roomslist.php?branchID='.$branchID.'&branchname='.$branchname.'">
									<div class="panel-footer">
										<span class="pull-left">'.$branchname.'</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>	
						</div>';
				}
				?>
				</div>
				<!-- /.col-md-6 -->
				</div>
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