<?php
	$first=true;
	foreach($_POST as $key => $value)
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

	$con = mysqli_connect("localhost","root","root" , "UNODB");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}


	//print_r($_POST);
	$type = $_POST["type"];

	$sql="DELETE FROM $type WHERE $id_name = '$id'";
	//echo "<br/>$sql<br/>";

	// sending query
	mysqli_query($con,$sql) or die(mysql_error());   



print<<<END
<script>
	window.location="../settings.php?validate='Remove sucess!'";
</script>
END;
?>
