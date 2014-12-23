<?php
$complex34 = mysqli_real_escape_string($dbconn, $_POST['complex']); /**< Gets the complex selected from the settings.php?page=15 page. */
$sql34 ="SELECT * FROM rooms WHERE build_id='$complex34'"; /**< SQL string that selects all information on rooms wher the build_id = $complex34. */
$sql35 ="SELECT building_name FROM building WHERE build_id='$complex34'"; /**< SQL string that selects just the builing names from the buildings table where build_id = $complex43. */
$result34 = mysqli_query($dbconn, $sql34) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the SQL Query in $sql34. */
$result35 = mysqli_query($dbconn, $sql35) or die ('Error ' . mysqli_error($dbconn)); /**< Runs the SQL Query in $sql35. */
?>
<br/><br/>
<form action="validate/rmRooms.php" method="post">
	<table>
     	<tr>
			<?php echo "<th><input type='hidden' name='build' value='$complex34'/></th>" ?>
     	<tr>
       		<th align="right">Room number:</th>
      		<th><input name="rNum" type="text" required></input></th>
    	</tr>
		<tr>
			<th align="left"> <input class="button1" type="submit" value="Remove Room" /></th>
		</tr>
	</table>
</form>
<?php
	printResultTable($result34);
?>
