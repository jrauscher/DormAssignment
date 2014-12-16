<head>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="../css/table.css" type="text/css">
</head>

</script>

<?php
include ('../includes/svrConnect.php');
/*
echo
'
<script type="text/javascript">
        var startingTable = "benchID";
        var $val=$("#" + startingTable);
    $(document).ready(function(){
        $( "tbody.connectedSortable")
            .sortable({
                connectWith: ".connectedSortable",
                items: "> tr:not(:first)",
                appendTo: $val,
                helper:"clone",
                cursor:"move",
                zIndex: 999990
             })
             .disableSelection()
        ;
		$($val).droppable({
			accept: ".connectedSortable tr",
			hoverClass: "ui-state-hover",
			drop:function(event, ui){
				//alert("this is the drop inside the bench");
				var temp = ui.draggable.attr("id").split("!");
				var studentID = temp[0];
				var startTable = temp[1];
				var buildingId = temp[2];
				var roomNum = temp[3];
				var groupID = temp[4];
				var destTable = $(this).attr("id");
				//alert("Student ID: " + studentID);
				//alert("startTable: " + startTable);
				//alert("buildingId: " + buildingId);
				//alert("roomNum: " + roomNum);
				//alert("This is dropped at table: " + destTable);
				if(startTable != destTable){
					alert("do ajax: startTable: " + startTable + "  destTable: " + destTable);
                    /*$.ajax({
                        type: "GET",
                        url: "updateBenchDB.php?action=add&id=" + studentID,
                        success: function(msg){
                            $("#bench").html(msg);
                        }
                    });
					$.ajax({
                        type: "GET",
                        url: "updateStudentTableDB.php?action=remove&id=" + studentID + "&building_id=" + buildingId + "&room=" + roomNum + "&group=" + groupID,
                        success: function(msg){
                            $("#student_info").html(msg);
                        }
                    });/*
				}
				alert("after the if statement. Should have finished ajax");
				return false;
			}
		});
    });
</script>
';

echo 
'<script type="text/javascript">
$(document).ready(function(){
  $("tbody.connectedSortable").sortable({
    connectWith: ".connectedSortable",
    helper: "clone",
    cursor: "move",
    zIndex: 99999,
    receive: function(event, ui) {
      	var addedTo = $(this).closest("table.mytable");
      	var removedFrom = $("table.mytable").not(addedTo);
		var temp = ui.item[0].id;
		var studentID = temp[0];
		var startTable = temp[1];
		var buildingId = temp[2];
		var roomNum = temp[3];
		var groupID = temp[4];
		var destTable = addedTo.attr("id");
		//alert("startTable: " + startTable);
		//alert("buildingId: " + buildingId);
		//alert("roomNum: " + roomNum);
		//alert("This is dropped at table: " + destTable);
		if(startTable != destTable){
			alert("do ajax: startTable: " + startTable + "  destTable: " + destTable);
            $.ajax({
            	type: "GET",
                url: "updateBenchDB.php?action=add&id=" + studentID,
                success: function(msg){
                    $("#bench").html(msg);
                }
            });
			$.ajax({
                type: "GET",
                url: "updateStudentTableDB.php?action=remove&id=" + studentID + "&building_id=" + buildingId + "&room=" + roomNum + "&group=" + groupID,
                success: function(msg){
                    $("#student_info").html(msg);
                }
            });
		}
      	//alert("The ajax should be called for adding to " + addedTo.attr("id") + " and removing from " + removedFrom.attr("id"));
        alert("The ui.item: " + ui.item[0].id);
		alert("Student ID: " + studentID);
    }
  });
});
</script>
';*/

	//add the current row to the bench table then display that table
	//need code to add it to the bench table. I currently have the id of the element being passed.
	//need to know where the row is being dropped. If it is in the same table as the one being dragged from, I need to do nothing
	echo '<table id="benchTable" class="mytable">';
	echo '<tbody class="connectedSortable">';
	echo '<tr>';
	echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">First Name</th>';
	echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Last Name</th>';
	echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Student ID</th>';
	echo '<th class="manageCellsHeader" style="padding-left:0px; padding-right:0px;">Room Number</th>';
	echo '<th style="min-width:200px; width:200px; max-width:700px; padding-left:0px; padding-right:0px;">Comments</th>';
	echo '</tr>';
	//echo '<script type="text/javascript">alert("Inside the ajax if"); </script>';
	$query = "SELECT student_id FROM bench_temp";// LIMIT 10";
	$query_result = mysqli_query($dbconn, $query);
		$counter = 1;
while($row = mysqli_fetch_assoc($query_result))
{
	foreach($row as $st_id)
	{
		$query2 = "SELECT first_name, last_name, student_id, room_num, comments FROM students_temp WHERE student_id = '$st_id'";
		$query_result2 = mysqli_query($dbconn, $query2);

	while($studentInfo = mysqli_fetch_assoc($query_result2))
	{
				echo '<tr id="' . $st_id . '!0!0!0" >';
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
                    echo '<div style="height:100%; width:100%; white-space:pre-wrap; position:relative; display    :inline-block;" id="' . $counter . '">';
                    echo $st_info;
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

