<head>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="../css/table.css" type="text/css">
</head>

<?php
	include ('../includes/svrConnect.php');

$room = $_GET['room'];
$building = $_GET['building'];
$newLetter = $_GET['newLetter'];
$oldLetter = $_GET['oldLetter'];
$st_id = $_GET['st_id'];
//$group = $_GET['group'];

$room = mysql_real_escape_string($room);
$building = mysql_real_escape_string($building);
$newLetter = mysql_real_escape_string($newLetter);
$oldLetter = mysql_real_escape_string($oldLetter);
$st_id = mysql_real_escape_string($st_id);
//$group = mysql_real_escape_string($group);

//$TempChangeOtherStudent = "UPDATE room_letter_temp SET letter='0' WHERE build_id=$building AND room_num=$room AND letter=$newLetter";
$TempChangeOtherStudent = "UPDATE room_letter_temp SET letter='$oldLetter' WHERE build_id='$building' AND room_num='$room' AND letter='$newLetter'";
//$ChangeCurrentStudent = "UPDATE room_letter_temp SET letter=$newLetter WHERE build_id=$building AND room_num=$room AND letter=$oldLetter";
$ChangeCurrentStudent = "UPDATE room_letter_temp SET letter='$newLetter' WHERE student_id='$st_id'";
//$ChangeOtherStudent = "UPDATE room_letter_temp SET letter=$oldLetter WHERE build_id=$building AND room_num=$room AND letter='0'";
//echo '<script type="text/javascript">alert("oldLetter: '.$oldLetter.'\nnewLetter: '.$newLetter.'"); </script>';
$test = 0;
mysqli_query($dbconn, $TempChangeOtherStudent) or $test = 1;
mysqli_query($dbconn, $ChangeCurrentStudent) or $test = 2;
//mysqli_query($dbconn, $ChangeOtherStudent) or $test = 3;



echo '
<script type="text/javascript">
	function reloadStudentTable(st_id, building, room)
	{
		$.ajax({
            type:"GET",
            url:"updateStudentTableDB.php?action=display&id="+st_id+"&building_id="+building+"&room="+room,
            success: function(msg){
                $("#student_info").html(msg);
            }
        });
	}
	reloadStudentTable('.$st_id.','.$building.','.$room.');
</script>';
?>
