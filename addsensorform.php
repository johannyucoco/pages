<!DOCTYPE html>
<html lang="en">
<?php session_start();
if($_SESSION['userTypeID'] != 1) {
	 header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/logout.php");
}
require_once('mysteryDB_connect.php'); 
	if(isset( $_GET['roomID'])){
	$_SESSION['roomID'] = $_GET['roomID'];
	}
	
	if (isset($_POST['submit'])){
		$message=NULL;
										
		if(empty($_POST['rpiConnection'])){
			 $message .= '<p>Empty Rpi';
			 $rpiConnection=FALSE;
		}else $rpiConnection = $_POST['rpiConnection'];
										 
		if(empty($_POST['sensorTypeID'])){
			 $message .= '<p>Empty sensorTypeID';
			 $sensorTypeID=FALSE;
		}else $sensorTypeID = $_POST['sensorTypeID'];

		$roomID = $_SESSION['roomID'];		
		$sensorName= $_POST['sensorName'];
		if(!isset($message)){
			
			$query1="insert into sensors(sensorName,rpiID,sensorTypeID) values ('$sensorName','$rpiConnection','$sensorTypeID')";
			$result=mysqli_query($dbc,$query1);
											
		}

		if(isset($message)){
			echo '<font color="green">'.$message.'</font>';
		}

	}/*End of main Submit conditional*/

							?>
							
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add Raspberry Pi</title>

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
        <nav class="navbar navbar-default navbar-static-top" role="navigation"  style="margin-top: 0 ; background-color:black">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-left" href="index.php" ><img style="width:150px;height:50px;" src="logo.gif"></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
			
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
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
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                        </li>
                            <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Tools<span class="fa arrow"></span></a>
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
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Manage Data<span class="fa arrow"></span></a>
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
							<li>
							<li>
						<a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
						</li>
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    
                                        <div class="form-group">
											<?php 	
													$room = $_SESSION['roomID'];
													$name = $_SESSION['roomName'];
													echo "<a href=\"rpilist.php?roomID=$room&roomName=$name\" class='btn btn-info' role='button'>Back</a>";
											?>
											<br><br>
											<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
											   <input disabled class="form-control"  <?php
												
												$query1= "select * from rooms where roomID = {$_SESSION['roomID']};"; // Run your query
												$result1=mysqli_query($dbc,$query1);
												$row = mysqli_fetch_array($result1,MYSQLI_ASSOC);
												$roomName = $row['roomName'];
												
												
												echo "value='{$roomName}'";  ?> >
												
											<br>
                                            <input required class="form-control" placeholder="Sensor Name" name="sensorName">
                                        </div>
										<div class="form-group">
                                            <label>Sensor connected to <label>
                                            <select name="rpiConnection" class="form-control">
                                              <?php
												
												$query1= "select rpiID,rpiName from rpi where roomID = {$_SESSION['roomID']};"; // Run your query
												$result1=mysqli_query($dbc,$query1);
												echo "<option value='default'> -Select- </option>"; 
												while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
												$rpiName = $row['rpiName'];
												$id = $row['rpiID'];
												echo "<option value=". $id .">".$rpiName."</option>";
												}
											?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Sensor Type</label>
                                            <select name= "sensorTypeID" class="form-control">
                                               <?php
												
												$query1= "select * from sensortypes;"; // Run your query
												$result1=mysqli_query($dbc,$query1);
												echo "<option value='default'> -Select- </option>"; 
												while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
												$sensorTypeName = $row['sensorType'];
												$id = $row['sensorTypeID'];
												echo "<option value=". $id .">".$sensorTypeName."</option>";
												}
											?>
                                            </select>
												</div>
												<div align="center"><input type="submit" name="submit" value="Confirm" class="btn btn-info" role="button"/></div>	
												
											</form>
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
