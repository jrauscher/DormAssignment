<head>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="../css/table.css" type="text/css">
</head>

</script>

<?php
include ('../includes/svrConnect.php');

$action = $_GET['action']; /**< Determines what information should be displayed and is escaped later. */
$st_id = $_GET['id']; /**< The id of the student and is escaped later. */

$action = mysql_real_escape_string($action);
$st_id = mysql_real_escape_string($st_id);

/**
* If $action is "add", the student will be added to the bench table.
*
* If $action is "remove", the student will removed from the bench table.
*/
if($action == "add")
{
	$addStudentToBench = "INSERT INTO bench_temp (`student_id`) VALUES ('$st_id')";
	mysqli_query($dbconn, $addStudentToBench);
}

if($action == "remove")
{
	$removeStudentFromBench = "DELETE FROM bench_temp WHERE student_id='$st_id'";
	mysqli_query($dbconn, $removeStudentFromBench);
}

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
</script>

<?php


	echo '<table id="benchTable" class="mytable">';
	//echo '<tbody class="connectedSortable">';
	echo '<thead>';
	echo '<tr>';
	echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">First Name</th>';
	echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Last Name</th>';
	echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Student ID</th>';
	echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Room Number</th>';
	echo '<th style="min-width:200px; width:200px; max-width:700px; padding-left:0px; padding-right:0px;">Comments</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody class="connectedSortable">';
	echo '<tr>';
	echo '</tr>';
	$query = "SELECT student_id FROM bench_temp"; /**< SQL query to get the student's id from the temporary bench table. */
	$query_result = mysqli_query($dbconn, $query); /**< Holds the result from the query $query. */
	$counter = 1; /**< A counter to help assign IDs to the cells in the generated table */
while($row = mysqli_fetch_assoc($query_result))
{
	foreach($row as $st_id)
	{
		$query2 = "SELECT first_name, last_name, student_id, room_num, comments FROM students_temp WHERE student_id = '$st_id'";
		$query_result2 = mysqli_query($dbconn, $query2);

	while($studentInfo = mysqli_fetch_assoc($query_result2))
	{
				echo '<tr id="' . $st_id . '!0!0">';
		foreach($studentInfo as $st_info)
		{
			if($counter % 5 == 1)
                {
                    echo '<td class="manageCellsContent" style="padding:0px;">';
                    echo '<div class="scrollText" id="' . $counter . '">';
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
                    echo '<div style="height:100%; width:100%; white-space:pre-wrap; position:relative; display    :inline-block;" id="' . $counter . '">';
                    echo $st_info;
                }
                elseif($counter % 5 == 4)
                {
					echo '<td class="manageCellsContent" style="padding:0px;">';
					echo '<div style="height:100%; width:100%; white-space:pre-wrap; position:relative; display:inline-block;" id="' . $counter . '">';
					echo '<select id="'.$counter.'selectLetter">';
					echo '<option value="N/A" selected="selected">N/A</option>';
					echo '</select>';		
				
					
                    /*echo '<td class="manageCellsContent" style="padding:0px;">';
                    echo '<div style="height:100%; width:100%; white-space:pre-wrap; position:relative; display    :inline-block;" id="' . $counter . '">';
                    echo $st_info;*/
                }
                elseif($counter % 5 == 0)
                {
                    echo '<td style="min-width:200px; max-width:430px; padding:0px;">';
                    //echo '<div style="cursor: pointer; height:100%; width:100%; position:relative; display:in    line-block;" id="' . $counter . '">';
					$temp = $counter - 2;
                    echo '<div class="shortText" onclick="displayText(document.getElementById(' . $temp . '),' . $counter . ');" id="'     . $counter . '"title="0">';
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

