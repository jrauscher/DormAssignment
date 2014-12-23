<?php
echo '<link rel="stylesheet" href="../css/inputTable.css" type="text/css">';

$complex = mysqli_real_escape_string($dbconn, $_POST['complex']); /**< gets complex ID from the settings.php?page=buildInput page. */
$count = 0; /**< Counter variable for a loop. */

$sql ="SELECT building_name AS 'Complex Name', building_letter AS 'Letter', campus AS 'Campus',lease as 'Lease' FROM building WHERE build_id='$complex'"; /**< SQL string that gets complex information from the building table. */
$sql2 ="SELECT building_name AS 'Complex Name', building_letter AS 'Letter' FROM building WHERE build_id='$complex'"; /**< SQL string that gets building information from the building table. */
$res = mysqli_query($dbconn, $sql); /**< Runs the SQL Query in $sql. */
$res2 = mysqli_query($dbconn, $sql2); /**< Runs the sQL Query in $sql2. */

echo "<p>Selected Building:";
while( $row = mysqli_fetch_assoc($res2) ){ 
	foreach($row as $val){
		echo "$val ";
	}						
}
echo "</p>";

echo '<form action="validate/update/upBuildings.php" method="post">';
echo '<input class="button1" type="submit" value="Update"/><br/>';
echo '<br/><br/>';
	$complex100 = "SELECT building_name FROM building WHERE complex=1"; /**< SQL string that gets the building names from the building table. */
	$complexRes100 = mysqli_query($dbconn, $complex100); /**< Runs the SQL Query in $coplex100. */	
	$count=0;

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
						
						if ($count == 0){
							echo '<td>';
								echo '<select name="bName">';
									while( $row = mysqli_fetch_assoc($complexRes100)){
										foreach($row as $val){
											if($val == $bName){
												echo '<option value="'.$val.'" selected>';
													echo $val;
												echo '</option>';
											}else{								
												echo '<option value="'.$val.'">';
													echo $val;
												echo '</option>';
											}
										}	
									}
								echo '</select>';
							echo '</td>';
						}
						if ($count == 1){
							echo '<td>';
								echo '<input style="width:100px;" name="letter" size="4" maxlength="4" type="text" value="';
								echo $val;
								echo '"></input>';
							echo '</td>';
						}
						if ($count == 2){
							echo '<td>';
								echo '<select name="campus">';
									while( $row = mysqli_fetch_assoc($resCamp)){
										foreach($row as $val){
											if($val == mysqli_fetch_assoc($CA)){
												echo '<option value="'.$val.'" selected>';
													echo $val;
												echo '</option>';
											}else{								
												echo '<option value="'.$val.'">';
													echo $val;
												echo '</option>';
											}
										}			
									}
								echo '</select>';
							echo '</td>';

						}
						if ($count == 3){
							echo '<td>';
								echo '<input style="width:100px;" name="lease" size="4" maxlength="4" type="text" value="';
								echo $val;
								echo '"></input>';
							echo '</td>';

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
echo '<input name="oldComplex" type="hidden" value="';
echo $complex;
echo '</input>';
			
echo '</form>';
?>
