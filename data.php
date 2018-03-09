<?php
	require_once('mysteryDB_connect.php');

		$roomID = $_GET['roomID'];
	
				  
		$sqld ="SELECT distinct rpiID, rpiName, ipAddress FROM rpi where roomID = '$roomID' and status = 0;"; //ipAddress value was added
		
		
		
		$result1 = mysqli_query($dbc,$sqld);
		

		
		
		while ($row=mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
																//code to ping ip address ----------- start here -----------
			$ipAddress = $row['ipAddress'];
			
			exec("ping -c 2 $ipAddress", $output, $result);
			
			print_r($output);
			
			if($result == 0) {
				$value = 0;		//store the value in here if on ba sya 
			}
			else {
				$value = 1;		//store the value in here if off ba sya 
			}
																//code to ping ip address ----------- end here ----------- NOT TESTED
			//$value = 0; 		//old code setting for value
					$rpiName = $row['rpiName'];		
			echo 	
							'<div class="row">
							<div class="col-lg-6">
							';
							if($value == 0){ //if on 
										echo'<h3>'.$rpiName.'<i class="fa fa-chain fa-fw" style = "color:green"></i></h3>';
							}else{ //if off
									echo'<h3>'.$rpiName.'<i class="fa fa-chain fa-fw" style = "color:red"></i></h3>';
							}
							echo'
							<table class="table table-stipend table-bordered table-hover" id="roomtable">
							<thead>
								<tr>
						
								<th class="text-center">Sensor Name</th>
								<th class="text-center">Status</th>
								<th class="text-center">Timestamp</th>
								
								</tr>
							</thead>
							<tbody>
							
							';
		
					$rpiID = $row['rpiID'];
					
						$sql = "SELECT sn.sensorID as sensorID, sn.sensorName as sensorName, st.status as status, st.timestamp as timestamp, st.statusID as statusID
									  from rooms r join rpi rpi
											on r.roomID = rpi.roomID
												   join sensors sn
											on rpi.rpiID = sn.rpiID
												   join sensortypes sts
											on sn.sensorTypeID = sts.sensorTypeID
												   join status st
											on sn.sensorID = st.sensorID
								  where (r.roomID = '$roomID') and (rpi.rpiID = '$rpiID') and rpi.status = 0";

					$result = mysqli_query($dbc,$sql);
						
						
						while ($row1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {	
							$sensorID = $row1['sensorID'];
							$sensorName = $row1['sensorName'];
							$status = $row1['status'];	
							$timestamp = $row1['timestamp'];	
							$statusID = $row1['statusID'];
							
							
							
											
							// <tr class='clickable-row' data-href='url:index.php'>
							echo 
								'
								<tr>
									
									<td class="text-center">'.$sensorName.'</td>
									<td class="text-center"><a href="showstatusdetail.php?statusID='.$statusID.'&sensorName='.$sensorName.'">'.$status.'</td>
									<td class="text-center">'.$timestamp.'</td>
								</tr>
								</div>
									
								';
							
							
						}
								echo '</tbody> </table>';
						// <tr class='clickable-row' data-href='url:index.php'>
						
					
					
	}
?>