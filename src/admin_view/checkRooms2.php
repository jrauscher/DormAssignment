<head>
    <script type="text/javascript" src="java-script/newWindow.js"></script>
    <link rel="stylesheet" href="../css/table.css" type="text/css">
</head>
</script>

<?php
include ('../includes/svrConnect.php');


$action = $_GET['action']; /**< Determines what information should be generated and is later escaped. */
$studentID = $_GET['id']; /**<  The id of the student and is later escaped. */
$buildingID = $_GET['building_id']; /**< The id of the building and is later escaped. */
$roomID = $_GET['room']; /**< The id of the room and is later escaped. */

$action = mysql_real_escape_string($action);
$studentID = mysql_real_escape_string($studentID);
$buildingID = mysql_real_escape_string($buildingID);
$roomID = mysql_real_escape_string($roomID);

/**
* A function to determine whether or not a student is able to be placed in the room.
*
* It checks if the room is full, if the genders of the students in the room match the new student's, and if the lease of the room matches the new student's lease.
*/
function check_room2 ($std_id,$room_num,$build_id){
	include ('../includes/svrConnect.php');
    $student_info = "SELECT gender, lease FROM students_temp WHERE student_id='$std_id'"; /** A query to get the gender and lease information from the temporary students table of the new student. */
    $room_info = "SELECT gender, num_students FROM rooms_temp WHERE room_num='$room_num' AND build_id='$build_id'"; /** A query to get the gender and the number of students from the temporary rooms table of the students in the room. */
    $build_info = "SELECT lease FROM building WHERE build_id='$build_id'"; /** A query to get the lease information from the building table for the room. */
    $std_info = mysqli_query($dbconn, $student_info); /** Holds the result of running the @var student_info   */
	$r_info = mysqli_query($dbconn, $room_info);
    $b_info = mysqli_query($dbconn, $build_info);
    $sGender ="";
    $sLease = "";
    $rLease = "";
    $rGender = "";
    $rFull = "";
    while ($row = mysqli_fetch_array($std_info)) {
       	$sGender = $row['gender'];
        $sLease = $row['lease'];
    }
    while ($row = mysqli_fetch_array($r_info)) {
        $rGender = $row['gender'];
        $rFull = $row['num_students'];
    }
    while ($row = mysqli_fetch_array($b_info)) {
        $rLease = $row['lease'];
    }

    if(($sGender == $rGender)&&($sLease == $rLease)&&($rFull != 4)){
        return 1;
    }
    if(($rFull == 0)&&($sLease == $rLease)){
        $up_room_gen = "UPDATE `rooms` SET `gender`='$sGender' WHERE room_num='$room_num' AND build_id='$build_id'";
        $up_room_gen2 = mysqli_query($dbconn, $up_room_gen);
        return 1;
    }
    else{
		$msg = 'ERROR \n';
		if($sGender != $rGender){
			$msg .= 'There is a gender conflict.\n';
		}
		if($sLease != $rLease){
			$msg .= 'There is a lease conflict.\n';
		}
		if($rFull == 4){
			$msg .= 'The room is full.\n';
		}
		echo '<script type="text/javascript">var msg = "'.$msg.'"; alert(msg);</script>';
        return 0;
    }
}


$addToBench = "0"; /**< Determines if the student is attempting to be added to the bench  */
$addToStudent = "0"; /**< Determines if the student is attempting to be added to the student table */

/**
* If the $action is "addBench", set $addToBench to 1.
*/
if($action == "addBench")
{
	$addToBench = "1";
}

/**
*
* If the $action is "addStudent", set $addToStudent to 1 if the student can successfully be added to the room, otherwise set it to 2.
*/
if($action == "addStudent")
{
	
	$temp = check_room2($studentID, $roomID, $buildingID);
	if($temp)
	{
		$addToStudent = "1";
	}
	else
	{
		$addToStudent = "2";
	}
}


echo  '
<script type=text/javascript>
	var studentID = '.$studentID.';
	var buildingID = '.$buildingID.';
	var roomID = '.$roomID.';
	var addToStudent = '.$addToStudent.';
	var addToBench = '.$addToBench.';
	if(addToBench=="1")
	{
    	$.ajax({
            type:"GET",
            url: "updateBenchDB.php?action=add&id=" + studentID,
            success: function(msg){
                $("#bench").html(msg);
            }
        });
        $.ajax({
        	type:"GET",
            url: "updateStudentTableDB.php?action=remove&id=" + studentID + "&building_id=" + buildingID + "&room=" + roomID,
            success: function(msg){
                $("#student_info").html(msg);
            }
        });
	}
	else if (addToStudent=="1")
	{
		$.ajax({
            type:"GET",
            url: "updateStudentTableDB.php?action=add&id=" + studentID + "&building_id=" + buildingID + "&room=" + roomID,
            success: function(msg){
                $("#student_info").html(msg);
            }
        });
        $.ajax({
            type:"GET",
            url: "updateBenchDB.php?action=remove&id=" + studentID,
            success: function(msg){
                $("#bench").html(msg);
            }
        });
	}
	else if (addToStudent=="2")
	{
		$.ajax({
            type:"GET",
            url: "updateStudentTableDB.php?action=display&id=" + studentID + "&building_id=" + buildingID + "&room=" + roomID,
            success: function(msg){
                $("#student_info").html(msg);
            }
        });
        $.ajax({
            type:"GET",
            url: "updateBenchDB.php?action=display&id=" + studentID,
            success: function(msg){
                $("#bench").html(msg);
            }
        });
	}
</script>
';

?>
