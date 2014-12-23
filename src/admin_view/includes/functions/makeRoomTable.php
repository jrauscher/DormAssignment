<?php

$complex = mysqli_real_escape_string($dbconn, $_POST['complex']); /**< Gets complex id from settings.php?page=14 page. */
$floors = mysqli_real_escape_string($dbconn, $_POST['fnum']); /**< Gets the number of floors from settings.php?page=14 page. */
$rooms = mysqli_real_escape_string($dbconn, $_POST['rnum']);/**< Gets the number of rooms from settings.php?page=14 page. */
echo '<link rel="stylesheet" href="../css/inputTable.css" type="text/css">';

echo '<form action="validate/roomsVal.php" method="post">';
	echo '<p>Please enter the rooms numbers below, click submit when you are finished.</p>';
	echo '<p>Note: Entering a "0" as a room number will cause the room to not be created.</p>';
	echo '<input class="button1" type="submit" value="submit">';
	echo '<input type="hidden" name="floors" value="'.$floors.'"/>';
	echo '<input type="hidden" name="rooms" value="'.$rooms.'"/>';
	echo '<input type="hidden" name="build" value="'.$complex.'"/>';

	makeTable($floors, $rooms);
echo '</form>';

/**
* <pre>
* MAKETABLE: Makes a table in html, that allows for input for room numbers. 
* TAKES: Number of rows and number of coloumns.
* RETURNS: Nothing, generates a table in html. 
*</pre>
*/
function makeTable($rows,$cols){

	$count = 0;
	$max = 0;
		echo '<table class="formatTable">';

		if($rows < 3){
			while($count < $rows){	
				echo '<th>';
				echo '</th>';
				$count ++;
			}
		}else{
			while($count < 3){	
				echo '<th>';
				echo '</th>';
				$count ++;
			}
		}

		echo '<tr>';
		for($i=1;$i<$rows+1;$i++){
			if($max == 3){
				echo '</tr>';
				echo '<tr>';
				$max = 0;
			}
			echo '<td>';
		
				echo '<table class="inputTable">';
					echo '<th>Floor: '.$i.'</th>';				
					echo '<th>Room Number</th>';			
					echo '<th>RA Room</th>';			
					echo '<th>Handicapped<br/>Room</th>';			
	
					for($j=1;$j<$cols+1;$j++){
						$roomNum = $i * 100 + $j;
						$raNum = $i * 10 + $j;
						$hcNum = $i * 1000 + $j;

						echo '<tr>';
							echo '<td>Room '.$j.':</td>';
								echo '<td><input type="hidden" name="room_num'.$roomNum.'" value="0"/>';
								echo '<input size="4" name="room_num'.$roomNum.'" value="'.$roomNum.'"type="text"></input></td>';
								echo '<td><input type="hidden" name="RA'.$raNum.'" value="0"/>';
								echo '<input name="RA'.$raNum.'" value="1" type="checkbox"></input></td>';
								echo '<input type="hidden" name="HC'.$hcNum.'" value="0"/>';
								echo '<td><input name="HC'.$hcNum.'" value="1" type="checkbox"></input></td>';
						echo '</tr>';
					}
				echo '</table><br/>';
			echo '</td>';	
			$max ++;
		}
	echo '</tr>';
	echo '</table><br/>';
}

?>
