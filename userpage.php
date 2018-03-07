<!DOCTYPE html>
<html lang="en">
<?php session_start();
if($_SESSION['userTypeID'] != 1) {
	 header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/logout.php");
}
require_once('mysteryDB_connect.php');
if (isset($_POST['save'])){
		
					$status = $_POST['status'];
					$query2="select * from legendstatusdetails d join legendStatus s on d.legendStatusID = s.legendStatusID 
												join sensortypes t on s.sensorTypeID = t.sensorTypeID";
					$result2=mysqli_query($dbc,$query2);
					$ct = 0;	
					while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
						$query="UPDATE legendstatusdetails
									SET legendValue = {$status[$ct]}
									WHERE legendStatusDetailID = {$row['legendStatusDetailID']}";
						$result=mysqli_query($dbc,$query);
						$ct++;
					}
		}
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
                                    <a href="listroom.php"><font color="white"> View Rooms </font></a>
                                </li>
								<li>
                                    <a href="listbranch.php"><font color="white"> View Branches </font></a>
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
						$query1= "select * from users where username = '{$_SESSION['username']}'";
						$result1=mysqli_query($dbc,$query1);
						while($row=mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
							$fname = $row['firstName'];
							$lname = $row['lastName'];
							$uname = $row['username'];	
							$email = $row['email'];
							$cnumber = $row['contactNumber'];
							$branchID = $row['branchID'];
						}
						echo
							'<h3>
							First name:<input class ="form-control" type="text" name="fname" value="'.$fname.'"><br>
							Last name:<input class ="form-control" type="text" name="lname" value="'.$lname.'"><br>
							Username:<input class ="form-control" type="text" name="uname" value="'.$_SESSION['username'].'"><br>
							Password:<input class="form-control" type="submit" name="pass" value="Change Password" class="btn btn-info" role="button"/><br>
							Email:<input class ="form-control" type="email" name="email" value="'.$email.'"><br>
							Contact Number:<input class ="form-control" type="number" name="cnumber" value="'.$cnumber.'"><br>
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
								Branch:<input disabled class ="form-control" type="text" value="'.$branch.'"><br>
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
								User Type:<input disabled class ="form-control" type="text" value="'.$usertype.'"><br>
								</h3>
								'
					?>
					<div align="center">
					<input type="submit" name="save" value="Save" class="btn btn-info" role="button"/>
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
