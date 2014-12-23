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
$body = mysqli_real_escape_string($dbconn, $_POST['body']); /**< Gets the message body from the email.php page. */ 
$title = mysqli_real_escape_string($dbconn, $_POST['title']); /**< Gets the message title from the email.php page. */
//$limit = mysqli_real_escape_string($dbconn, $_POST['limit']);
$recip = mysqli_real_escape_string($dbconn, $_POST['recip']); /**< Gets the recipiants from the email.php page. */
$valid = 1; /**< Valid must equl the total number of input variables at the end of the program to insure input variables contain valid text. */
$semail = ""; /**< Stores the email of the person we are sending mail too in the loop. */
$output = 1; /**< Output = 1 if error Ouput = 0 if good. */

echo "Sending Mail To: $recip...";
ob_flush();
flush();

$emailString = "echo '$body' | mail -s '$title' $recip"; /**< String that is going to be sent to a linx shell, so it can use the mail command. */
$output = shell_exec($emailString); /**< Runs the $emailString in a shell. */

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

/** Sends 10 emails at a time, loops though all the recipients that were sent to this script from a html form. */
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










