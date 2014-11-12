<?php

ini_set('display_errors', true);

$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNODB');

if( !$dbconn ){
	die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error    ());}

$was_errors = false;
$errors = array();


//should be passed from login
$student_email = 'test@test.com';

 $sqlEmailTable = "SELECT student_id AS 'Student ID', username AS 'Username', building_name AS 'Complex Name' FROM users ORDER BY student_id";
$building_names = "SELECT DISTINCT building_name FROM building";
$login_student_building = "SELECT building_name FROM users WHERE student_id='".$student_email."'";

$result_1 = mysqli_query($dbconn, $sqlEmailTable);
$result_2 = mysqli_query($dbconn, $building_names);
$result_3 = mysqli_query($dbconn, $login_student_building);

if($selected_build_temp = mysqli_fetch_assoc($result_3))
{
	foreach($selected_build_temp as $selected_build_temp2)
	{ 
		if($selected_build_temp2)	
		{
			$selected_build = $selected_build_temp2;
		}
	}
}

include ('includes/header.html');
?>
<div id = "sub_content"> 
<form id ="subform" action ="validate/studentVal.php" method = "post"> 

<title>Sumbission Form</title>
<h2>Student Submission Form</h2>
<div id="sub_main">
<table border="0">
	<tr>
       <td><input type="text" name="first_name" placeholder="First name" autofocus ="true"></input></td><!---->
       <td><input type="text" name="last_name" placeholder= "Last name"></input></td><!---->
       <td><input type="radio" name="gender" value="1">Male</input>
           <input type="radio" name="gender" value="2"checked>Female</input></td>
     </tr>
     <tr>
       <td><input type="text" disabled ="true" placeholder="NUID passed from login"></input></td>
       <td><input type="email" disabled="true" placeholder="Email passed from login"></input></td>
       <td><input type="checkbox" name"scott_scholar" value="1">Scott Scholar</input></td>
     </tr>
     <tr>
       <td><input type="tel" placeholder="Cell phone" name="cell_phone"></input></td>
       <td><input type="tel" placeholder="Home phone" name="home_phone"></input></td>
       <td align="right">Birthday:
       	   <input type="date" value="birthdate"></input></td>
       <td></td>
     </tr>
     <tr>
       <td><input type="text" name="address1" placeholder="Address Line 1"></input></td>
     </tr>
     <tr>
       <td><input type="text" name="address2" placeholder="Address Line 2"></input></td>
     </tr>
     <tr>
       <td><input type="text" name ="city" placeholder="City"></input></td>
       <td>
      <?php  include ('includes/states_dropdown.html') ?>   
       		<input type="text" name="zip" size ="10" placeholder="Zipcode"></input>
		</td>
        <td></td>
     </tr>
</table>
</div>
<h3>Optional</h3>
<div id= "sub_optional">
<table border="0">
     <tr>
		<td>
			<select id="pretty_drop" name="complex" >
                <option value="" disabled="true" selected="true">Complex passed from login</option>
                <option value="" disabled="true"><?php echo $selected_build;?></option>
				<?php
					while( $row = mysqli_fetch_assoc($result_2) )
					{
						 foreach($row as $val){
							 echo '<option value="';
							 //if statement here to echo selected if match passed complex

							 //$selected_build as $selected_build_val;
							 if(isset($selected_build) && $selected_build == $val)
							 { 
								echo 'selected="true"';
							 }
							 echo $val.'">';
							 echo $val;
							 echo '</option>';
						}
					}
				?>
			</select>
		</td>
       

		<td>
			<select id="pretty_drop" name="build_name" ><!--convert to build_id in validate-->
                <option value="" disabled="true" selected="true">Building Letter options based on previous</option>
				<?php
 					$sqlBuildingTable = "SELECT DISTICT building_letter FROM building WHERE building_name=$passed_complex ORDER BY building_letter";
					$result_3 = mysqli_query($dbconn, $sqlBuildingTable);
					
					while( $row = mysqli_fetch_assoc($result_3) )
					{
						 foreach($row as $val){
							 echo '<option value="'. $val.'">';
							 echo $val;
							 echo '</option>';
						}
					}
				?>
      		</select> 
		<td>
			<select id="pretty_drop" name="room_num" >
                <option value="" disabled="true" selected="true">Room number options based on previous</option>
				<?php
 					$sqlRoomTable = "SELECT DISTICT room_num FROM rooms WHERE build_id=$chosen_building ORDER BY room_num";
					$result_4 = mysqli_query($dbconn, $sqlRoomTable);
					
					while( $row = mysqli_fetch_assoc($result_4) )
					{
						 foreach($row as $val){
							 echo '<option value="'. $val.'">';
							 echo $val;
							 echo '</option>';
						}
					}
				?>
      		</select> 
		</td>
		</td>
	</tr>
</table>
<p><b>Optional Desired Roommates:</b><br><br>
Please note, your name must be also on their form (requests must be mutual.<br>
In order to be placed with your desired roommate(s), your lease and your roommate(s) lease must be for the same property and for the same term.
</p>
<table>
     <tr>
       <td><input type="text" name="desired_roommate1" placeholder="Name"></input></td><!---->
       <td><input type="text" name="desired_roommate1_ph" placeholder="Phone number"></input></td><!---->
     </tr>
     <tr>
       <td><input type="text" name="desired_roommate2" placeholder="Name"></input></td><!---->
       <td><input type="text" name="desired_roommate2_ph" placeholder="Phone number"></input></td><!---->
     </tr>
     <tr>
       <td><input type="text" name="desired_roommate3" placeholder="Name"></input></td><!---->
       <td><input type="text" name="desired_roommate3_ph" placeholder="Phone number"></input></td><!---->
     </tr>
</table>
<br>
<table>
     <tr>
     <?php
       echo'<td>What will be your grade level be for '. date("Y") . '-' .date('Y', strtotime('+1 year')) .' at UNO?</td>';
      ?>
	   <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
       <td>
			<select id="pretty_drop" name="grade_lvl">
         	<option value="1">Freshman</option>
         	<option value="2">Sophomore</option>
         	<option value="3">Junior</option>
         	<option value="4">Senior</option>
	       	<option value="5">Graduate</option>     
       		</select>
		</td>
     </tr>

</table>
<table>
  <tr>
   
       <td>What college / department are you enrolled in?</td>
       <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
  </tr>
 <tr>     
<td><input type="text" name="enrolled_college" placeholder="College"></input></td><!--contact UNO for full list for a drop down?-->
       <td><input type="text" name="enrolled_department" placeholder="Department"></input></td>
  </tr>
</table>
<table id="form_questions_table">
<?php 

	$make_question("On Average, what time do you normally go to sleep?","",["<10PM","11PM","12AM","1AM",">2AM"],"","0");
	$make_question("On Average, what time do you normally wake up?","",["<5AM","6AM","7AM","8AM",">9AM"],"","1");
	$make_question("How would you describe yourself?","(Very Neat)",["1","2","3","4","5"],"(Untidy)","2");
	$make_question("How would you describe yourself?","(Very Quiet)",["1","2","3","4","5"],"(Noisy)","9");	
	$make_question("How comfortable are will you be with guests sleeping over in your appartment?","(Very Uncomf.)",["1","2","3","4","5"],"(Very Comfortable)","3");
	$make_question("How comfortable are will you be with the idea of sharing belongings such as food, toiletries and dishes?","(Very Uncomf.)",["1","2","3","4","5"],"(Very Comfortable)","4");
	$make_question("Do you expect your suite to be a place where people gather to relax?","(Strongly Disagree)",["1","2","3","4","5"],"","5");
	$make_question("Do you drink alcohol?","(Never)",["1","2","3","4","5"],"(Often)","6");
	$make_question("Do you mind if others drink alchohol?","(Strongly Mind",["1","2","3","4","5"],"(Don't Mind)","7");
	$make_question("Do you smoke?","(Never)",["1","2","3","4","5"],"(Often)","8");

	$make_question("Do you mind if others smoke?","(Strongly Mind",["1","2","3","4","5"],"(Don't Mind)","10");
?>
</table>
<?php 
	function $make_question($question,$min,$val, $max,$name)
	{
?>
  <tr>
    <td align="left"><?php echo $question ?></td>
	<td align="right"><?php echo $min ?></td>
	<?php 
		for($i=1; i<6; $i++)
		{
	?>
			<td>
				<input type="radio" class="radio" <?php echo 'name="x"'. $name. '"' ?> id="radio121"> 			<label for="radio121" title=<?php echo '"' .$.'"><div>' . $val[$i] .'<\/div<\/label'?>>
			</td>
	<?php
		}
	?>	
	<td align="left"><?php echo $max ?></td>
  </tr>
<?php	
	}
?>
<p><u>*Please note, alcohol is not permitted anywhere on UNO campus.</u><br>
<u>*Please note, smoking is not permitted inside the buildings or on balconies / patios.</u></p>

<p>Please rank the following topics in order of importance to you (please rank 1-6, 1 being the most important):</p>
<table>
  <tr>
       <td>
			<select id="pretty_drop" name="noise_rateing">
         	<option value="" selected="true"></option>
         	<option value="1">1</option>
         	<option value="2">2</option>
         	<option value="3">3</option>
         	<option value="4">4</option>
	       	<option value="5">5</option>     
	       	<option value="6">6</option>     
       		</select>
		</td>
       <td align="left">Noise Level</td>
  </tr>
  <tr>
       <td>
			<select id="pretty_drop" name="cleanliness_rateing">
         	<option value="" selected="true"></option>
         	<option value="1">1</option>
         	<option value="2">2</option>
         	<option value="3">3</option>
         	<option value="4">4</option>
	       	<option value="5">5</option>     
	       	<option value="6">6</option>     
       		</select>
		</td>
       <td align="left">Cleanliness</td>
  </tr>
  <tr>
       <td>
			<select id="pretty_drop" name="lifestyle_rateing">
         	<option value="" selected="true"></option>
         	<option value="1">1</option>
         	<option value="2">2</option>
         	<option value="3">3</option>
         	<option value="4">4</option>
	       	<option value="5">5</option>     
	       	<option value="6">6</option>     
       		</select>
		</td>
       <td align="left">Lifestyle (Smoke & Alcohol use)</td>
  </tr>
  <tr>
       <td>
			<select id="pretty_drop" name="age_rateing">
         	<option value="" selected="true"></option>
         	<option value="1">1</option>
         	<option value="2">2</option>
         	<option value="3">3</option>
         	<option value="4">4</option>
	       	<option value="5">5</option>     
	       	<option value="6">6</option>     
       		</select>
		</td>
       <td align="left">Age of Roommates</td>
  </tr>
  <tr>
       <td>
			<select id="pretty_drop" name="major_rateing">
         	<option value="" selected="true"></option>
         	<option value="1">1</option>
         	<option value="2">2</option>
         	<option value="3">3</option>
         	<option value="4">4</option>
	       	<option value="5">5</option>     
	       	<option value="6">6</option>     
       		</select>
		</td>
       <td align="left">College Major of Roommates</td>
  </tr>
  <tr>
       <td>
			<select id="pretty_drop" name="guest_rateing">
         	<option value="" selected="true"></option>
         	<option value="1">1</option>
         	<option value="2">2</option>
         	<option value="3">3</option>
         	<option value="4">4</option>
	       	<option value="5">5</option>     
	       	<option value="6">6</option>     
       		</select>
		</td>
       <td align="left">Guests in Suite</td>
  </tr>
</table>
<p>Comments? Is there anything else you would like us to consider when assigning you to a room?</p>
<textarea rows="2" cols="50" name="comments">
</textarea><!---->
<br></br>
</div>
<table id="button_table" >
<tr>
<td><button type="reset" id="pretty_large_button" onclick="" value="Reset">Reset</button></td>
<td><button type="submit" value="Submit"id = "pretty_large_button" >Submit</button></td>
</tr>
</table>
</form>
</div>

<?php
include ('includes/footer.html');
?>

