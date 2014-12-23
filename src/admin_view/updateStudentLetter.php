<head>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="../css/table.css" type="text/css">
</head>

<?php
	include ('../includes/svrConnect.php');

$room = $_GET['room']; /**< The room that the student is in and is escaped later. */
$building = $_GET['building']; /**< The building id that the student is in and is escaped later. */
$newLetter = $_GET['newLetter']; /**< The letter that the student is changing to and is escaped later. */
$oldLetter = $_GET['oldLetter']; /**< The letter that the student was and is escaped later. */
$st_id = $_GET['st_id']; /**< The id of the student and is escaped later. */

$room = mysql_real_escape_string($room);
$building = mysql_real_escape_string($building);
$newLetter = mysql_real_escape_string($newLetter);
$oldLetter = mysql_real_escape_string($oldLetter);
$st_id = mysql_real_escape_string($st_id);

$TempChangeOtherStudent = "UPDATE room_letter_temp SET letter='$oldLetter' WHERE build_id='$building' AND room_num='$room' AND letter='$newLetter'"; /**< SQL query to change the student that has the requested $newLetter to the $oldLetter. */
$ChangeCurrentStudent = "UPDATE room_letter_temp SET letter='$newLetter' WHERE student_id='$st_id'"; /**< SQL query to change the student's letter from $oldLetter to $newLetter. */
$test = 0; /**< Variable to prevent the code from failing */
mysqli_query($dbconn, $TempChangeOtherStudent) or $test = 1;
mysqli_query($dbconn, $ChangeCurrentStudent) or $test = 2;



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
