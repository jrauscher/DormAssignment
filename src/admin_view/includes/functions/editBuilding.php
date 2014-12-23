<br><br><font size=5>Edit a Building</font><br/><br/>
<form action="settings.php?page=buildInput" method="post">
	<table>
		<tr>
			<th align="right">Building Name:</th>
			<th align="left">				
				<select name="complex">
					<?php
						$complex3 = "SELECT build_id,building_name, building_letter FROM building WHERE complex=0 ORDER BY building_name AND building_letter"; /**< SQL string that gets building information from the builing table and orders it. */
						$count = 0; /**< Counter variable for a loop. */
						$complexRes = mysqli_query($dbconn, $complex3); /**< Runs the SQL Query in $complex3. */
						while( $row = mysqli_fetch_assoc($complexRes)){
							foreach($row as $val){
								$count ++;
								if($count == 1){
									echo '<option value="'.$val.'">';
									$count = -2;
								}
								if($count == -1){
									echo $val;
									echo " ";
								}
								if($count == 0){
									echo $val;
									echo '</option>';	
								}
							}	
						}
					?>
				</select>
			</th>
		</tr>
		<tr>
			<th align="left"> <input class="button1" type="submit" value="Veiw" /></th>
		</tr>
	</table>
</form>
<br/>
