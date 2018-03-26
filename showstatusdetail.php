
<!DOCTYPE html>
<?php session_start();?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Show Status Details</title>

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
               	<?php
					if($_SESSION['userTypeID'] == 1) {
				
					echo '<a class="navbar-top" href="index.php" >&nbsp <img src="logo2.jpg"></a>';
					}if($_SESSION['userTypeID'] == 2) {
						
						echo '<a class="navbar-top" href="indexGamemaster.php" >&nbsp <img src="logo2.jpg"></a>';
					}
				?>
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
                            <!-- /input-group -->
                      <?php
							if($_SESSION['userTypeID'] == 1) {
	
								echo "
								<li>
									<a href=\"index.php\"><i class=\"fa fa-home fa-fw\" style=\"color:white\"><font color=\"white\"></i> Home </font></a>
								</li>
								
								
								
										
							<li>
								<a href=\"#\"><i class=\"fa fa-archive fa-fw\" style=\"color:white\"></i><font color=\"white\"> Manage Data </font><span class=\"fa arrow\" style=\"color:white\"></span></a>
								<ul class=\"nav nav-second-level\">
								<li>
                                    <a href=\"listbranch.php\"><font color=\"white\"> View Branches </font></a>
                                </li>
								<li>
                                    <a href=\"listroom.php\"><font color=\"white\"> View Rooms </font></a>
                                </li>
								
								<li>
                                    <a href=\"listrpi.php\"><font color=\"white\"> View Raspberry Pis </font></a>
                                </li>
								<li>
                                    <a href=\"listsensor.php\"><font color=\"white\"> View Sensors </font></a>
                                </li>
								<li>
                                <a href=\"displayuser.php\"><font color=\"white\"> View Users </font></a>
								</li>
								</ul>
							<li>
								<li>
								<a href=\"#\"><i class=\"fa fa-sitemap fa-fw\" style=\"color:white\"></i><font color=\"white\"> Branches </font><span class=\"fa arrow\" style=\"color:white\"></span></a>
								<ul class=\"nav nav-second-level\">
								
								
								";require_once('mysteryDB_connect.php');
									$sql = "SELECT *
											from branches where status = 0";
									$result = mysqli_query($dbc,$sql);
									while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
										$branchID = $row['branchID'];
										$branchname = $row['branchname'];	
									echo "
											<li>
											<a href=\"roomslist.php?branchID={$branchID}&branchname= {$branchname}\"><font color=\"white\"><i class=\"fa fa-arrow-circle-right\"></i> $branchname</font></a>
											</li>
										";
									}
								
							}
								  if($_SESSION['userTypeID'] == 2){
						echo '
								<li>
									<a href="indexGamemaster.php"><i class="fa fa-home fa-fw" style="color:white"><font color="white"></i> Home </font></a>
								</li>';
									echo' <li>
								<a href="#"><i class="fa fa-sitemap fa-fw" style="color:white"></i><font color="white"> Rooms </font><span class="fa arrow" style="color:white"></span></a>
								<ul class="nav nav-second-level">';
							
									require_once('mysteryDB_connect.php');
									$sql = "SELECT *
											from rooms where status = 0 and branchID = {$_SESSION['branchID']}";
									$result = mysqli_query($dbc,$sql);
									while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
										$roomID = $row['roomID'];
										$roomName = $row['roomName'];	
									echo '
											<li>
											</td>
											<a href="rpilist.php?roomID='.$roomID.'&roomName='.$roomName.'"><font color="white"><i class="fa fa-arrow-circle-right"></i>&nbsp'.$roomName.'</font></a>
											</li>
											
											
							';
									}
									echo'
									</ul>
									</li>';
								
								
				 }	
						?>
						
                            <!-- /.nav-second-level -->
							</li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12" >
					<div class="page-header"><?php 
					require_once('mysteryDB_connect.php');
					
					$status = $_GET['statusID'];
					
					$query = "Select * from status s join sensors e  
													   on s.sensorID = e.sensorID 
													   join rpi r 
													   on e.rpiID = r.rpiID 
													   join rooms o 
													   on r.roomID = o.roomID 
													   join branches b
													   on o.branchID = b.branchID
													where s.statusID = $status
													   ";	
						$result=mysqli_query($dbc,$query);
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						$branchname = $row['branchname'];
						$branchID = $row['branchID'];
						$roomName = $row['roomName'];
						$roomID = $row['roomID'];
						$rpiName = $row['rpiName'];
						$rpiID = $row['rpiID'];
						$sensorName = $row['sensorName'];
						$sensorID = $row['sensorID'];
						
						}
				 
				 
				 echo"
				  <ol class='breadcrumb'>";
				  if($_SESSION['from'] == 0){
				 if($_SESSION['userTypeID'] == 1){
					echo "<li class='breadcrumb-item'><a href=\"index.php\"> <font color=\"blue\">Home </font></a></li>
						<li class='breadcrumb-item'><a href=\"roomslist.php?branchID=$branchID &branchname= $branchname \"> <font color=\"blue\">$branchname</font> </a></li>";
				 }
				  if($_SESSION['userTypeID'] == 2){
					echo "<li class='breadcrumb-item'><a href=\"indexGamemaster.php\"> <font color=\"blue\">Home </font></a></li>";
				 }
				  }
				if($_SESSION['from'] == 1){
					 if($_SESSION['userTypeID'] == 1){
						echo "<li class='breadcrumb-item'><a href=\"listbranch.php\"><font color=\"blue\">Branches</font></a></li>
						<li class='breadcrumb-item'><a href=\"roomslist.php?branchID=$branchID &branchname= $branchname \"> <font color=\"blue\">$branchname </font></a></li>
						";
					 }
					  
				}
				if($_SESSION['from'] == 3){
					 if($_SESSION['userTypeID'] == 1){
						echo "<li class='breadcrumb-item'><a href=\"listrpi.php\"><font color=\"blue\">RPi</font></a></li>";
					 }
					
				}
					echo"
				
					<li class='breadcrumb-item'><a href=\"rpilist.php?roomID=$roomID&roomName=$roomName\"> <font color=\"blue\">$roomName </font> </a></li>
					<li class='breadcrumb-item'>$rpiName</li>
					<li class='breadcrumb-item'>$sensorName</li>
					<li class='breadcrumb-item active'>Status Number:$status</li>
					</ol>
					";
					?>
				</div>
				</div>
				<div id="qwert"></div>
				<div class="col-lg-12">
				<div class="row">
					<?php
						

							$statusID = $_GET['statusID'];
							
							$sql = "SELECT st.status as status, std.variableName as variableName, std.value as value, st.timestamp
														  from status st join statusdetails std
																on st.statusID = std.statusID
														 where st.statusID = '$statusID'";
						
							$result1 = mysqli_query($dbc,$sql);
							$result2 = mysqli_query($dbc,$sql);
							
							$row=mysqli_fetch_array($result1,MYSQLI_ASSOC);
							$status = $row['status'];	
							$timestamp = $row['timestamp'];	
							
							echo '<div class="col-lg-2"></div>
								  <div align="center" class="col-lg-8">
									 <b> Status:</b> '.$status.'
									 <br>
									 <b> Timestamp: </b>  '.$timestamp.'
									 </div>
								 ';
							echo 	
										'
										</div>
										<div class="col-lg-2"></div>
										<div class="col-lg-8">
										<br>
										<table class="table table-striped table-bordered table-hover" id="roomtable">
										<thead>
											<tr>
											
											<th class="text-center">Variable Name</th>
											<th class="text-center">Value</th>
											</tr>
										</thead>
										<tbody>
										';
							
							while ($row=mysqli_fetch_array($result2,MYSQLI_ASSOC)) {
											
								
								$variableName = $row['variableName'];	
								$value = $row['value'];	
								
								echo'
									<tr>
											
											<th class="text-center">'.$variableName.'</th>
											<th class="text-center">'.$value.'</th>	
									</tr>
									';
							}	
								
							echo '</tbody> </table></div></div>';
						
					?>
				
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
	
	
	<script>
	

</body>

</html>
