
<!DOCTYPE html>
<html lang="en">
<?php session_start();
require_once('mysteryDB_connect.php');
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $_GET['roomName']; ?></title>

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
	
								echo '
								<li>
									<a href="index.php"><i class="fa fa-home fa-fw" style="color:white"><font color="white"></i> Home </font></a>
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
								</li>
								</ul>
								<li>
								<a href="#"><i class="fa fa-sitemap fa-fw" style="color:white"></i><font color="white"> Branches </font><span class="fa arrow" style="color:white"></span></a>
								<ul class="nav nav-second-level">
								';
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
											</li>
										";
									}
									echo '</ul>
										  </li>
										  </ul>
										  </ul>	
										  ';
								
							}
							  if($_SESSION['userTypeID'] == 2){
						echo '
								<li>
									<a href="indexGamemaster.php"><i class="fa fa-home fa-fw" style="color:white"><font color="white"></i> Home </font></a>
								</li>';
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
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="col-lg-12">
			<?php
				$query = " Select * from rooms r join branches b 
													   on r.branchID = b.branchID 
													   
													   ";	
						$result=mysqli_query($dbc,$query);
						$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
						$branchname = $row['branchname'];
						$branchID = $row['branchID'];
				
					echo"<ol class='breadcrumb'>";
				 if($_SESSION['userTypeID'] == 1){
					echo "<li class='breadcrumb-item'><a href=\"index.php\"> Home </a></li>";
				 }
				  if($_SESSION['userTypeID'] == 2){
					echo "<li class='breadcrumb-item'><a href=\"indexGamemaster.php\"> Home </a></li>";
				 }
				 echo"
					<li class='breadcrumb-item'><a href=\"indexGamemaster.php\"> $branchname </a></li>
					<li class='breadcrumb-item active'>{$_GET['roomName']}</li>
					
					</ol>
					";
				?>
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header">Latest Update </h3>
						<h4 class="page-header"><div id="asdf"></div></h4>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
							<div id="qwer"></div>
				<?php
						
							$_SESSION['roomID']= $_GET['roomID'];
							$_SESSION['roomName']= $_GET['roomName'];
						$flag=0;
						if (isset($_POST['submit'])){
							$message=NULL;
						}
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
		setInterval(function(){  
			var roomID = <?php echo $_GET['roomID'];?>;
			$('#asdf').load("latestupdatedata.php?roomID="+roomID);

		},6000);
	</script>
	
	<script>
		setInterval(function(){  
			var roomID = <?php echo $_GET['roomID'];?>;
			$('#qwer').load("data.php?roomID="+roomID);

		},6000);
	</script>
	
	<script
		jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.location = $(this).data("href");
		});
	});>
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
