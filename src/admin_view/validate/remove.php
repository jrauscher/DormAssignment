<?php
	$first=true; /**< Flag to check if this is the frist iteration of the loop. */
	foreach($_POST as $key => $value)/** Loops though the POST variables. */
	{
		if($first)
		{
			$id_name=$key;
			$id =$value;
			$first=false;
		}
		else
		{
			break;
		}
	}

	include ('../../includes/svrConnect.php');

	//print_r($_POST);
	$type = $_POST["type"]; /**< Gets the type from the (html) submission form */

	$sql="DELETE FROM $type WHERE $id_name = '$id'"; /**< SQL string that deletes from the $type where $id_name = $id. */ 
	//echo "<br/>$sql<br/>";

	// sending query
	mysqli_query($dbconn,$sql) or die(mysql_error());   

print<<<END
<script>
	window.location="../settings.php?validate=Remove sucess!";
</script>
END;
?>
