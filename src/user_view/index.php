<?php
	include ('../includes/svrConnect.php');
	include ('../includes/student_header.html');

	$result_deadline_date = mysqli_query($dbconn, "SELECT deadline_date FROM form_settings WHERE form_name='Student Form'");

	$SFdeadline;
	while($deadline = mysqli_fetch_assoc($result_deadline_date)){
		$SFdeadline = $deadline['deadline_date'];
	}
	
	$result_deadline_date = mysqli_query($dbconn, "SELECT deadline_date FROM form_settings WHERE form_name='Lease Information'");

	$LEdeadline;
	while($deadline = mysqli_fetch_assoc($result_deadline_date)){
		$LEdeadline = $deadline['deadline_date'];
	}
?>

<div class ="content">
<div id = "home" style="height: 100%"> 
	<div id = "welcome" style="height: 100%">
		<h3>Welcome!</h3>
			<p style="padding-left:50px">
				Please fill out your submission form if you haven't already and submit the form so you can be assigned to a room.<br/><br/> If you have already filled out the form once submitting it again will update the information we have.<br/>Resubmitting does not change the initial submission date. 
			</p>
			<br/><br/>

			<table class="vtable" style="overflow:hidden">
				<tr>
					<td><h4>Form Deadline:</h4></td>
					<td><p><?php echo $SFdeadline ?></p></td>
				</tr><tr>
					<td><h4>Lease Deadline:</h4></td>
					<td><p><?php echo $LEdeadline ?></p></td>
				</tr>
			</table>
	</div>	
</div>

<?php
	include ('../includes/footer.html');
?>

