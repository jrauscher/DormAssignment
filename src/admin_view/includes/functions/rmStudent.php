
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
$student = "SELECT student_ID AS ID, first_name AS 'First Name', last_name AS 'Last Name', email AS 'Email' FROM students";
$student2 = "SELECT student_ID AS ID, first_name AS 'First Name', last_name AS 'Last Name', email AS 'Email' FROM students";
$limit = 0; 
if(isset($_GET['limit']))
{
	$student.= " LIMIT ".$_GET['limit']." , 10";
	echo '<br/>';
	$limit = $_GET['limit'];
	$limit2 = $limit + 10;
	$limit3 = $limit - 10;
	if($limit > 0)
	{
		echo '<a style="align:center" class="button1" href="settings.php?page=rStudent&limit=';
		echo $limit3;
		echo '">Prev 10</a>';
	}
	echo'<a align="center" class="button1" href="settings.php?page=rStudent&limit=';
	echo $limit2;
	echo '">Next 10</a><br/><br/><br/>';
}
else
{
	$student.= " LIMIT 0, 10";
	echo '<br/>';
	echo '<a align="center" class="button1" href="settings.php?page=rStudent&limit=10">Next 10</a><br/><br/><br/>';
}
$resStudent = mysqli_query($dbconn, $student);

if( isset($_POST['email_id']) && $_POST['email_id'] != null && $_POST['email_id'] != '' ){
    $student2 .= ' WHERE email = "' . mysqli_real_escape_string($dbconn,$_POST['email_id']) .'"';
 	$resStudent = mysqli_query($dbconn, $student2);
}

?>




