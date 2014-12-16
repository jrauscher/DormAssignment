<head>
    <script type="text/javascript" src="java-script/newWindow.js"></script>
    <link rel="stylesheet" href="../css/table.css" type="text/css">
</head>
</script>

<?php
include ('../includes/svrConnect.php');


$studentID = $_GET['id'];
$studentID = mysql_real_escape_string($studentID);

$getStudentInfo = "SELECT student_id, build_id, gender, birthdate, cell_phone, home_phone, email, age, address, city, state, zip, lease, renewal, scott_scholar FROM students_temp WHERE student_id = '$studentID'";
$result_getStudentInfo = mysqli_query($dbconn, $getStudentInfo);

$getName = "SELECT first_name, last_name FROM students_temp WHERE student_id = '$studentID'";
$result_getName = mysqli_query($dbconn, $getName);
while($st_name = mysqli_fetch_assoc($result_getName))
{
	$fName = $st_name['first_name'];
	$lName = $st_name['last_name'];
}

echo '<div id="displayName" style="height:50px; width: 100%; text-align: center; font-size: 20ps">';
echo $fName.' '. $lName;
echo '</div>';
echo '<table class="mytable">';
echo '<thead>';
echo '<tr>';
echo '<th>Student ID</th>';
echo '<th>Building</th>';
echo '<th>Gender</th>';
echo '<th>Birthdate</td>';
echo '<th>Cell Phone Number</th>';
echo '<th>Home Phone Number</th>';
echo '<th>Email Address</th>';
echo '<th>Age</th>';
echo '<th>Address</th>';
echo '<th>City</th>';
echo '<th>State</th>';
echo '<th>ZIP</th>';
echo '<th>Months of Lease</th>';
echo '<th>Is Renewing</th>';
echo '<th>Is A Scott Scholar</th>';
echo '</tr>';
echo '</thead>';
while($info = mysqli_fetch_assoc($result_getStudentInfo))
{
	echo '<tr>';
	foreach($info as $st_info)
	{
		echo '<td>';
		echo $st_info;
		echo '</td>';
	}
	echo '</tr>';
}
echo '</table>';



echo  '
<script type=text/javascript>
var light = "light";
var showNone = "none";
var fade = "fade";

</script>
';

?>
