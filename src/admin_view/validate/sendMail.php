<?php
include ('../../includes/svrConnect.php');

echo "<style>
.center {
	position: absolute;
	width: 500px;
	height: 50px;
	top: 280px;
	left: 520px;
}

.center2 {
	position: absolute;
	width: 500px;
	height: 50px;
	top: 10px;
	left: 630px;
}

</style>
";

echo '<div class="center2"><img src="../includes/algo/loader.gif"></div><br/>';
echo '<div class="center">';
echo '<textarea id="load" style="text-align:center; width:500px; height:250px;">';
echo '-------------------- STARTING --------------------&#13;&#10';

if(ob_get_level() == 0){
	ob_start();
}

// escape variables for security
$body = mysqli_real_escape_string($dbconn, $_POST['body']);
$title = mysqli_real_escape_string($dbconn, $_POST['title']);
//$limit = mysqli_real_escape_string($dbconn, $_POST['limit']);
$recip = mysqli_real_escape_string($dbconn, $_POST['recip']);
$valid = 1;
$semail = "";
$output = 1;

echo "Sending Mail To: $recip...";
ob_flush();
flush();

$emailString = "echo '$body' | mail -s '$title' $recip";
$output = shell_exec($emailString);

if($output != 0){
	echo " Failed!&#13;&#10";
	ob_flush();
	flush();
}else{
	echo " Sent!&#13;&#10";
	ob_flush();
	flush();
}

$output = 1;

for($i=1;$i<11;$i++){
	$studentId = mysqli_real_escape_string($dbconn, $_POST['stdID'.$i.'']);
	$isChecked = mysqli_real_escape_string($dbconn, $_POST['chk'.$i.'']);

	if($isChecked == 1){
		$emailQuery = "SELECT email FROM students WHERE student_id='$studentId'";
		$email = mysqli_query($dbconn, $emailQuery);

		while( $row = mysqli_fetch_assoc($email) ){
			$semail = $row['email'];
		}

		echo "Sending Mail To: $semail...";
		ob_flush();
		flush();

		$emailString = "echo '$body' | mail -s '$title' $semail";	
		$output = shell_exec($emailString);

		if($output != 0){
			echo " Failed!&#13;&#10";
			ob_flush();
			flush();
		}else{
			echo " Sent!&#13;&#10";
			ob_flush();
			flush();
		}
	}
}


echo "-------------- COMPLETED ---------------</textarea></div>";
ob_flush();
flush();
sleep(2);
print<<<END
<script>
window.location="../email.php?tab=emails";
</script>
END;
?>










