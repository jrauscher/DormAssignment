<br/><br/><font size=5>Edit a Complex</font><br/><br/>
<form action="settings.php?page=complexInput" method="post">
	<table>
		<tr>
			<th align="right">Complex Name:</th>
			<th align="left">				
				<select name="complex">
					<?php
						$complex3 = "SELECT building_name FROM building WHERE complex=1"; /**< SQL string that gets all building names from the builings table. */
						$complexRes = mysqli_query($dbconn, $complex3); /**< Runs the SQL Query in $complex3. */
						while( $row = mysqli_fetch_assoc($complexRes)){
							foreach($row as $val){
								echo '<option value="'.$val.'">';
									echo $val;
									echo '</option>';
							}	
						}
					?>
				</select>
			</th>
		</tr>
		<tr>
			<th align="left"> <input class="button1" type="submit" value="View" /></th>
		</tr>
	</table>
</form>
<br/>
