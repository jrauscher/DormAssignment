<head>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="../css/table.css" type="text/css">
</head>

<?php
	include ('../includes/svrConnect.php');
	//include ('includes/algo/check_room.php');

$room = $_GET['room']; /**< The room the student is trying to be added to and is escaped later. */
$building = $_GET['building_id']; /**< The building the student is trying to be added to and is escaped later. */
$action = $_GET['action']; /**< Determines what information to be generated and is escaped later. */
$st_id = $_GET['id']; /**< The id of the student that is trying to be added and is escaped later. */

$room = mysql_real_escape_string($room);
$building = mysql_real_escape_string($building);
$action = mysql_real_escape_string($action);
$st_id = mysql_real_escape_string($st_id);

$getStudentLetter = "SELECT letter FROM room_letter_temp WHERE student_id = '$st_id'"; /**< SQL query to get the letter of the student from the temporary room_letter table. */
$result_getStudentLetter = mysqli_query($dbconn, $getStudentLetter); /**< Holds the result of the query $getStudentLetter. */
$st_letter = ""; /**< Creation of the variable that will hold the letter of the room the student is staying in. */
while($letter = mysqli_fetch_assoc($result_getStudentLetter))
{
	$st_letter = $letter['letter'];
}

$result_group = mysqli_query($dbconn, "SELECT group_id FROM groups_temp WHERE build_id = '" . $building . "' AND room_num = '" . $room . "';"); /**< Holds the result of the query that finds the id of the group for the room that the student is staying in. */
$group = 0; /**< Sets the default group id to be 0 */

/**
* Gets the real value of the group id
*/

while($group_num = mysqli_fetch_assoc($result_group))
{
	$group = $group_num['group_id'];
	//echo '<script type="text/javascript">alert("Group: '.$group.'"); </script>';
	//$group = $building;
}

//if(($action=="add" or $action=="remove") and check_room($st_id, $room, $building)){

/**
* 
* If $action is "add", then the student will be added to the temporary students table. If there are no others already in the room, a group id will be generated for it. A letter will also be assigned to the student
*/
if($action == "add")
{
	if($group == 0){
		$group = $building . $room;
		$createGroup = "INSERT INTO groups_temp (group_id, build_id, room_num, student_id_1, student_id_2, student_id_3, student_id_4) VALUES ($group, $building, $room, 0, 0, 0, 0)";
		mysqli_query($dbconn, $createGroup);
	}

	$addStudentToStudentsTable = "UPDATE students_temp SET group_id='$group' WHERE student_id='$st_id'";
	$addRoomNumToStudentsTable = "UPDATE students_temp SET room_num='$room' WHERE student_id='$st_id'";
	$addStudent1ToGroups = "UPDATE groups_temp SET student_id_1='$st_id' WHERE student_id_1='0'";
	$addStudent2ToGroups = "UPDATE groups_temp SET student_id_2='$st_id' WHERE student_id_2='0'";
	$addStudent3ToGroups = "UPDATE groups_temp SET student_id_3='$st_id' WHERE student_id_3='0'";
	$addStudent4ToGroups = "UPDATE groups_temp SET student_id_4='$st_id' WHERE student_id_4='0'";
	$getFreeSpace = "SELECT student_id_1, student_id_2, student_id_3, student_id_4 FROM groups_temp WHERE (student_id_1='0' OR student_id_2='0' OR student_id_3='0' OR student_id_4='0') AND group_id='$group'";
	$result_getFreeSpace = mysqli_query($dbconn, $getFreeSpace);
	while($row = mysqli_fetch_assoc($result_getFreeSpace))
	{
		if($row['student_id_1'] == 0)
		{
			mysqli_query($dbconn, $addStudentToStudentsTable);
			mysqli_query($dbconn, $addStudent1ToGroups);
			mysqli_query($dbconn, $addRoomNumToStudentsTable);	
			//echo '<script type="text/javascript">alert("Student1"); </script>';
		}
		elseif($row['student_id_2'] == 0)
		{
			mysqli_query($dbconn, $addStudentToStudentsTable);
			mysqli_query($dbconn, $addStudent2ToGroups);
			mysqli_query($dbconn, $addRoomNumToStudentsTable);	
			//echo '<script type="text/javascript">alert("Student2"); </script>';
		}
		elseif($row['student_id_3'] == 0)
		{
			mysqli_query($dbconn, $addStudentToStudentsTable);
			mysqli_query($dbconn, $addStudent3ToGroups);
			mysqli_query($dbconn, $addRoomNumToStudentsTable);	
			//echo '<script type="text/javascript">alert("Student3"); </script>';
		}
		elseif($row['student_id_4'] == 0)
		{
			mysqli_query($dbconn, $addStudentToStudentsTable);
			mysqli_query($dbconn, $addStudent4ToGroups);
			mysqli_query($dbconn, $addRoomNumToStudentsTable);	
			//echo '<script type="text/javascript">alert("Student4"); </script>';
		}
	}
	$getNumStudents = "SELECT num_students FROM rooms_temp WHERE group_id='$group'";
	$result_getNumStudents = mysqli_query($dbconn, $getNumStudents);
	while($row = mysqli_fetch_assoc($result_getNumStudents))
	{
		$num = $row['num_students'];
		$num = $num + 1;
		$updateNumStudents = "UPDATE rooms_temp SET num_students='$num' WHERE group_id='$group'";
		mysqli_query($dbconn, $updateNumStudents);
	}

	$getLetters = "SELECT letter FROM room_letter_temp WHERE room_num = '$room' AND build_id = '$building' AND student_id = '0'";
	$result_getLetters = mysqli_query($dbconn, $getLetters);
	$tmp_letter = 'B';
	$letter_arr = (array) null;
	while($room_ltr = mysqli_fetch_assoc($result_getLetters))
	{
		$tmp_letter = $room_ltr['letter'];
	}

	$updateStudentIDLetterTemp = "UPDATE room_letter_temp SET student_id = '$st_id' WHERE room_num= '$room' AND build_id = '$building' AND letter = '$tmp_letter'";	
	mysqli_query($dbconn, $updateStudentIDLetterTemp);

}

/**
*
* If $action is "remove", remove the student from the temporary students table. */
*/
elseif($action == "remove")
{
	$removeStudentFromTable = "UPDATE students_temp SET group_id='0' WHERE student_id='$st_id'";
	$removeStudent1FromGroups = "UPDATE groups_temp SET student_id_1='0' WHERE student_id_1='$st_id'";
	$removeStudent2FromGroups = "UPDATE groups_temp SET student_id_2='0' WHERE student_id_2='$st_id'";
	$removeStudent3FromGroups = "UPDATE groups_temp SET student_id_3='0' WHERE student_id_3='$st_id'";
	$removeStudent4FromGroups = "UPDATE groups_temp SET student_id_4='0' WHERE student_id_4='$st_id'";
	$removeStudentFromRoomLetter = "UPDATE room_letter_temp SET student_id ='0' WHERE room_num = '$room' AND build_id='$building' AND letter='$st_letter'";
	//$removeLetterFromRoomLetter = "UPDATE room_letter_temp SET letter =' 0' WHERE student_id='$st_id'";
	//$removeRoomNumFromRoomLetter = "UPDATE room_letter_temp SET room_num = '0' WHERE student_id='$st_id'";
	//$removeBuildIDFromRoomLetter = "UPDATE room_letter_temp SET build_id = '0' WHERE student_id='$st_id'";
	
	mysqli_query($dbconn, $removeStudentFromTable);
	mysqli_query($dbconn, $removeStudent1FromGroups);
	mysqli_query($dbconn, $removeStudent2FromGroups);
	mysqli_query($dbconn, $removeStudent3FromGroups);
	mysqli_query($dbconn, $removeStudent4FromGroups);
	mysqli_query($dbconn, $removeStudentFromRoomLetter);
	//mysqli_query($dbconn, $removeLetterFromRoomLetter);
	//mysqli_query($dbconn, $removeRoomNumFromRoomLetter);
	//mysqli_query($dbconn, $removeBuildIDFromRoomLetter);


	$getNumStudents = "SELECT num_students FROM rooms_temp WHERE group_id='$group'";
	$result_getNumStudents = mysqli_query($dbconn, $getNumStudents);
	while($row = mysqli_fetch_assoc($result_getNumStudents))
	{
		$num = $row['num_students'];
		$num = $num - 1;
		$updateNumStudents = "UPDATE rooms_temp SET num_students='$num' WHERE group_id='$group'";
		mysqli_query($dbconn, $updateNumStudents);
	}
	
}
//}
?>

<script type="text/javascript">
    $(document).ready(function(){
        $("tbody.connectedSortable").sortable({
            connectWith: ".connectedSortable",
            helper: "clone",
            cursor: "move",
            zIndex: 99999,
            receive: function(event, ui) {
                var addedTo = $(this).closest("table.mytable");
                var removedFrom = $("table.mytable").not(addedTo);
                var temp = ui.item[0].id.split("!");
                var studentID = temp[0];
                var buildingID = temp[1];
                var roomID = temp[2];
                //var groupID = temp[3];
				var temp2 = addedTo.attr("id").split("!");
                var buildingID2 = temp2[0];
                var roomID2 = temp2[1];
                if(addedTo.attr("id") == "benchTable")
                {
					$.ajax({
                        type:"GET",
                       url: "checkRooms2.php?action=addBench&id=" + studentID + "&building_id=" + buildingID + "&room=" + roomID,
                        success: function(msg){
                            $("#uselessDiv").html(msg);
                        }
                   });
                }
                else //(addedTo.attr("id") == "studentTable")
                {
					$.ajax({
                        type:"GET",
                       url: "checkRooms2.php?action=addStudent&id=" + studentID + "&building_id=" + buildingID2 + "&room=" + roomID2,
                        success: function(msg){
                            $("#uselessDiv").html(msg);
                        }
                   });
				}
            }
        });
    });

function switchLetters(oldLetter, elementValue, st_id, building, room)
{
	var newLetter = document.getElementById(elementValue).value;
	if(oldLetter != newLetter)
    {
		//alert("this is adding to the benchTable");
        $.ajax({
        	type:"GET",
        	url:"updateStudentLetter.php?oldLetter="+oldLetter+"&newLetter="+newLetter+"&st_id="+st_id+"&building="+building+"&room="+room,
        	success: function(msg){
        		$("#uselessDiv").html(msg);
        	}
        });

}

function displayMoreInfo(id)
{
	$.ajax({
        	type:"GET",
        	url:"displayStudentInfo.php?id="+id,
        	success: function(msg){
        		$("#light").html(msg);
        	}
        });
	
	document.getElementById('light').style.display='block';
	document.getElementById('fade').style.display='block';
	
}

</script>
<?php

//echo '<script type="text/javascript">alert("Building: '.$building.'\nRoom: '.$room.'\nGroup: '.$group.'"); </script>';

$availStudents = False;
if($building==0 and $room==0 and $group==0)
{
	$query = "SELECT student_id FROM students_temp WHERE group_id='0' AND room_num='0' AND build_id='0'";
	$is_valid = $query;
	$availStudents = True;
}
else
{
	$query = "SELECT student_id_1, student_id_2, student_id_3, student_id_4 FROM groups_temp WHERE build_id = '$building' AND room_num = '$room' AND group_id = '$group'";
	$is_valid = "SELECT * FROM rooms_temp WHERE room_num='$room' AND build_id = '$building'";
	$availStudents = False;
}
$query_result = mysqli_query($dbconn, $query); /**< Holds the result of the query $query. */
$result_is_valid = mysqli_query($dbconn, $is_valid); /**< Holds the result of the query $is_valid. */
if(mysqli_num_rows($result_is_valid)){
echo '<table style="width:70%;" id="'.$building.'!'.$room.'" class="mytable">';
echo '<thead>';
echo '<tr>';
echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">First Name</th>';
echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Last Name</th>';
echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Student ID</th>';
echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Room Letter</th>';
echo '<th style="min-width:200px; width:200px; max-width:700px; padding-left:0px; padding-right:0px;">Comments</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody class="connectedSortable">';
echo '<tr>';
echo '</tr>';
}
else
{
	echo '<script type="text/javascript">alert("'.$room.' does not exist within this building."); </script>';	
}
$counter = 1;

/**
* Creates the table that will display all of the students that are in the specified room.
*/
while($row = mysqli_fetch_assoc($query_result))
{
	foreach($row as $st_id)
	{
		
		//$student_query = "SELECT first_name, last_name, student_id, room_num, comments FROM students_temp WHERE student_id = '$st_id'";
		if($availStudents)
		{
			$student_query = "SELECT first_name, last_name, student_id, comments FROM students_temp WHERE student_id = '$st_id'";
		}
		else
		{
			$student_query = "SELECT X.first_name, X.last_name, X.student_id, Y.letter, X.comments FROM students_temp X, room_letter_temp Y WHERE X.room_num = Y.room_num AND X.student_id = '$st_id' AND Y.student_id = '$st_id' ORDER BY Y.letter";
		}
		$student_query_result = mysqli_query($dbconn, $student_query);
		while($studentInfo = mysqli_fetch_assoc($student_query_result))
		{
			echo '<tr id="' . $st_id . '!'. $building.'!'.$room.'">';
			foreach($studentInfo as $st_info)
			{
				
				if($counter % 5 == 1)
				{
					echo '<td class="manageCellsContent" style="padding:0px;">';
					$temp = "'" . $st_id . "'";
					echo '<div class="scrollText" id="' . $counter . '" onclick="displayMoreInfo('.$temp.');">';
					echo $st_info;
				}
                elseif($counter % 5 == 2)
                {
					echo '<td class="manageCellsContent" style="padding:0px;">';
					echo '<div class="scrollText" id="' . $counter . '">';
                    echo $st_info;
                }
            elseif($counter % 5 == 3)
                {
					echo '<td class="manageCellsContent" style="padding:0px;">';
					echo '<div style="height:100%; width:100%; white-space:pre-wrap; position:relative; display:inline-block;" id="' . $counter . '">';
				
					
                    echo $st_info;
					echo '</div>';
					echo '</td>';
					if($availStudents)
					{
						$counter = $counter + 1;
						echo '<td class="manageCellsContent" style="padding:0px;">';
						echo '<div style="height:100%; width:100%; white-space:pre-wrap; position:relative; display:inline-block;" id="' . $counter . '">';
						echo '<select id="'.$counter.'selectLetter">';
						echo '<option value="N/A" selected="selected">N/A</option>';
						echo '</select>';
					

					}
                }
				elseif($counter % 5 == 4)
                {

					echo '<td class="manageCellsContent" style="padding:0px;">';
					echo '<div style="height:100%; width:100%; white-space:pre-wrap; position:relative; display:inline-block;" id="' . $counter . '">';
                   	$temp_st_info = "'$st_info'";
					$temp_element = "'$counter"."selectLetter'";
					//echo '<script type="text/javascript">alert("'.$st_id.': '.$st_info.'"); </script>';
					echo '<select id="'.$counter.'selectLetter" onchange="switchLetters('.$temp_st_info.','.$temp_element.','.$st_id.','.$building.','.$room.');">';
					echo '<option value="A"';
					if($st_info == 'A') 
						echo ' selected="selected"';
					echo '>A</option>';
					
					echo '<option value="B"';
					if($st_info == 'B') 
						echo ' selected="selected"';
					echo '>B</option>';
					
					echo '<option value="C"';
					if($st_info == 'C') 
						echo ' selected="selected"';
					echo '>C</option>';

					echo '<option value="D"';
					if($st_info == 'D') 
						echo ' selected="selected"';
					echo '>D</option>';
					
					echo '<\select>';	
					echo $st_info;
                }
				elseif($counter % 5 == 0)
				{
					echo '<td style="min-width:200px; max-width:430px; padding:0px;">';
					echo '<div class="shortText" onclick="displayText(' . $st_id . ',' . $counter . ');" id="' . $counter . '"title="0">';	
					echo $st_info;
					echo '</div>';
				}
				echo '</div>';
				echo '</td>';
				$counter++;
			}
	echo '</tr>';
		}
	}
}
echo '</tbody>';
echo '</table>';
?>
