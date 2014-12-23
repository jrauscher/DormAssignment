<head>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="../css/table.css" type="text/css">
</head>

<?php
	include ('../includes/svrConnect.php');

$buildingID = $_GET['building_id']; /**< The id of the building and is escaped later. */
$roomID = $_GET['room']; /**< The id of the room and is escaped later. */

$buildingID = mysql_real_escape_string($buildingID);
$roomID = mysql_real_escape_string($roomID);

$getBuildingLease = "SELECT lease FROM building WHERE build_id = '$buildingID'"; /**< SQL query to get the lease of the building. */
$result_getBuildingLease = mysqli_query($dbconn, $getBuildingLease); /**< Holds the result from the query $getBuildingLease. */
while($lease = mysqli_fetch_assoc($result_getBuildingLease))
{
	$build_lease = $lease['lease'];
}
									
$getRoomGender = "SELECT gender FROM rooms_temp WHERE build_id = '$buildingID' AND room_num = '$roomID'"; /**< SQL query to get the gender of the room. */
$result_getRoomGender = mysqli_query($dbconn, $getRoomGender); /**< Holds the result of the query $getRoomGender. */

/**
* Gets the gender of the room and assigns it to $room_gender.
*/
while($gender = mysqli_fetch_assoc($result_getRoomGender))
{
	$room_gender = $gender['gender'];
}

echo '
<script type="text/javascript">
	function reloadStudentTable(building, room, lease, gender)
	{
		$.ajax({
            type:"GET",
            url:"updateStudentTableDB.php?action=display&id=0&building_id="+building+"&room="+room,
            success: function(msg){
                $("#student_info").html(msg);
            }
        });
		if(gender == "0")
			gender = "Female";
		if(gender == "1")
			gender = "Male";
		elem = document.getElementById("displayRoomNum");
		elem.innerHTML = "Room: " + room + "<br>Lease: " + lease + " Months<br>Gender: " + gender;

	}
	
	reloadStudentTable('.$buildingID.','.$roomID.','.$build_lease.','.$room_gender.');
</script>';
?>
