<?php
	include ('../includes/svrConnect.php');
	$was_errors = false;
	$errors = array();

	//should be passed from login
	$student_email = "stdFname5@testemail.com";
	
	$sqlStdID 				= "SELECT student_id FROM students WHERE email ='" . $student_email . "';";//new
	$sqlStdComplex 			= "SELECT building_name FROM users WHERE username ='" . $student_email . "';";//new
	$result_6 = mysqli_query($dbconn, $sqlStdID);
	$result_7 = mysqli_query($dbconn, $sqlStdComplex);
	if($std_id_temp = mysqli_fetch_assoc($result_6))
	{
		foreach($std_id_temp as $std_id)
		{	
			if ($std_id)
			{
				$NUID = $std_id;
			}
		}
	}
	else
	{
		$NUID = "Student not in DB";
	}

	if($std_comp_temp = mysqli_fetch_assoc($result_7))
	{
		foreach($std_comp_temp as $std_comp)
		{	
			if ($std_comp)
			{
				$COMPLEX = $std_comp;
			}
		}
	}
	else
	{
		$COMPLEX = "Student not in DB";
	}
	$sqlStdBuild 			= "SELECT building_letter FROM building WHERE building_name ='" . mysql_real_escape_string( $COMPLEX ) . "'";//new
	$result_8 = mysqli_query($dbconn, $sqlStdBuild);
	

	include ('../includes/student_header.html');
?>
<div id = "sub_content"> 
	<form id ="subform" action ="validate/studentVal.php" method = "post"> 
		<title>Sumbission Form</title>
		<h2>Student Submission Form</h2>
		<div id="sub_main">
			<table border="0">
				<tr>
				   <td><input type="text" name="first_name" placeholder="First name" autofocus ="true"></input></td>
				   <td><input type="text" name="last_name" placeholder= "Last name"></input></td>
				   <td><input type="radio" name="gender" value="1">Male</input>
					   <input type="radio" name="gender" value="2"checked>Female</input></td>
				 </tr>
				 <tr>
				   <td><input type="text" disabled ="true" name="student_id" <?php echo 'placeholder="' . $NUID . '">';?></input></td>
				   <td><input type="email" disabled="true" name="email"<?php echo 'placeholder="' . $student_email . '">';?></input></td>
				   <td><input type="checkbox" name="scott_scholar" value="1">Scott Scholar</input></td>
				 </tr>
				 <tr>
				   <td><input type="tel" placeholder="Cell phone" name="cell_phone"></input></td>
				   <td><input type="tel" placeholder="Home phone" name="home_phone"></input></td>
				   <td align="right">Birthday:<input type="date" value="birthdate"></input></td>
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
						<?php  include ('../includes/states_dropdown.html') ?>
				<input type="text" name="zip" size ="10" placeholder="Zipcode"></input>
				   </td>
				   <td></td>
				 </tr>
				 <tr>
				   <td><input type ="radio" name="lease" value="9">9 Months Lease</input>
				       <input type ="radio" name="lease" value="12">12 Months Lease</input></td>
				 </tr>
			</table>
		</div>
		<h3>Optional</h3>
		<div id= "sub_optional">
			<table border="0">
				 <tr><td><input type="checkbox" name="renewal" value="1">Renewing Student</input></td></tr>
				 <tr>
					<td>
						<select id="pretty_drop" name="complex" disabled="true" >
						<?php
							 echo '<option value="';
							 echo $COMPLEX.'">';
							 echo $COMPLEX;
							 echo '</option>';
						?>
						</select>
					</td>
					<td>
						<select id="pretty_drop" name="build_name" ><!--convert to build_id in validate-->
							<option value="" disabled="true" selected="true">Possible Buildings</option>
							<?php
								while($std_build_temp = mysqli_fetch_assoc($result_8))
								{
									foreach($std_build_temp as $std_build)
									{	
										if ($std_build)
										{
											echo '<option value="'. $std_build.'">';
											echo $std_build;
											echo '</option>';
										}
										else 
										{
											echo '<option>';
											echo 'Error';
											echo '</option>';
										}
									}
								}
							?>
						</select> 
					</td>
					<td>
						<select id="pretty_drop" name="room_num" >
							<option value="" disabled="true" selected="true">Possible Rooms</option>
							<?php
								echo '<option>To be implemented with ajax</option>';
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
				   <td><input type="text" name="desired_roommate1" placeholder="Name"></input></td>
				   <td><input type="text" name="desired_roommate1_ph" placeholder="Phone number"></input></td>
				 </tr>
				 <tr>
				   <td><input type="text" name="desired_roommate2" placeholder="Name"></input></td>
				   <td><input type="text" name="desired_roommate2_ph" placeholder="Phone number"></input></td>
				 </tr>
				 <tr>
				   <td><input type="text" name="desired_roommate3" placeholder="Name"></input></td>
				   <td><input type="text" name="desired_roommate3_ph" placeholder="Phone number"></input></td>
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
					<td> <!-- according to: http://registrar.unomaha.edu/courses/ -->
						<select id="pretty_drop" name="enrolled_college">
							<option disabled="true" selected="true">College</option>
							<option value="AS">Arts And Sciences(UNO)</option>
							<option value="BA">Business Administration(UNO)</option>     
							<option value="CF">Communication, Fine Arts and Media(UNO)</option>     
							<option value="ED">Education(UNO)</option>     
							<option value="EN">Engineering(UNL)</option>     
							<option value="GR_UNL">Graduate College(UNL)</option>     
							<option value="GR_UNO">Graduate College(UNO)</option>     
							<option value="IS">Information Science and Technology(UNO)</option>     
							<option value="CA">Public Affairs and Community Service(UNO)</option>     
						</select>
				 	</td>
					<td> <!-- according to: http://registrar.unomaha.edu/courses/ -->
						<select id="pretty_drop" name="enrolled_department">
							<option disabled="true" selected="true">Department</option>
							<option value="">To be implemented with ajax</option>     
						</select>
				 	</td>
			 	</tr>
			</table>
			<table id="form_questions_table">
			<?php 
				$q1  = "On Average, what time do you normally go to sleep?";
				$q2  = "On Average, what time do you normally wake up?";
				$q3  = "How would you describe yourself?";
				$q4  = "How would you describe yourself?";
				$q5  = "How comfortable are will you be with guests sleeping over in your appartment?";
				$q6  = "How comfortable are will you be with the idea of sharing belongings such as food, toiletries and dishes?";
				$q7  = "Do you expect your suite to be a place where people gather to relax?";
				$q8  = "Do you drink alcohol?";
				$q9  = "Do you mind if others drink alchohol";
				$q10 = "Do you smoke?";
				$q11 = "Do you mind if others smoke?";
				
				$name1  = "bed_time";
				$name2  = "wakeup_time";
				$name3  = "cleanliness";
				$name4  = "noise";
				$name5  = "guest_sleeping";
				$name6  = "share_belongings";
				$name7  = "gathering";
				$name8  = "drink_alchohol";
				$name9  = "others_drink";
				$name10 = "smoking";
				$name11 = "others_smoking";
				
				$max1  = "";
				$max2  = "";
				$max3  = "(Untidy)";
				$max4  = "(Noisy)";
				$max5  = "(Very Comfortable)";
				$max6  = "(Very Comfortable)";
				$max7  = "(Strongly Agree)";
				$max8  = "(Often)";
				$max9  = "(Don't Mind)";
				$max10 = "(Often)";
				$max11 = "(Don't Mind)";
				
				$L1  = array("<10PM","11PM","12AM","1AM",">2AM");
				$L2  = array("<5AM","6AM","7AM","8AM",">9AM");
				$L3  = array("1","2","3","4","5");
				$L4  = array("1","2","3","4","5");
				$L5  = array("1","2","3","4","5");
				$L6  = array("1","2","3","4","5");
				$L7  = array("1","2","3","4","5");
				$L8  = array("1","2","3","4","5");
				$L9  = array("1","2","3","4","5");
				$L10 = array("1","2","3","4","5");
				$L11 = array("1","2","3","4","5");
				
				$min1  = "";
				$min2  = "";
				$min3  = "(Very Neat)";
				$min4  = "(Very Quiet)";
				$min5  = "(Very Uncomf.)";
				$min6  = "(Very Uncomf.)";
				$min7  = "(Strongly Disagree)";
				$min8  = "(Never)";
				$min9  = "(Strongly Mind)";
				$min10 = "(Never)";
				$min11 = "(Strongly Mind)";
				
				make_question($q1,$min1,$L1,$max1,$name1);
				make_question($q2,$min2,$L2,$max2,$name2);
				make_question($q3,$min3,$L3,$max3,$name3);
				make_question($q4,$min4,$L4,$max4,$name4);
				make_question($q5,$min5,$L5,$max5,$name5);
				make_question($q6,$min6,$L6,$max6,$name6);
				make_question($q7,$min7,$L7,$max7,$name7);
				make_question($q8,$min8,$L8,$max8,$name8);
				make_question($q9,$min9,$L9,$max9,$name9);
				make_question($q10,$min10,$L10,$max10,$name10);
				make_question($q11,$min11,$L11,$max11,$name11);
			?>
			</table>
			<p><u>*Please note, alcohol is not permitted anywhere on UNO campus.</u><br>
			<u>*Please note, smoking is not permitted inside the buildings or on balconies / patios.</u></p>
			<p>Please rank the following topics in order of importance to you (please rank 1-6, 1 being the most important):</p>
			<table>
			<?php
				priority("noise_rateing","Noise Level");
				priority("cleanliness_rateing","Cleanliness");
				priority("lifestyle_rateing","Lifestyle (Smoke & Alcohol use)");
				priority("age_rateing","Age of Roommates");
				priority("major_rateing","College Major of Roommates");
				priority("guest_rateing","Guests in Suite");
			?>
			</table>
			<p>Comments? Is there anything else you would like us to consider when assigning you to a room?</p>
			<textarea rows="2" cols="50" name="comments"></textarea>
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
	
	function make_question($question,$min,$val,$max,$name)
	{
		$i =0;
  		echo '<tr>';
    	echo '<td align="left">';
		echo $question;
		echo '</td>';
		echo '<td align="right" style="" >';
		echo $min;
		echo '</td>';
		foreach($val as $ind)
		{
			echo '<td style="width:5px">';
			echo '<input type="radio" class="radio" name="';
			echo $name;
			echo '" id="radio';
			echo $name . $i;
			echo '"><label for="radio';
			echo $name . $i;
			echo '" title=""><div>';
			echo $ind;
			echo '</div</label></td>';
			$i++;
		}
	echo '<td align="left">'. $max . '</td></tr>';
	}

	function priority($name, $show_string)
	{
  		echo '<tr>';
		echo '<td>';
		echo '<select id="pretty_drop" name="';
		echo $name;
		echo '">';
        echo '<option value="" selected="true"></option>';
       	for($i=1; $i<7; $i++)
		{
			echo '<option value="';
			echo $i;
			echo '">';
			echo $i;
			echo '</option>';
       	}
		echo '</select>';
		echo '</td>';
       	echo '<td align="left">';
		echo $show_string;
		echo '</td>';
  		echo '</tr>';
	}	
	
/*	function checkPass($result_u)
	{
		if($val = mysqli_fetch_assoc($result_u))
		{
			foreach($val as $val2)
			{	
				if ($val2)
				{
					$return_val = $std_id;
				}
				else
				{
					$return_val= "Error(1)";
				}
			}
		}
		else
		{
			$return_val = "Error(2)";
		}
		return $return_val;
	}
*/
	include ('../includes/footer.html');
?>

