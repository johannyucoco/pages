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
		
if (isset($_POST['delete'])){
	

}

	
		
			
			
		

/*End of main Submit conditional*/



?>
<head>
	
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"></link>
		
		
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Status Details</title>

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
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Branches<span class="fa arrow"></span></a>
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
                                

				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<div>
                                        <table id="dataTable" class='pure-table pure-table-horizontal table-width-order table-margin-left'>
										<tr>
											
											<th><div align=\"center\">SensorType</div></th>
											<th><div align=\"center\">Status</div></th> 
											<th><div align=\"center\">Variable Name</div></th>
											<th><div align=\"center\">Value</div></th>
										</tr>
										<?php
												
												
												$query="select * from legendstatusdetails d join legendStatus s on d.legendStatusID = s.legendStatusID 
												join sensortypes t on s.sensorTypeID = t.sensorTypeID";
												$result=mysqli_query($dbc,$query);
												
												while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
														echo "<tr>";
														echo "<td>" . $row['sensorType']. "</td>";
														echo "<td>" . $row['legendStatus']. "</td>";
														echo "<td>" . $row['legendVariableName'] . "</td>";
														echo "<td><input required type=\"int\" min=\"0\" name=\"status[]\" class=\"form-control\" placeholder=\"{$row['legendValue']}\" value=\"{$row['legendValue']}\"	td>";
														echo"</tr>";
												}
												
										?>
										
										</table>
										<div align="center"><input type="submit" name="save" value="Edit" class="btn btn-info" role="button"/></div>	
								</div>		
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
	
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"> </script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script> 
		$(document).ready(function(){
			$('#dataTable').DataTable();
		});
	</script>
	<script>
	function updateCheckbox(int){
		if(
		
	}
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
