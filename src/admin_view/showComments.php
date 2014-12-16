<head>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="../css/table.css" type="text/css">
</head>


<?php
	include ('../includes/svrConnect.php');

//$name = $_GET['name'];

//$name = mysql_real_escape_string($name);

/*$getGroup = "SELECT group_id FROM groups WHERE build_id = '$building' AND room_num = '$room'";
$getGroup_result = mysqli_query($dbconn, $getGroup);
echo '<br><br><br>';
while($group = mysqli_fetch_assoc($getGroup_result))
{
	foreach($group as $group_id)
	{
*/

/*echo
'
<script type="text/javascript">
alert("start of showComments()"); 
</script>

';*/


/*echo
'
<script type="text/javascript">
        var startingTable = "'.$building .'PPP'.$room.'PPP'.$group_id.'";
		//var startingTable = "st_infoID";
        var $tabs=$("#" + startingTable);
    $(document).ready(function(){
        $( "tbody.connectedSortable")
            .sortable({
                connectWith: ".connectedSortable",
                items: "> tr:not(:first)",
                appendTo: $tabs,
                helper:"clone",
                cursor:"move",
                zIndex: 999990
             })
             .disableSelection()
        ;
		//alert("startingTable: " + startingTable);
		$($tabs).droppable({
			accept: ".connectedSortable tr",
			hoverClass: "ui-state-hover",
			drop:function(event, ui){
				//alert("this is the drop inside the st_info");
				var temp = ui.draggable.attr("id").split("!");
				var studentID = temp[0];
				var startTable = temp[1];
				var desTable = $(this).attr("id");
				var temp2 = desTable.split("PPP");
				var buildingID = temp2[0];
				var roomNum = temp2[1];
				var groupID = temp2[2];
			//	alert("buildingID: " + buildingID);
			//	alert("roomNum: " + roomNum);
			//	alert("Student ID: " + studentID);
			//	alert("startTable: " + startTable);
			//	alert("This is dropped at table: " + destTable);
				//alert("testing comparison");
				if(startTable != desTable){
					//alert("they are not equal");
                    $.ajax({
                        type: "GET",
                       //url: "updateStudentTableDB.php?action=add&id=" + studentID,
                       url: "updateStudentTableDB.php?action=add&id=" + studentID + "&building_id=" + buildingID + "&room=" + roomNum + "&group=" + groupID,
                        success: function(msg){
                            $("#student_info").html(msg);
                        }
                    });
					$.ajax({
                        type: "GET",
                        url: "updateBenchDB.php?action=remove&id=" + studentID,
                        success: function(msg){
                            $("#bench").html(msg);
                        }
                    });
				}
				return false;
			}
		});
    });
</script>
';*/


$query = "SELECT student_id FROM students_temp WHERE comments IS NOT NULL";
$query_result = mysqli_query($dbconn, $query);
echo '<br><br><br>';
//echo '<table style="width:70%;" id="st_infoID" class="mytable">';
echo '<table style="width:70%;" id="commentsTable" class="mytable">';
echo '<tbody>';
echo '<tr>';
echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">First Name</th>';
echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Last Name</th>';
echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Student ID</th>';
echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Room Number</th>';
echo '<th style="min-width:200px; width:200px; max-width:700px; padding-left:0px; padding-right:0px;">Comments</th>';
echo '</tr>';
$counter = 1;
while($row = mysqli_fetch_assoc($query_result))
{
	foreach($row as $st_id)
	{
		$student_query = "SELECT first_name, last_name, student_id, room_num, comments FROM students_temp WHERE student_id = $st_id";
		$student_query_result = mysqli_query($dbconn, $student_query);
		while($studentInfo = mysqli_fetch_assoc($student_query_result))
		{
			//echo '<tr id="' . $st_id . '!st_infoID!'. $building.'!'.$room.'">';
			echo '<tr id="' . $st_id . '">';
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
					echo '<div style="height:100%; width:100%; white-space:pre-wrap; position:relative; display:inline-block;" id="' . $counter . '">';
                    echo $st_info;
                }
				elseif($counter % 5 == 4)
                {
					echo '<td class="manageCellsContent" style="padding:0px;">';
					echo '<div style="height:100%; width:100%; white-space:pre-wrap; position:relative; display:inline-block;" id="' . $counter . '">';
                    echo $st_info;
                }
				elseif($counter % 5 == 0)
				{
					echo '<td style="min-width:200px; max-width:430px; padding:0px;">';
					//echo '<div style="cursor: pointer; height:100%; width:100%; position:relative; display:inline-block;" id="' . $counter . '">';
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
/*}
}*/
#echo "Query: " .$query . "<br />";
?>
