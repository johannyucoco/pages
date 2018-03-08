
<!DOCTYPE html>
<html lang="en">
<?php session_start();

	require_once('mysteryDB_connect.php');?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php 
					
					if($_SESSION['userTypeID'] == 1) {
					echo $_GET['branchname']; 
					$id = $_GET['branchID'];
					}
					if($_SESSION['userTypeID'] == 2) {
						$query= "select * from users u join branches b on u.branchID = b.branchID where userID = '{$_SESSION['userID']}' "; // Run your query
						$result=mysqli_query($dbc,$query);
						$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
						echo $row['branchname']; 
					}						
													?> Branch &nbsp <?php
						?></title>

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
								

									
								";
								
							}
								
						?>
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
				
                    <h1 class="page-header"><?php 
					
					if($_SESSION['userTypeID'] == 1) {
					echo $_GET['branchname']; 
					$id = $_GET['branchID'];
					}
					if($_SESSION['userTypeID'] == 2) {
						$query= "select * from users u join branches b on u.branchID = b.branchID where userID = '{$_SESSION['userID']}' "; // Run your query
						$result=mysqli_query($dbc,$query);
						$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
						echo $row['branchname']; 
					}						
													?> Branch 
					
				</div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
				<?php
						if($_SESSION['userTypeID'] == 1) {
							$branchID = $_GET['branchID'];
							$_SESSION['branchID'] = $_GET['branchID'];
					}
					if($_SESSION['userTypeID'] == 2) {
						$query= "select * from users u join branches b on u.branchID = b.branchID where userID = '{$_SESSION['userID']}' "; // Run your query
						$result=mysqli_query($dbc,$query);
						$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
						$branchID = $row['branchID'];
					}
			
						
						$sql = "SELECT r.roomID as roomID, r.roomName as roomName, r.roomDescription as roomDescription, r.branchID as branchID, b.branchName as branchName 
								  from rooms r join branches b
											on r.branchID = b.branchID
								 where r.branchID = '$branchID'
								 and r.status = 0 ";
								 
						//echo '<h1 class="page-header">Rooms'."".$roomName.'</h1>':		 
							
						$result = mysqli_query($dbc,$sql);
						
						echo 	
								'
								<table class="table table-stipend table-bordered table-hover" id="roomtable">
								<thead>
									<tr>
							
									<th class="text-center">Room Name</th>
									<th class="text-center">Room Description</th>
									<th class="text-center">Rpi</th>
									
									
									</tr>
								</thead>
								<tbody>
								
								';
						
						while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$roomID = $row['roomID'];
							$roomName = $row['roomName'];
							$roomDescription = $row['roomDescription'];	
							$branchID = $row['branchName'];				
							// <tr class='clickable-row' data-href='url:index.php'>
							$sql1 = "SELECT  count(p.rpiID) as num from rooms r join rpi p
															on r.roomID = p.roomID
															where r.status = 0 and r.roomID = '{$roomID}'
															group by r.roomID";
							$result1 = mysqli_query($dbc,$sql1);
							$row1=mysqli_fetch_array($result1,MYSQLI_ASSOC);
							echo 
								'
								<tr>
									
									<td class="text-center"><a href="rpilist.php?roomID='.$roomID.'&roomName='.$roomName.'">'.$roomName.'</td>
									<td class="text-center">'.$roomDescription.'</td>';
							if($row1){
									echo ' <td class="text-center">'.$row1['num'].'</td>';
									}
							else{
								echo '<td class="text-center">0</td>';
							}
								echo '</tr>
									
								';
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
	
	
	<script
		jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.location = $(this).data("href");
		});
	});>
	</script>
	
	<script> 
		$(document).ready(function(){
			$('#roomtable').DataTable({
				ordering: false
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
