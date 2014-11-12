<br/><br/><font size=5>Edit a Campus</font><br/><br/>
<form action="settings.php?page=campusInput" method="post">
	<table>
		<tr>
			<th align="right">Campus:</th>
			<th align="left">				
				<select name="campus">
					<?php
						while( $row = mysqli_fetch_assoc($resCamp) ){
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
			<th align="left"> <input class="button1" type="submit" value="Submit" /></th>
		</tr>
	</table>
</form>
<br/>
