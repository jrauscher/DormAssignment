
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
$users = "SELECT student_id AS ID, username AS Username FROM users";
$users2 = "SELECT student_id AS ID, username AS Username FROM users";
$limit = 0; 
if(isset($_GET['limit']))
{
	$users.= " LIMIT ".$_GET['limit']." , 10";
	echo '<br/>';
	$limit = $_GET['limit'];
	$limit2 = $limit + 10;
	$limit3 = $limit - 10;
	if($limit > 0)
	{
		echo '<a class="button1" href="settings.php?page=rAccounts&limit=';
		echo $limit3;
		echo '">Prev 10</a>';
	}
	echo'<a class="button1" href="settings.php?page=rAccounts&limit=';
	echo $limit2;
	echo '">Next 10</a><br/><br/><br/>';
}
else
{
	$users.= " LIMIT 0, 10";
	echo '<br/>';
	echo '<a class="button1" href="settings.php?page=rAccounts&limit=10">Next 10</a><br/><br/><br/>';
}

$resUsers = mysqli_query($dbconn, $users);

if( isset($_POST['username']) && $_POST['username'] != null && $_POST['username'] != '' ){
     $users2 .= ' WHERE username = "' . mysqli_real_escape_string($dbconn,$_POST['username']) .'"';
     $resUsers = mysqli_query($dbconn, $users2);
}

?>


