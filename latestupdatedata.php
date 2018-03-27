<?php
	require_once('mysteryDB_connect.php');

		$roomID = $_GET['roomID'];
		
		
			$sql= "Select *,s.status as status from status s join sensors se 
											on s.sensorID = se.sensorID 
										  join rpi r 
										    on r.rpiID = se.rpiID 
										  join rooms ro
											on r.roomID = ro.roomID 
										where ro.roomID = {$roomID}
										
			group by s.statusID
			order by s.timestamp desc 
			
			limit  1"; 

			$result = mysqli_query($dbc,$sql);
				
				echo 	
							'
							<table class="table table-stipend table-bordered table-hover" id="roomTable">
							<thead>
								<tr>
								
								<th class="text-center">Sensor Name</th>
								<th class="text-center">Status</th>
								<th class="text-center">Timestamp</th>
								
								</tr>
							</thead>
							<tbody>
							
							';
				while ($row1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
					
			
					$sensorNameL = $row1['sensorName'];
					$statusL = $row1['status'];	
					$timestampL = $row1['timestamp'];
					
							
					// <tr class='clickable-row' data-href='url:index.php'>
					echo 
						'
						<tr>
					
							<td class="text-center">'.$sensorNameL.'</td>
							<td class="text-center">'.$statusL.'</td>
							<td class="text-center">'.$timestampL.'</td>
						</tr>
							
						';
					
				}	
				
					echo '</tbody> </table>';
				// <tr class='clickable-row' data-href='url:index.php'>
				
			
			

?>