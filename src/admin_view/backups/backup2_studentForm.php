<?php

ini_set('display_errors', true);

$dbconn = mysqli_connect('localhost', 'root', 'root', 'UNODB');

if( !$dbconn ){
	die('Connection failed. ' . mysqli_connect_errno() . ': ' . mysqli_connect_error    ());}

$was_errors = false;
$errors = array();

 $sqlEmailTable = "SELECT student_id AS 'Student ID', username AS 'Username', buildin    g_name AS 'Complex Name' FROM users ORDER BY student_id";
$building_names = "SELECT DISTINCT building_name FROM building";
 
$result_1 = mysqli_query($dbconn, $sqlEmailTable);
$result_2 = mysqli_query($dbconn, $building_names);


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
         <select align="right" id= "pretty_drop" name="state">
         	<option value="" disabled="true" selected="true">ST</option>
         	<option value="AL">AL</option>
         	<option value="AK">AK</option>
	        <option value="AZ">AZ</option>
         	<option value="AR">AR</option>
         	<option value="CA">CA</option>
         	<option value="CO">CO</option>
         	<option value="CT">CT</option>
         	<option value="DE">DE</option>
         	<option value="DC">DC</option>
         	<option value="FL">FL</option>
         	<option value="GA">GA</option>
         	<option value="HI">HI</option>
         	<option value="ID">ID</option>
         	<option value="IL">IL</option>
         	<option value="IN">IN</option>
         	<option value="IA">IA</option>
         	<option value="KS">KS</option>
         	<option value="KY">KY</option>
         	<option value="LA">LA</option>
         	<option value="ME">ME</option>
         	<option value="MD">MD</option>
         	<option value="MA">MA</option>
         	<option value="MI">MI</option>
         	<option value="MN">MN</option>
         	<option value="MS">MS</option>
         	<option value="MO">MO</option>
         	<option value="MT">MT</option>
         	<option value="NE">NE</option>
         	<option value="NV">NV</option>
         	<option value="NH">NH</option>
         	<option value="NJ">NJ</option>
         	<option value="NM">NM</option>
         	<option value="NY">NY</option>
         	<option value="NC">NC</option>
         	<option value="ND">ND</option>
         	<option value="OH">OH</option>
         	<option value="OK">OK</option>
         	<option value="OR">OR</option>
         	<option value="PA">PA</option>
         	<option value="RI">RI</option>
         	<option value="SC">SC</option>
         	<option value="SD">SD</option>
         	<option value="TN">TN</option>
         	<option value="TX">TX</option>
         	<option value="UT">UT</option>
         	<option value="VT">VT</option>
         	<option value="VA">VA</option>
         	<option value="WA">WA</option>
         	<option value="WV">WV</option>
	    	<option value="WI">WI</option>
         	<option value="WY">WY</option>
            <option value="AS">AS</option>
            <option value="GU">GU</option>
            <option value="MP">MP</option>
            <option value="PR">PR</option>
            <option value="VI">VI</option>
         </select>				
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
				<?php
					while( $row = mysqli_fetch_assoc($result_2) )
					{
						 foreach($row as $val){
							 echo '<option value="';
							 //if statement here to echo selected if match passed complex
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
    <td align="right">P=PM & A=AM:</td>
    <td><input type="radio" name="x10">&lt;10P</input></td>
    <td><input type="radio" name="x10">11P</input></td>
    <td><input type="radio" name="x10">12A</input></td>
    <td><input type="radio" name="x10">1A</input></td>
    <td><input type="radio" name="x10">2A</input></td>
    <td><input type="radio" name="x10">&gt;2A</input></td>
  </tr>
  <tr>
    <td align="left">On Average, what time do you normally wake up?</td>
    <td align="right">AM:</td>
    <td><input type="radio" name="x9">&lt;5</input></td>
    <td><input type="radio" name="x9">6</input></td>
    <td><input type="radio" name="x9">7</input></td>
    <td><input type="radio" name="x9">8</input></td>
    <td><input type="radio" name="x9">&gt;9</input></td>
  	<td></td>
  </tr>
  <tr>
    <td align="left">How would you describe yourself?</td>
    <td align="right">(Very Neat)</td>
    <td><input type="radio" name="x8">1</input></td>
    <td><input type="radio" name="x8">2</input></td>
    <td><input type="radio" name="x8">3</input></td>
    <td><input type="radio" name="x8">4</input></td>
    <td><input type="radio" name="x8">5</input></td>
    <td align="left">(Untidy)</td>
  </tr>
  <tr>
    <td></td>
    <td align="right">(Very Quiet)</td>
    <td><input type="radio" name="x7">1</input></td>
    <td><input type="radio" name="x7">2</input></td>
    <td><input type="radio" name="x7">3</input></td>
    <td><input type="radio" name="x7">4</input></td>
    <td><input type="radio" name="x7">5</input></td>
    <td align="left">(Noisy)</td>
  </tr>
  <tr>
    <td align="left">How comfortable are will you be with guests sleeping over in your appartment?</td> 
    <td align="right">(Very Uncom.)</td>
    <td><input type="radio" name="x6">1</input></td>
    <td><input type="radio" name="x6">2</input></td>
    <td><input type="radio" name="x6">3</input></td>
    <td><input type="radio" name="x6">4</input></td>
    <td><input type="radio" name="x6">5</input></td>
    <td align="left">(Very Comfortable)</td>
  </tr>
  <tr>
    <td align="left">How comfortable are will you be with the idea of sharing belongings <br>such as food, toiletries and dishes?</td> 
    <td align="right">(Very Uncomf.)</td>
    <td><input type="radio" name="x5">1</input></td>
    <td><input type="radio" name="x5">2</input></td>
    <td><input type="radio" name="x5">3</input></td>
    <td><input type="radio" name="x5">4</input></td>
    <td><input type="radio" name="x5">5</input></td>
    <td align="left">(Very Comfortable)</td>
  </tr>
  <tr>
    <td align="left">Do you expect your suite to be a place where people gather to relax?</td>
    <td align="right">(Strongly Disagree)</td>
    <td><input type="radio" name="x4">1</input></td>
    <td><input type="radio" name="x4">2</input></td>
    <td><input type="radio" name="x4">3</input></td>
    <td><input type="radio" name="x4">4</input></td>
    <td><input type="radio" name="x4">5</input></td>
    <td align="left">(Strongly Agree)</td>
  </tr>
  <tr>
    <td align="left">Do you expect your suite to be a place where people gather to relax?</td>
    <td align="right">(Never)</td>
    <td><input type="radio" name="x3">1</input></td>
    <td><input type="radio" name="x3">2</input></td>
    <td><input type="radio" name="x3">3</input></td>
    <td><input type="radio" name="x3">4</input></td>
    <td><input type="radio" name="x3">5</input></td>
    <td align="left">(Often)</td>
  </tr>
  <tr>
    <td align="left">Do you drink alcohol?</td>
    <td align="right">(Strongly Mind)</td>
    <td><input type="radio" name="x2">1</input></td>
    <td><input type="radio" name="x2">2</input></td>
    <td><input type="radio" name="x2">3</input></td>
    <td><input type="radio" name="x2">4</input></td>
    <td><input type="radio" name="x2">5</input></td>
    <td align="left">(Don't Mind)</td>
  </tr>
  <tr>
    <td align="left">Do you smoke?</td>
    <td align="right">(Never)</td>
    <td><input type="radio" name="x1">1</input></td>
    <td><input type="radio" name="x1">2</input></td>
    <td><input type="radio" name="x1">3</input></td>
    <td><input type="radio" name="x1">4</input></td>
    <td><input type="radio" name="x1">5</input></td>
    <td align="left">(Often)</td>
  </tr>
  <tr>
    <td align="left">Do you mind if others smoke?</td>
    <td align="right">(Strongly Mind)</td>
    <td><input type="radio" name="x0">1</input></td>
    <td><input type="radio" name="x0">2</input></td>
    <td><input type="radio" name="x0">3</input></td>
    <td><input type="radio" name="x0">4</input></td>
    <td><input type="radio" name="x0">5</input></td>
    <td align="left">(Don't Mind)</td>
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

