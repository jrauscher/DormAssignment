<?php
	include ('../includes/svrConnect.php');

/* Set up your query in a string. */
$buildings = "SELECT building_name FROM building";
$NUIDs = "SELECT student_id FROM students WHERE student_id=10000000"; #Change student_id to * to print off everything on screen!!!!!
#$NUIDs = ""; #Change student_id to * to print off everything on screen!!!!!

/* Add a where clause if user has entered some data. */
if( isset($_POST['NUID_search']) && is_numeric($_POST['NUID_search']) && $_POST['NUID_search'] != null && $_POST['NUID_search'] != '' ){
    $NUIDs .= ' WHERE student_id  = ' . mysqli_real_escape_string($dbconn, $_POST['NUID_search']);
}

/* Send query to database. */
$result = mysqli_query($dbconn, $NUIDs);
include ('../includes/header.html');
?>
<title>Manage</title><!-- This title shows up in the broswer tab. -->
   <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
   <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
   <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
--><script type="text/javascript" src="java-script/mktree.js"></script>
<link rel="stylesheet" href="css/mktree.css" type="text/css">
<div class="content">
<div id="manage">
<div id="left_manage">

<div id="left_manage_title">
</div>

<?php
$campus = "SELECT DISTINCT campus FROM building";
$building_names = "SELECT building_name FROM building";
$building_letters = "SELECT building_letter FROM building";
$room_number = "SELECT * FROM building, rooms WHERE building.build_id = "; 
$result_campus = mysqli_query($dbconn, $campus . ";");



echo '<ul class="mktree" id="tree">';
echo '<li class="liOpen">Campus';
while ($campus_name = mysqli_fetch_assoc($result_campus)) //North or South
{
	echo '<ul>';
	foreach($campus_name as $campus_val)//For each North/South, do a Structure
	{
	echo '<li class="liOpen">' . $campus_val;
	$result_building_names = mysqli_query($dbconn, "SELECT DISTINCT building_name FROM building WHERE complex=1 AND campus = '" . $campus_val . "';");
	while ($building_name = mysqli_fetch_assoc($result_building_names))//Structures
	{
		echo '<ul>';
		foreach($building_name as $building_val)//for each Structure, get Building Letters
		{
			echo '<li class="liClosed">' . $building_val;
			$result_building_id = mysqli_query($dbconn, "SELECT build_id FROM building WHERE complex=0 AND building_name = '" . $building_val . "';"); // need to get building id not name
			while ($building_id = mysqli_fetch_assoc($result_building_id)) //get each building id
			{
				echo '<ul>';
				foreach($building_id as $building_id_val) //for each building letter
				{
					$result_building_letter = mysqli_query($dbconn, "SELECT building_letter FROM building WHERE build_id = '" . $building_id_val . "';"); //get building letters
					$building_letter = mysqli_fetch_assoc($result_building_letter);
					foreach($building_letter as $building_letter_val)
					{
						echo '<li class="liClosed">' . $building_val . " " . $building_letter_val;
					}
					$result_building_floor = mysqli_query($dbconn, "SELECT DISTINCT floor FROM rooms WHERE build_id = '" . $building_id_val . "' ORDER BY floor;"); //get floors
					while ($building_floor = mysqli_fetch_assoc($result_building_floor))
					{
						echo '<ul>';
						foreach($building_floor as $building_floor_val)
						{
							echo '<li class="liClosed">' . "Floor " . $building_floor_val;
							$result_room_num = mysqli_query($dbconn, "SELECT room_num FROM rooms WHERE build_id = '" . $building_id_val . "' AND floor = '" . $building_floor_val . "'ORDER BY room_num;"); // get room numbers based on building_id
							while ($room_num = mysqli_fetch_assoc($result_room_num)) //get room numbers
							{
								echo '<ul>';
								foreach($room_num as $room_num_val) //for each room number
								{
									echo '<li class="liBullet" id="' . $room_num_val . '" onclick="getRoom(this    .id, ' . $building_id_val . ')";>' . $room_num_val;
									echo '</li>';
								}
								echo '</ul>';
							}
							echo '</li>';
						}
						echo '</ul>';
					}
					echo '</li>';
				}
				echo '</ul>'; //building  ul
			}
			echo '</li>'; //building letter li
		}
		echo '</ul>'; //campus name ul
	}
	echo '</li>'; //campus name li
	}
	echo '</ul>'; //Campus ul
}
echo '</li>'; //Campus li
echo '</ul>'; //tree

?>

<script type="text/javascript">
	var isBenchShowing = false;
	
	function getRoom(room, building_id)
	{
		$.ajax({
			type: "GET",
			url: "selectRoom.php?room="+room+"&building_id="+building_id,
			success: function(msg){
				$('#student_info').html(msg);
			}
		});
	
		var $tabs=$('#st_infoID')
		$( "tbody.connectedSortable")
			.sortable({
				connectWith: ".connectedSortable",
				items: "> tr:not(:first)",
				appendTo: $tabs,
				helper:"clone",
				zIndex: 999990
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
	}
	$(document).ready(function(){	
		$("#getBench").click(
			function(){
				if(isBenchShowing){
					$("#student_info").animate({
						width: '+=250'
						}, 'slow'
					);
					isBenchShowing = false;
					$("#bench").animate({
						width: '-=200'
						}, 'slow'
					);
				}
				else{
					$("#student_info").animate({
						width: '-=250'
						}, 'slow'
					);
					isBenchShowing = true;
					$("#bench").animate({
						width: '+=200'
						}, 'slow'
					);
				}
			}
		);		
	});

	function displayText(st_id, cell_id)
	{
		var ele = document.getElementById(cell_id);
		if(ele.title == "0")
		{
			ele.className = 'fullText';
			ele.title = "1";
		}
		else
		{
			ele.className = 'shortText';
			ele.title = "0";
		}
	/*	document.getElementById(cell_id).classList.add('fullText');
		document.getElementById(cell_id).classList.remove('shortText');
		$.ajax({
			type: "GET",
			url: "showText.php?st_id="+st_id+"&length="+length+"&cell_id="+cell_id,
			success: function(msg){
				$('#' + cell_id).html(msg);
			}
		});*/
	}
</script>
</div>


<div id="wrapper_right">
<div id="right_view_header">
	<!-- Form for user to enter information. -->
	<form action="" method="post">
		<label for="NUID_search">Search for contact(by name): </label>
		<input name="NUID_search" />
		<input type="submit" value="Submit" class="button1" />
	</form>
	<form name='myForm'>
		Room: <input type='text' id='room' />
		Building ID: <input type='text' id='building_id' />
		<input class="button1" type='button' onclick='getRoom(document.getElementById("room").value, document.getElementById("building_id").value)' value='Query MySQL'/>
	</form>
	<form name='showBench'>
		<button type="button" id="getBench" class="button1" >Toggle Bench</button>
	</form>
</div>

<div id="right_view_content">
	<div id="student_info" class="student_info" style="float: left; width: 100%; height: 100%">
		
	</div>
	<div id="bench" class="bench" style="width: 0px; height: 100%; float: right; background-color: aqua;">
		<table id="benchID" class="mytable">
			<tbody class ="connectedSortable">
				<tr>
                    <th>COL1</th>  
                    <th>COL2</th>  
                    <th>COL3</th>  
                    <th>COL4</th>  
                </tr>
                <tr>   
                    <div><td>356</td>                                                      
                    <td>668</td>                                                
                    <td>100.95</td>  
                    <td>1.82</td>                                                   
                </tr>  
                <tr>  
                    <td>456</td>                                            
                    <td>668</td>                                      
                    <td>100.95</td> 
                    <td>1.82</td>                                              
                </tr>
			</tbody>
			</table>
		</div>
</div>
</div>
</div>
<?php
include ('../includes/footer.html');
?>

