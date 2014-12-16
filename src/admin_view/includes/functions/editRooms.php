<br/><br/><font size=5>Edit a Room</font><br/><br/>
<form action="settings.php?page=roomsInput" method="post">
	<table>
		<tr>
			<th align="right">Building Name:</th>
			<th align="left">				
				<select name="complex">
					<?php
						$complex3 = "SELECT build_id,building_name, building_letter FROM building WHERE complex=0 ORDER BY building_name AND building_letter";
						$count = 0;
						$complexRes = mysqli_query($dbconn, $complex3);
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
			<th align="left"> <input class="button1" type="submit" value="View" /></th>
		</tr>
	</table>
</form>
<br/>
