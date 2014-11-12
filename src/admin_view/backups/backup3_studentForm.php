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
  <tr>
  

    <td align="left">On Average, what time do you normally go to sleep?</td>
    <!--td align="left" width="20%">On Average, what time do you normally go to sleep?</td>
	<td align="left" width ="20%";>
		<div class="starRate">
			<ul>
			<li><a href="#"><span>After 2 AM</span></a></li>
			<li><a href="#"><span>2 AM</span></a></li>
			<li><a href="#"><span>1 AM</span><b></b></a></li>
			<li><a href="#"><span>12 AM</span></a></li>
			<li><a href="#"><span>Before 11 AM</span></a></li>
			</ul>
		</div>
	</td-->
	
		<!--td>
			<div class="rating">
				<span>&#9734;</span>
				<span>&#9734;</span>
				<span>&#9734;</span>
				<span>&#9734;</span>
				<span>&#9734;</span>
			</div>
		</td-->
		<!--td>
			<fieldset class="rating">
				<legend>Please rate:</legend>
				
				<input type="radio" id="star5" name="rating" value="5" />
				<label for="star5" title="Rocks!"></label>
				
				<input type="radio" id="star4" name="rating" value="4" />
				<label for="star4" title="Pretty good"></label>
				
				<input type="radio" id="star3" name="rating" value="3" />
				<label for="star3" title="Meh"></label>
				
				<input type="radio" id="star2" name="rating" value="2" />
				<label for="star2" title="Kinda bad"></label>
				
				<input type="radio" id="star1" name="rating" value="1" />
				<label for="star1" title="Sucks big time"></label>
			</fieldset>
		</td-->
    

<td><input type="radio" class="radio" name="x10" id="radio11"> <label for="radio11" title="before 10 PM"><div>before 10 PM</div></label>
<input type="radio" class="radio" name="x10" id="radio12"> <label for="radio12" title="11 PM"><div>11 PM</div></label>
<input type="radio" class="radio" name="x10" id="radio13"> <label for="radio13" title="12 AM"><div>12 AM</div></label>
<input type="radio" class="radio" name="x10" id="radio14"> <label for="radio14" title="1 AM"><div>1 AM</div></label>
<input type="radio" class="radio" name="x10" id="radio15"> <label for="radio15" title="2 AM"><div>2 AM</div></label>
<input type="radio" class="radio" name="x10" id="radio16"> <label for="radio16" title="after 2 AM"><div>after 2 AM</div></label></td>

	<!--td align="right">P=PM & A=AM:</td>
    <input type="radio" name="x10">&lt;10P</input></td>
    <input type="radio" name="x10">11P</input></td>
    <input type="radio" name="x10">12A</input></td>
    <input type="radio" name="x10">1A</input></td>
    <input type="radio" name="x10">2A</input></td>
    <input type="radio" name="x10">&gt;2A</input>
	</td-->
  </tr>
</table>
<table id="form_questions_table">
  <tr>
    <td align="left">On Average, what time do you normally wake up?</td>
<td><input type="radio" class="radio" name="x9" id="radio21"> <label for="radio21" title="before 5 AM"><div>before 5 AM</div></label>
<input type="radio" class="radio" name="x9" id="radio22"> <label for="radio22" title="6 AM"><div>6AM</div></label>
<input type="radio" class="radio" name="x9" id="radio23"> <label for="radio23" title="7 AM"><div>7 AM</div></label>
<input type="radio" class="radio" name="x9" id="radio24"> <label for="radio24" title="8 AM"><div>8 AM</div></label>
<input type="radio" class="radio" name="x9" id="radio25"> <label for="radio25" title="after 9 AM"><div>after 9AM</div></label></td>
    <!--td align="right">AM:</td>
	<input type="radio" name="x9">&lt;5</input></td>
    <input type="radio" name="x9">6</input></td>
    <input type="radio" name="x9">7</input></td>
    <input type="radio" name="x9">8</input></td>
    <input type="radio" name="x9">&gt;9</input></td>
  	<td></td-->
  </tr>
</table>
<table id="form_questions_table">
  <tr>
    <td align="left">How would you describe yourself?</td>
<td><input type="radio" class="radio" name="x8" id="radio31"> <label for="radio31" title="Very Neat"><div>Very Neat</div></label>
<input type="radio" class="radio" name="x8" id="radio32"> <label for="radio32" title="Neat"><div>Neat</div></label>
<input type="radio" class="radio" name="x8" id="radio33"> <label for="radio33" title="Little Neat"><div>Little Neat</div></label>
<input type="radio" class="radio" name="x8" id="radio34"> <label for="radio34" title="Little Untidy"><div>little Untidy</div></label>
<input type="radio" class="radio" name="x8" id="radio35"> <label for="radio35" title="Untidy"><div>Untidy</div></label>
<input type="radio" class="radio" name="x8" id="radio36"> <label for="radio36" title="Very Untidy"><div>Very Untidy</div></label></td>
    <!--td align="right">(Very Neat)</td>
    <input type="radio" name="x8">1</input></td>
    <input type="radio" name="x8">2</input></td>
    <input type="radio" name="x8">3</input></td>
    <input type="radio" name="x8">4</input></td>
    <input type="radio" name="x8">5</input></td>
    <td align="left">(Untidy)</td-->
  </tr>
</table>
<table id="form_questions_table">
  <tr>
    <td align="left">How would you describe yourself?</td>
<td><input type="radio" class="radio" name="x7" id="radio41"> <label for="radio41" title="Very Queit"><div>Very Queit</div></label>
<input type="radio" class="radio" name="x7" id="radio42"> <label for="radio42" title="Queit"><div>Queit</div></label>
<input type="radio" class="radio" name="x7" id="radio43"> <label for="radio43" title="Little Queit"><div>Little Queit</div></label>
<input type="radio" class="radio" name="x7" id="radio44"> <label for="radio44" title="Little Noisy"><div>Little Noisy</div></label>
<input type="radio" class="radio" name="x7" id="radio45"> <label for="radio45" title="Noisy"><div>Noisy</div></label>
<input type="radio" class="radio" name="x7" id="radio46"> <label for="radio46" title="Very Noisy"><div>Very Noisy</div></label></td>
    <!--td align="right">(Very Quiet)</td>
    <td></td>
    <input type="radio" name="x7">1</input></td>
    <input type="radio" name="x7">2</input></td>
    <input type="radio" name="x7">3</input></td>
    <input type="radio" name="x7">4</input></td>
    <input type="radio" name="x7">5</input></td>
    <td align="left">(Noisy)</td-->
  </tr>
</table>
<table id="form_questions_table">
  <tr>
    <td align="left">How comfortable are will you be with guests sleeping over in your appartment?</td> 
<td><input type="radio" class="radio" name="x6" id="radio51"> <label for="radio51" title="Very Uncomfortable"><div>Very Uncomfortable</div></label>
<input type="radio" class="radio" name="x6" id="radio52"> <label for="radio52" title="Uncomfortable"><div>Uncomfortable</div></label>
<input type="radio" class="radio" name="x6" id="radio53"> <label for="radio53" title="Little Uncomfortable"><div>Little Uncomfortable</div></label>
<input type="radio" class="radio" name="x6" id="radio54"> <label for="radio54" title="Little Comfortable"><div>Little Comfortable</div></label>
<input type="radio" class="radio" name="x6" id="radio55"> <label for="radio55" title="Comfortable"><div>Comfortable</div></label>
<input type="radio" class="radio" name="x6" id="radio56"> <label for="radio56" title="Very Comfortable"><div>Very Comfortable</div></label></td>
    <!--td align="right">(Very Uncom.)</td>
    <input type="radio" name="x6">1</input></td>
    <input type="radio" name="x6">2</input></td>
    <input type="radio" name="x6">3</input></td>
    <input type="radio" name="x6">4</input></td>
    <input type="radio" name="x6">5</input></td>
    <td align="left">(Very Comfortable)</td-->
  </tr>
</table>
<table id="form_questions_table">
  <tr>
    <td align="left">How comfortable are will you be with the idea of sharing belongings <br>such as food, toiletries and dishes?</td> 
<td><input type="radio" class="radio" name="x5" id="radio61"> <label for="radio61" title="Very Uncomfortable"><div>Very Uncomfortable</div></label>
<input type="radio" class="radio" name="x5" id="radio62"> <label for="radio62" title="Uncomfortable"><div>Uncomfortable</div></label>
<input type="radio" class="radio" name="x5" id="radio63"> <label for="radio63" title="Little Uncomfortable"><div>Little Uncomfortable</div></label>
<input type="radio" class="radio" name="x5" id="radio64"> <label for="radio64" title="Little Comfortable"><div>Little Comfortable</div></label>
<input type="radio" class="radio" name="x5" id="radio65"> <label for="radio65" title="Comfortable"><div>Comfortable</div></label>
<input type="radio" class="radio" name="x5" id="radio66"> <label for="radio66" title="Very Comfortable"><div>Very Comfortable</div></label></td>
    <!--td align="right">(Very Uncomf.)</td>
    <input type="radio" name="x5">1</input></td>
    <input type="radio" name="x5">2</input></td>
    <input type="radio" name="x5">3</input></td>
    <input type="radio" name="x5">4</input></td>
    <input type="radio" name="x5">5</input></td>
    <td align="left">(Very Comfortable)</td-->
  </tr>
</table>
<table id="form_questions_table">
  <tr>
    <td align="left">Do you expect your suite to be a place where people gather to relax?</td>
<td><input type="radio" class="radio" name="x4" id="radio71"> <label for="radio71" title="Never"><div>Never</div></label>
<input type="radio" class="radio" name="x4" id="radio72"> <label for="radio72" title="No"><div>No</div></label>
<input type="radio" class="radio" name="x4" id="radio73"> <label for="radio73" title="Rarely"><div>Rarely</div></label>
<input type="radio" class="radio" name="x4" id="radio74"> <label for="radio74" title="Sometimes"><div>Sometimes</div></label>
<input type="radio" class="radio" name="x4" id="radio75"> <label for="radio75" title="Yes"><div>Yes</div></label>
<input type="radio" class="radio" name="x4" id="radio76"> <label for="radio75" title="Of Course"><div>Of Course</div></label></td>
    <!--td align="right">(Strongly Disagree)</td>
    <input type="radio" name="x4">1</input></td>
    <input type="radio" name="x4">2</input></td>
    <input type="radio" name="x4">3</input></td>
    <input type="radio" name="x4">4</input></td>
    <input type="radio" name="x4">5</input></td>
    <td align="left">(Strongly Agree)</td-->
  </tr>
</table>
<table id="form_questions_table">
  <tr>
    <td align="left">Do you drink alchohol?</td>
<td><input type="radio" class="radio" name="x3" id="radio81"> <label for="radio81" title="Never"><div>Never</div></label>
<input type="radio" class="radio" name="x3" id="radio82"> <label for="radio82" title="No"><div>No</div></label>
<input type="radio" class="radio" name="x3" id="radio83"> <label for="radio83" title="Rarely"><div>Rarely</div></label>
<input type="radio" class="radio" name="x3" id="radio84"> <label for="radio84" title="Sometimes"><div>Sometimes</div></label>
<input type="radio" class="radio" name="x3" id="radio85"> <label for="radio85" title="Yes"><div>Yes</div></label>
<input type="radio" class="radio" name="x3" id="radio86"> <label for="radio85" title="Of Course"><div>Of Course</div></label></td>
    <!--td align="right">(Never)</td>
    <input type="radio" name="x3">1</input></td>
    <input type="radio" name="x3">2</input></td>
    <input type="radio" name="x3">3</input></td>
    <input type="radio" name="x3">4</input></td>
    <input type="radio" name="x3">5</input></td>
    <td align="left">(Often)</td-->
  </tr>
</table>
<table id="form_questions_table">
  <tr>
    <td align="left">Do you mind if others drink alchohol?</td>
<td><input type="radio" class="radio" name="x2" id="radio91"> <label for="radio91" title="Strongly Mind"><div>Strongly Mind</div></label>
<input type="radio" class="radio" name="x2" id="radio92"> <label for="radio92" title="Mind"><div>Mind</div></label>
<input type="radio" class="radio" name="x2" id="radio93"> <label for="radio93" title="Little Mind"><div>Little Mind</div></label>
<input type="radio" class="radio" name="x2" id="radio94"> <label for="radio94" title="Little Don't Mind"><div>Little Don't Mind</div></label>
<input type="radio" class="radio" name="x2" id="radio95"> <label for="radio95" title="Don't Mind"><div>Don't Mind</div></label>
<input type="radio" class="radio" name="x2" id="radio96"> <label for="radio96" title="Strongly Don't Mind"><div>Strongly Don't Mind</div></label></td>
    <!--td align="right">(Strongly Mind)</td>
    <input type="radio" name="x2">1</input></td>
    <input type="radio" name="x2">2</input></td>
    <input type="radio" name="x2">3</input></td>
    <input type="radio" name="x2">4</input></td>
    <input type="radio" name="x2">5</input></td>
    <td align="left">(Don't Mind)</td-->
  </tr>
</table>
<table id="form_questions_table">
  <tr>
    <td align="left">Do you smoke?</td>
<td><input type="radio" class="radio" name="x1" id="radio111"> <label for="radio111" title="Never"><div>Never</div></label>
<input type="radio" class="radio" name="x1" id="radio112"> <label for="radio112" title="Rarely"><div>Rarely</div></label>
<input type="radio" class="radio" name="x1" id="radio113"> <label for="radio113" title="Sometimes"><div>Sometimes</div></label>
<input type="radio" class="radio" name="x1" id="radio114"> <label for="radio114" title="Often"><div>Often</div></label></td>
    <!--td align="right">(Never)</td>
    <input type="radio" name="x1">1</input></td>
    <input type="radio" name="x1">2</input></td>
    <input type="radio" name="x1">3</input></td>
    <input type="radio" name="x1">4</input></td>
    <input type="radio" name="x1">5</input></td>
    <td align="left">(Often)</td-->
  </tr>
</table>
<table id="form_questions_table">
  <tr>
    <td align="left">Do you mind if others smoke?</td>
<td><input type="radio" class="radio" name="x0" id="radio121"> <label for="radio121" title="Strongly Mind"><div>Strongly Mind</div></label>
<input type="radio" class="radio" name="x0" id="radio122"> <label for="radio122" title="Mind"><div>Mind</div></label>
<input type="radio" class="radio" name="x0" id="radio123"> <label for="radio123" title="Little Mind"><div>Little Mind</div></label>
<input type="radio" class="radio" name="x0" id="radio124"> <label for="radio124" title="Don't Mind"><div>Don't Mind</div></label>
<input type="radio" class="radio" name="x0" id="radio125"> <label for="radio125" title="Strongly Don't Mind"><div>Strongly Don't Mind</div></label></td>
    <!--td align="right">(Strongly Mind)</td>
    <input type="radio" name="x0">1</input></td>
    <input type="radio" name="x0">2</input></td>
    <input type="radio" name="x0">3</input></td>
    <input type="radio" name="x0">4</input></td>
    <input type="radio" name="x0">5</input></td>
    <td align="left">(Don't Mind)</td-->
  </tr>
</table>
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

