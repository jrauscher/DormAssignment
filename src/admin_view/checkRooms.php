<head>
    <script type="text/javascript" src="java-script/newWindow.js"></script>
    <link rel="stylesheet" href="../css/table.css" type="text/css">
</head>
</script>

<?php
include ('../includes/svrConnect.php');


$action = $_GET['action'];
$studentID = $_GET['id'];
$buildingID = $_GET['building_id'];
$roomID = $_GET['room'];

$action = mysql_real_escape_string($action);
$studentID = mysql_real_escape_string($studentID);
$buildingID = mysql_real_escape_string($buildingID);
$roomID = mysql_real_escape_string($roomID);

function check_room ($std_id,$room_num,$build_id){
	include ('../includes/svrConnect.php');
    $student_info = "SELECT gender, lease FROM students_temp WHERE student_id='$std_id'";
    $room_info = "SELECT gender, num_students FROM rooms_temp WHERE room_num='$room_num' AND build_id='$build_id'";
    $build_info = "SELECT lease FROM building WHERE build_id='$build_id'";
    $std_info = mysqli_query($dbconn, $student_info);
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


$addToBench = "0";
$addToStudent = "0";
if($action == "addBench")
{
	$addToBench = "1";
}
if($action == "addStudent")
{
	
	$temp = check_room($studentID, $roomID, $buildingID);
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
