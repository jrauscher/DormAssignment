
<br><br><font size=5>Remove Student</font><br/><br/>
<form action="validate/remove.php" method="post">
	<table>
		<tr>
			<th><input for="student_id" type="hidden">Student ID to remove:</input></th>
			<th><input name="student_id"></input></th>
			<th><input type="hidden" name="type" value="students"></input></th>
		</tr>
		<tr>
			<th align="left"> <input class="button1" type="submit" value="Submit" /></th>
		</tr>
	</table>
</form>
<br/><br/>
<form action="" method="post">
	<table>
		<tr>
			<th><label for="email">Search for student(by email):</label>
    		<th><input name="email_id" /></th>

		    <th><input class="button1" type="submit" value="Submit" /></th>
	</tr>
	<table>
</form>

<?php 
if( isset($_POST['email_id']) && $_POST['email_id'] != null && $_POST['email_id'] != '' ){
     $student .= ' WHERE email = "' . mysqli_real_escape_string($dbconn,$_POST['email_id']) .'"';
	 echo "$student";
     $resStudent = mysqli_query($dbconn, $student);
}

?>




