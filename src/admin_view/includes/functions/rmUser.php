
 <br><br><font size=5>Remove User</font><br/><br/>
<form action="validate/remove.php" method="post">
	<table>
     	<tr>
       		<th align="right">Student ID:</th>
      		<th><input name="student_id" type="text" required></input></th>
			<th><input type="hidden" name="type" value="users"></input></th>
    	</tr>
		<tr>
			<th align="left"> <input class="button1" type="submit" value="Remove User" /></th>
		</tr>
			</th>
	</table>
</form>		
<br/><br/>
<form action="" method="post">
	<table>
		<tr>
			<th><label for="username">Search for user(by username):</label>
    		<th><input name="username" /></th>

		    <th><input class="button1" type="submit" value="Submit" /></th>
	</tr>
	<table>
</form>
<br/>

<?php 
if( isset($_POST['username']) && $_POST['username'] != null && $_POST['username'] != '' ){
     $users .= ' WHERE username = "' . mysqli_real_escape_string($dbconn,$_POST['username']) .'"';
     $resUsers = mysqli_query($dbconn, $users);
}

?>


