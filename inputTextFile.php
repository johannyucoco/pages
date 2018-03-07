<?php
	session_start();
	
	//start of txt file to array conversion 
	$logs = array();
	foreach (glob("*.txt") as $filename) {
			$handle = fopen($filename, "r");
	

	if ($handle) {
		$i=0;
		while (($line = fgets($handle)) !== false) {
			$data = explode(",", $line);
			$logs[$i] = array(
				1 => $data[0],
				2 => $data[1],
				3 => $data[2],
				4 => $data[3],
				5 => $data[4],
				6 => $data[5]
			);
			$i++;
		   //var_dump($locks);

		}
		fclose($handle);
	} else {
		// error opening the file.
	}
	//end of conversion 
	
	//database connection 
	require_once('C:\xampp\htdocs\MysteryManila\test\pages\mysteryDB_connect.php');

	//code for getting the last entry 
	
	/*$query="select timestamp from status order by statusID desc limit 1 ";
	$result=mysqli_query($dbc,$query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC)
	echo " {$row['timestamp']}";
	//search for the latest 
	$key = array_search("2015-03-12 00:01:36", array_column($logs, 2)); */
	
		$values = array();
		$_SESSION['values'] = $values;	
						$_SESSION['num'] = null;
	foreach ($logs as $key => $row) {
		foreach ($row as $key2 => $val) {
				
			//CHECK FIRST ON WHAT TYPE OF SENSOR BEFORE adding to the db 
			
			//storing for colorsensor 
			
			//STORE DATA TO SESSION FOR GATHERING OF ONE ROW 
			if($key2 == 1) {
				$query = "select * from sensors where sensorName = '$val' limit 1 ";
				$result=mysqli_query($dbc,$query);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$_SESSION['sensorID'] = $row['sensorID'];
				$_SESSION['sensorTypeID'] = $row['sensorTypeID'];
				$sensorTypeID= $_SESSION['sensorTypeID'];
				
				
			}
			if($key2 == 2) {
				$_SESSION['timestamp'] = $val;
				
			}
			if($key2 == 3) {
				
				$_SESSION['status'] = $val;
						
			}
				$query = "select count(legendVariableName) as num from legendstatusdetails where legendStatusID = (select legendStatusID from legendstatus where sensorTypeID = '$sensorTypeID' limit 1)";
				$result=mysqli_query($dbc,$query);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				//echo "this is num: $num";
				//echo "<br>";
				$num = $row['num'] + 3;
			if(  $key2 > 3 && $num >= $key2){
				//echo "$val";
				array_push($_SESSION['values'] ,$val);
			}
			
			//$columnSize = max( array_map('count', $logs));
			
		
				
			if ($key2 == $num && !empty($_SESSION['values'])){
					$timestamp = $_SESSION['timestamp'];
					$query1= "select * from status where timestamp = '$timestamp'"; // Run your query
					$result1=mysqli_query($dbc,$query1);
					$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
					$hi = $row['timestamp'];
					$_SESSION['check'] = !isset($hi);
				if(!isset($hi)) {
					
					//insert status
					$status = $_SESSION['status'];
									//one time query per sensor 
					$sensorID = $_SESSION['sensorID'];			
					$status = $_SESSION['status'];
					$query1="insert into status(status,sensorID,timestamp) values ('$status','$sensorID','$timestamp')";
					$result1=mysqli_query($dbc,$query1);
									
		
		
				
				//Get sensortype from sensor 
				$sensorID = $_SESSION['sensorID'];
				$querysensortype = "select * from sensors where sensorID = '$sensorID' limit 1";
				$result1=mysqli_query($dbc,$querysensortype);
				$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
				$sensorTypeID = $row['sensorTypeID'];
				
				//Get legend values output $legendVariableNames
				$query = "select * from legendstatusdetails where legendStatusID = (select legendStatusID from legendstatus where sensorTypeID = '$sensorTypeID' limit 1)";
				$result=mysqli_query($dbc,$query);
		
				$legendVariableNames = 	array();
				$_SESSION['legendVariableNames'] = $legendVariableNames;	
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
					array_push($_SESSION['legendVariableNames'] ,$row['legendVariableName']);
					
				}
				
				
				
				//get statusID 
					$query2="select statusID from status order by statusID desc limit 1";
					$result2=mysqli_query($dbc,$query2);
					$row = mysqli_fetch_array($result2, MYSQLI_ASSOC);
					$statusID = $row['statusID'];
					$legendVariableNames = $_SESSION['legendVariableNames'];
					$values = $_SESSION['values'];
						 // use $legendVariableNames and $values and $statusID
							$rows = count($legendVariableNames);
							$count= 0;
							echo "this is my row: $rows";
							echo "<br>";
								while($rows > $count && !empty($values)){
									
									$r="insert into statusdetails(statusID,variableName,value) values ('$statusID','$legendVariableNames[$count]','$values[$count]')";
									echo $values[$count];
									echo $r;
									echo "<br>";
									$result=mysqli_query($dbc,$r);
									
									$count++;
								}
						
							
				unset($values);
				unset($legendVariableNames);
				$legendVariableNames = array();
				$values = array();
				$_SESSION['values'] = $values;
				$_SESSION['legendVariableNames'] = $legendVariableNames;
				
					
				} else {
						
						}
							
			}
		
			//end STORE DATA TO SESSION FOR GATHERING OF ONE ROW 	
			
		}
	}
	
	}
	
	
	
	
?>



