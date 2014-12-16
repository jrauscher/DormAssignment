<?php
	include ('../includes/svrConnect.php');

//$makeTempTable = "CREATE TEMPORARY TABLE IF NOT EXISTS tempStudents AS (SELECT * FROM students)";
$dropTempTable = "DROP TABLE students_temp";
mysqli_query($dbconn, $dropTempTable);
$makeTempTable = "CREATE TABLE students_temp SELECT * FROM students";
mysqli_query($dbconn, $makeTempTable);

$dropTempGroupTable = "DROP TABLE groups_temp";
mysqli_query($dbconn, $dropTempGroupTable);
$makeTempGroupTable = "CREATE TABLE groups_temp SELECT * FROM groups";
mysqli_query($dbconn, $makeTempGroupTable);

$dropTempBenchTable = "DROP TABLE bench_temp";
mysqli_query($dbconn, $dropTempBenchTable);
$makeTempBenchTable = "CREATE TABLE bench_temp SELECT * FROM bench";
mysqli_query($dbconn, $makeTempBenchTable);

$dropTempRoomLetterTable = "DROP TABLE room_letter_temp";
mysqli_query($dbconn, $dropTempRoomLetterTable);
$makeTempRoomLetterTable = "CREATE TABLE room_letter_temp SELECT * FROM room_letter";
mysqli_query($dbconn, $makeTempRoomLetterTable);

$dropTempRoomsTable = "DROP TABLE rooms_temp";
mysqli_query($dbconn, $dropTempRoomsTable);
$makeTempRoomsTable = "CREATE TABLE rooms_temp SELECT * FROM rooms";
mysqli_query($dbconn, $makeTempRoomsTable);





/* Set up your query in a string. */
$buildings = "SELECT building_name FROM building";
$NUIDs = "SELECT student_id FROM tempStudents WHERE student_id=10000000"; #Change student_id to * to print off everything on screen!!!!!
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
   <!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.7.2/themes/smoothness/jquery-ui.css">-->
   <script src="http://code.jquery.com/jquery-1.7.2.js"></script>
   <script src="http://code.jquery.com/ui/1.8.18/jquery-ui.js"></script>
<!--	<script src="http://code.jquery.com/jquery-1.7.2.js"></script>-->
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->


<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
--><script type="text/javascript" src="java-script/mktree.js"></script>
<link rel="stylesheet" href="css/mktree.css" type="text/css">
<div class="content">
<div id="manage">
<div id="left_manage"style="overflow-x: hidden; overflow-y: auto">

<div id="left_manage_title">
</div>

<?php
$campus = "SELECT DISTINCT campus FROM building";
$building_names = "SELECT building_name FROM building";
$building_letters = "SELECT building_letter FROM building";
$room_number = "SELECT * FROM building, rooms WHERE building.build_id = "; 
$result_campus = mysqli_query($dbconn, $campus . ";");
$buildingAndNumbers = array();

$temp = "campus";
echo '<ul class="mktree" id="tree">';
echo '<li class="liOpen" id="campusID" /*onclick="showComments(this.id)"*/>Campus';
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
						$buildingIDList[$building_id_val] = $building_id_val;
						$buildingAndNumbers[$building_id_val] = $building_val . ' ' . $building_letter_val;
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
									$getBuildingLease = "SELECT lease FROM building WHERE build_id = '$building_id_val'";
									$result_getBuildingLease = mysqli_query($dbconn, $getBuildingLease);
									while($lease = mysqli_fetch_assoc($result_getBuildingLease))
									{
										$build_lease = $lease['lease'];
									}
									
									$getRoomGender = "SELECT gender FROM rooms_temp WHERE build_id = '$building_id_val' AND room_num = '$room_num_val'";
									$result_getRoomGender = mysqli_query($dbconn, $getRoomGender);
									while($gender = mysqli_fetch_assoc($result_getRoomGender))
									{
										$room_gender = $gender['gender'];
									}
									echo '<li class="liBullet" id="' . $building_id_val . '!'.$room_num_val.'" onclick="getRoom('.$room_num_val.', ' . $building_id_val . ', '.$build_lease.', '.$room_gender.')";>' . $room_num_val;
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
			url: "getRoomInfo.php?building_id=" + building_id + "&room=" + room,// + "&group=0",
			success: function(msg){
				$('#uselessDiv').html(msg);
			}
		});
		
		
		/*
		$.ajax({
			type: "GET",
			url: "updateStudentTableDB.php?action=display&id=0&building_id=" + building_id + "&room=" + room,// + "&group=0",
			success: function(msg){
				$('#student_info').html(msg);
			}
		});
		*/
	}
	
	function getRoomByName()
	{
		var name = document.getElementById("nameID").value;
		$.ajax({
			type: "GET",
			url: "getRoomByName.php?name="+name,
			success: function(msg){
				$('#uselessDiv').html(msg);
			}
		});
	}

	function openNode(tree)
	{
		var select = document.getElementById("building_id");
		var building_id = select.options[select.selectedIndex].value;
		var room   = document.getElementById("room").value;
		collapseTree(tree);	
		roomLoc = building_id + "!" + room;
		expandToItem(tree, roomLoc);
	}

	function showAvailableStudents()
	{
		elem = document.getElementById('displayRoomNum');
		elem.innerHTML = "Students Without Rooms";
		$.ajax({
			type: "GET",
			url: "updateStudentTableDB.php?action=display&id=0&building_id=0&room=0",
			success: function(msg){
				$('#student_info').html(msg);
			}
		});
	}
	
	function saveAllChanges()
	{
		if(confirm("WARNING\n\nClicking OK will save all changes and cannot be undone!") == true)
		{
			$.ajax({
			type: "GET",
			url: "saveChanges.php?",
			success: function(msg){
				$('#uselessDiv').html(msg);
			}
			});
		}
	}	

	function showComments(name)
	{
		alert(name);
		$.ajax({
			type: "GET",
			url: "showComments.php",
			success: function(msg){
				$('#student_info').html(msg);
			}
		});
	}
	
	$(document).ready(function(){
		var buildsAndNums = <?php echo '["' . implode('", "', $buildingAndNumbers). '"]' ?>;
		var buildNums = <?php echo '["' . implode('", "', $buildingIDList). '"]' ?>;
		var sel = document.getElementById('building_id');
		for(var i=0; i<buildsAndNums.length; i++){
			var opt = document.createElement('option');
			opt.innerHTML = buildsAndNums[i];
			opt.value = buildNums[i];
			sel.appendChild(opt);
		}

	
		$.ajax({
			type: "GET",
			url: "updateBenchDB.php?action=display&id=0",
			//url: "makeBench.php?",
			success: function(msg){
				$('#bench').html(msg);
			}
		});

		$("#getBench").click(
			function(){
				if(isBenchShowing){
					$("#roomDiv").animate({
						width: '+=305'
						}, 'slow'
					);
					isBenchShowing = false;
					$("#bench").animate({
						width: '-=300'
						}, 'slow'
					);
				}
				else{
					$("#roomDiv").animate({
						width: '-=305'
						}, 'slow'
					);
					isBenchShowing = true;
					$("#bench").animate({
						width: '+=300'
						}, 'slow'
					);
				}
				window.setTimeout(getScroll,700);
			}
		);
		function getScroll()
		{
			//alert("test");	
			document.getElementById('roomDiv').style.overflowY="auto";
			document.getElementById('roomDiv').style.overflowX="hidden";
		}
		$(document).on('scroll', function() {
			$(document).scrollLeft(0);
			$(document).scrollTop(0);
		});
				
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

	$(document).mouseup(function (e)
	{
		var container = $("light");
		//if(!container.is(e.target.id) && container.has(e.target).length === 0)
		//if(e.target.id != "light" && e.target.id != "headerRow" && e.target.id != "headerInfo" && e.target.id != "contentRow" && e.target.id != "contentInfo" )
		if(e.target.id == "fade")
		{
			//alert("test");
			document.getElementById("light").style.display="none";
			document.getElementById("fade").style.display="none";
		}	
	});
	

</script>
</div>


<div id="wrapper_right">
<div id="right_view_header">
	<!-- Form for user to enter information. -->
	<table>
	<tr>
	<td>
	<form action="javascript:getRoomByName();" method="post">
		<input id="nameID" type="text" style="width:200px" name="NUID_search" placeholder="Search by Name" />
		<input type="submit" value="Submit" class="button1" />
	</form>
	</td>
	</tr>
	<tr> 
	<td>
	<form name='myForm'>
		<input type='text' style="width:50px" id='room' placeholder="Room Number" />
		<!--<input type='text' id='building_id' placeholder="Building ID"/>-->
		<select id='building_id'></select>		
		<input class="button1" type='button' onclick='getRoom(document.getElementById("room").value, document.getElementById("building_id").value); openNode("tree")' value='Submit'/>
	</form>
	</td>
	<td>
	<form name='showAvailStudents'>
		<button type="button" id="getAvailStudents" class="button1" onclick='showAvailableStudents()';>Show Students Without Rooms</button>
	</form>	
	</td>
	<td>
	<form name='submitChanges'>
		<button type="button" id="submitAllChanges" class="button1" onclick='saveAllChanges()';>Save Changes</button>
	</td>
	<td>
	<form name='showBench' style:'align:right'>
		<button type="button" id="getBench" class="button1" >Toggle Bench</button>
	</form>
	</td>
	
	</tr>
	</table>
</div>

<div id="right_view_content">
	<div id="roomDiv" class="student_info" style="float: left; width: 100%; height: 100%; overflow-x: hidden; overflow-y: auto">
	<div id="displayRoomNum" style="height: 10%; width: 100%; text-align: center; font-size: 20px">
	</div>
	<div id="uselessDiv">
	</div>
	<div id="student_info" class="student_info" style="float: left; width: 100%; height: 90%">
		<!--<table style="width:200px;" id="studentTable" class="mytable">
			<tbody class ="connectedSortable">
				<tr id="testStudentRowHeader">
                    <th style="width:100px;">COL1</th>
                    <th style="width:100px;">COL2</th>
                </tr>
                <tr id="testStudentRow1">
                    <div><td style="width:100px;">1</td>                              
                    <td style="width:100px;">2</td>
                </tr>
                <tr id="testStudentRow2">
                    <td style="width:100px;">3</td>
                    <td style="width:100px;">4</td>
                </tr>
			</tbody>
		</table>-->
	</div>
	</div>
	<div id="bench" class="bench" style="width: 0px; height: 100%; float: right;">
		<!--<table style="width:200px;" id="benchTable" class="mytable">
			<tbody class ="connectedSortable">
				<tr id="testBenchRowHeader">
                    <th class="manageCellsHeader">First Name</th>  
                    <th class="manageCellsHeader">Last Name</th>
					<th class="manageCellsHeader">STID</th>
					<th class="manageCellsHeader">Room #</th>
					<th class="manageCellsHeader">Comments</th>
                </tr>
                <tr id="testBenchRow1">   
                    <td class="manageCellsContent" style="padding:0px">FN</td>
                    <td class="manageCellsContent" style="padding:0px">LN</td>
                    <td class="manageCellsContent" style="padding:0px">12345678</td>
                    <td class="manageCellsContent" style="padding:0px">111</td>
                    <td class="manageCellsContent" style="padding:0px">hello there mister sir guy</td>
                </tr>  
                <tr id="testBenchRow2">  
                    <td class="manageCellsContent" style="padding:0px">FN2</td>
                    <td class="manageCellsContent" style="padding:0px">LN2</td>
                    <td class="manageCellsContent" style="padding:0px">88888888</td>
                    <td class="manageCellsContent" style="padding:0px">999</td>
                    <td class="manageCellsContent" style="padding:0px">This is the second type</td>
                </tr>
			</tbody>
		</table>-->
	</div>
</div>
</div>
</div>


<!-- <p>This is the main content. To display a lightbox click <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">here</a></p>-->

<!--<div id="light" class="white_content">This is the lightbox content. <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a></div>-->

<div id="light" class="white_content"></div>

<div id="fade" class="black_overlay"></div>


<?php
include ('../includes/footer.html');
?>

