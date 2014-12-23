<head>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="../css/table.css" type="text/css">
</head>

<?php
	include ('../includes/svrConnect.php');


$name = $_GET['name']; /**< The first name of the student being searched for and is later escaped. */
$name = mysql_real_escape_string($name);

$getStudentByName = "SELECT student_id, build_id, room_num FROM students_temp WHERE first_name = '$name'"; /**< SQL query to retrieve information about the student based on the name. */
$result_getStudentName = mysqli_query($dbconn, $getStudentByName); /**< Holds the result of the query $getStudentByName. */
$st_id = -1; /**< The id for the student which is retrieved later. */
$building = -1; /**< The id for the building which is retrieved later. */
$room = -1; /**< The id for the room which is retrieved later. */

while ($row = mysqli_fetch_assoc($result_getStudentName))
{
	$st_id    = $row['student_id'];
	$building = $row['build_id'];
	$room     = $row['room_num'];
}

$getBuildingLease = "SELECT lease FROM building WHERE build_id = '$building'"; /**< SQL query to get the lease from the building table. */
$result_getBuildingLease = mysqli_query($dbconn, $getBuildingLease); /**< Holds the result from the query $getBuildingLease. */
while($lease = mysqli_fetch_assoc($result_getBuildingLease))
{
	$build_lease = $lease['lease'];
}
									
$getRoomGender = "SELECT gender FROM rooms_temp WHERE build_id = '$building' AND room_num = '$room'"; /**< SQL query to get the gender from the temporary rooms table. */

$result_getRoomGender = mysqli_query($dbconn, $getRoomGender); /**< Holds the result from the query $getRoomGender. */
while($gender = mysqli_fetch_assoc($result_getRoomGender))
{
	$room_gender = $gender['gender'];
}

echo '
<script type="text/javascript">
	function reloadStudentTable(st_id, building, room, lease, gender)
	{
		$.ajax({
            type:"GET",
            url:"updateStudentTableDB.php?action=display&id="+st_id+"&building_id="+building+"&room="+room,
            success: function(msg){
                $("#student_info").html(msg);
            }
        });
		collapseTree("tree");
		expandToItem("tree", building + "!" + room);
		if(gender == "0")
			gender = "Female";
		if(gender == "1")
			gender = "Male";
		elem = document.getElementById("displayRoomNum");
		elem.innerHTML = "Room: " + room + "<br>Lease: " + lease + " Months<br>Gender: " + gender;

	}
	if( '.$st_id.' != -1 && '.$building.' != -1 && '.$room.' != -1)
	{
		reloadStudentTable('.$st_id.','.$building.','.$room.','.$build_lease.','.$room_gender.');
	}
	else
	{
		alert("'.$name.' did not return any valid results.");
	}
</script>';
?>
