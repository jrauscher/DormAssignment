<?php
	include ('../../includes/svrConnect.php');

// escape variables for security
$body = mysqli_real_escape_string($dbconn, $_POST['body']);
$title = mysqli_real_escape_string($dbconn, $_POST['title']);
$valid = 1;
$index = 0;
$emailList = array();

echo "body: $body<br/>";	
echo "title: $title<br/>";	

for($i=0;$i<10;$i++){
		$studentId = mysqli_real_escape_string($dbconn, $_POST['stdID'.$i.'']);
		$isChecked = mysqli_real_escape_string($dbconn, $_POST['chk'.$i.'']);
		if($isChecked == 1)
		{
			$emailQuery = "SELECT email FROM students WHERE student_id='$studentId'";
			$email = mysqli_query($dbconn, $emailQuery);
				while( $row = mysqli_fetch_assoc($email) ){ /* mysqli_fetch_assoc will return each row until all rows have been read. Once it's done, it returns false. */
					foreach($row as $val){ /* Loop through array, each item in array gets assigned to $val */
						$emailList[$index++] = $val;
				}
			}
			echo "Email: $val<br/>";
		}
		echo "<br/>stdID$i id: $studentId<br/>";
		echo "chk$i  status: $isChecked<br/><br/><br/>";
}


if ($valid == 1){
print<<<END
<script>
//window.location="../settings.php?validate=Rooms added sucessfully!";
</script>
END;
}
else{
print<<<END
<script>
//window.location="../settings.php?validate=ERROR: Rooms not added, duplicate entry!&error=1";
</script>
END;
}
?>









 
