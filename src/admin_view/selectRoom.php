<head>
	<script type="text/javascript" src="java-script/newWindow.js"></script>
	<link rel="stylesheet" href="../css/table.css" type="text/css">
</head>



<script type="text/javascript">
	$(document).ready(function(){
		var $tabs=$('#st_infoID')
        $( "tbody.connectedSortable")
            .sortable({
                connectWith: ".connectedSortable",
                items: "> tr:not(:first)",
                appendTo: $tabs,
                helper:"clone",
				cursor:"move",
                zIndex: 999990,
                update: function(){
                	var order = $(this).sortable("serialize") +
                    	'&action=updateRecordsListings';
                    $.post("updateDB.php", order,
                        function(theResponse){
                            $("#left_manage").html(theResonse);
                    });
                }
           })
            .disableSelection()
        ;
        var $tab_items = $( ".nav-tabs > li", $tabs ).droppable({
            accept: ".connectedSortable tr",
            hoverClass: "ui-state-hover",
            drop:function(event, ui) {
                return false;
            }
        });	
	});	

</script>
<?php
	include ('../includes/svrConnect.php');

$room = $_GET['room'];
$building = $_GET['building_id'];
#$room = '101';
#$building = '1';

$room = mysql_real_escape_string($room);
$building = mysql_real_escape_string($building);

$query = "SELECT student_id_1, student_id_2, student_id_3, student_id_4 FROM groups WHERE build_id = '$building' AND room_num = '$room'";
$query_result = mysqli_query($dbconn, $query);
echo '<br><br><br>';
echo '<table style="width:70%;" id="st_infoID" class="mytable">';
echo '<tbody class="connectedSortable">';
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
		$student_query = "SELECT first_name, last_name, student_id, room_num, comments FROM students WHERE student_id = '$st_id'";
		$student_query_result = mysqli_query($dbconn, $student_query);
		while($studentInfo = mysqli_fetch_assoc($student_query_result))
		{
			echo '<tr>';
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
		}
	}
	echo '</tr>';
}
echo '</tbody>';
echo '</table>';
#echo "Query: " .$query . "<br />";
?>
