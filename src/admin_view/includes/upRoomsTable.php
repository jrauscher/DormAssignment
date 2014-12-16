<?php
echo '<link rel="stylesheet" href="../css/inputTable.css" type="text/css">';

$BID = mysqli_real_escape_string($dbconn, $_POST['complex']);

$sql ="SELECT room_num AS 'Room Number',floor AS 'Floor', RA_Room as 'RA Room', HC_Room AS 'HC Room' FROM rooms WHERE build_id='$BID'";
$sql2 ="SELECT building_name AS 'Complex Name', building_letter AS 'Letter' FROM building WHERE build_id='$BID'";
$res = mysqli_query($dbconn, $sql);
$res2 = mysqli_query($dbconn, $sql2);

echo "<p>Selected Building:";
while( $row = mysqli_fetch_assoc($res2) ){ 
	foreach($row as $val){
		echo "$val ";
	}						
}
echo "</p>";

echo '<form action="validate/update/upRooms.php" method="post">';
echo '<input class="button1" type="submit" value="Update"/><br/>';
echo '<br/><br/>';
	$complex100 = "SELECT building_name FROM building WHERE complex=1";
	$complexRes100 = mysqli_query($dbconn, $complex100);	
	$count=0;
	$num_rooms = 0;
	$I=0;

		if($res){
			//echo 'Query successful.';
			/* Check to see if at least 1 row was returned. */
			/* CAREFUL: If using an update query, this will still return 0 even if a row was updated. */
			if( mysqli_num_rows($res) > 0){
				/* Start printing (echo) the table to the user. */
				echo '<table class="inputTable">';


				/* Use the first row to get the table headers. */
				$first_row = mysqli_fetch_assoc($res);
				echo '<tr>';				
				foreach($first_row as $col => $val){ /* Don't care about the $val here, but have to have it to get the $col */
					echo '<th>';
					echo $col;
					echo '</th>';
				}
				echo '</tr>';

				/* Make sure to reset the pointer back to beginning if you've used the result before. */
				mysqli_data_seek($res, 0);
				while( $row = mysqli_fetch_assoc($res) ){ /* mysqli_fetch_assoc will return each row until all rows have been read. Once it's done, it returns false. */
					echo '<tr>';
					foreach($row as $val){ /* Loop through array, each item in array gets assigned to $val */
						if($count == 0){
							echo '<td>';
								echo '<input style="width:100px;" name="room';
								echo $I;
								echo '" size="4" maxlength="4" type="text" value="';
								echo $val;
								echo '"></input>';
								echo '<input type="hidden" name="oldRoom';
								echo $I;
								echo '" value="';
								echo $val;
								echo '"></input>';
							echo '</td>';
						}
						if($count == 1){
							echo '<td>';
								echo '<input style="width:100px;" name="floor';
								echo $I;
								echo '" size="4" maxlength="4" type="text" value="';
								echo $val;
								echo '"></input>';
								echo '<input type="hidden" name="oldFloor';
								echo $I;
								echo '" value="';
								echo $val;
								echo '"></input>';
							echo '</td>';
						}
						if($count == 2){
							if($val == 1){
								echo '<td><input type="hidden" name="RA'.$I.'" value="0"/>';
								echo '<input name="RA'.$I.'" value="1" type="checkbox" checked></input></td>';
							}else{
								echo '<td><input type="hidden" name="RA'.$I.'" value="0"/>';
								echo '<input name="RA'.$I.'" value="1" type="checkbox"></input></td>';
							}
						}
						if($count == 3){
							if($val == 1){
								echo '<td><input type="hidden" name="HC'.$I.'" value="0"/>';
								echo '<input name="HC'.$I.'" value="1" type="checkbox" checked></input></td>';
							}else{
								echo '<td><input type="hidden" name="HC'.$I.'" value="0"/>';
								echo '<input name="HC'.$I.'" value="1" type="checkbox"></input></td>';
							}

							$count = -1;
							$I ++;
							$num_rooms ++;
						}
						$count ++;
						
					}
					echo '</tr>';
				}

				echo '</table><br/>';
			} else { /* Number of rows is < 1 */
				echo '<p class="bg-info text-info text-center large">No results found.</p>';
			}
		} else { /* There was a syntax error in your SQL! */
			echo 'Query not successful.';
		}
echo '<input name="num_rooms" type="hidden" value="';
echo $num_rooms;
echo ':';
echo $BID;
echo '"></input>';
			
echo '</form>';
?>
