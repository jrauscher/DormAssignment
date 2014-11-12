<?php
	include ('../includes/svrConnect.php');
	$was_errors = false;
	$errors = array();

	//should be passed from login
	$EMAIL = "stdFname2@testemail.com";
	
	$sqlStdID = "SELECT student_id FROM users WHERE username ='" . $EMAIL . "'";
	$sqlStdComplex 	= "SELECT building_name FROM users WHERE username ='" . $EMAIL . "'";
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
	$sqlStdBuild = "SELECT building_letter FROM building WHERE building_name ='" . mysql_real_escape_string( $COMPLEX ) . "'";
	$result_8 = mysqli_query($dbconn, $sqlStdBuild);
	

	include ('../includes/student_header.html');
?>
<div class ="content2">
<div id = "sub_content"> 
	<form id ="subform" action ="validate/studentVal.php" method = "post"> 
		<title>Sumbission Form</title>
		<h2>Student Submission Form</h2>
		<h3>Required</h3>
		<div id="sub_main">
			<table border="0" style="margin: 10px 30px;">
				<tr>
				   <td><input type="text" name="first_name" placeholder="First name" autofocus ="true"></input></td>
				 </tr>
				 <tr>
				   <td><input type="text" name="last_name" placeholder= "Last name"></input></td>
				 </tr>
				 <tr>
					<input type="hidden" name="student_id" <?php echo 'value="'.$NUID.'"' ?>/>
					<input type="hidden" name="email" <?php echo 'value="'.$EMAIL.'"' ?>/>
				 </tr>
				 <tr>
				   <td><input type="tel" placeholder="Cell phone" name="cell_phone"></input></td>
				 </tr>
				 <tr>
				   <td><input type="tel" placeholder="Home phone" name="home_phone"></input></td>
				   <input type="hidden" name="sub_date" value=""/>
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
						<?php  include ('../includes/states_dropdown.html'); ?>
				<input type="text" name="zip" style="width: 70px;" placeholder="Zipcode"></input>
				   </td>
				   <td></td>
				 </tr>
				 <tr>
					<td><input type="date" name="birthdate"></input></td>
				   <td align="left">:Birthday</td>
				 </tr>
				 <tr>
				   <td><input type ="radio" name="lease" value="9">9</input><input type ="radio" name="lease" checked value="12">12 Months Lease</input></td>
				 </tr>
				 <tr>
				   <td><input type="radio" name="gender" value="1">Male</input>
					   <input type="radio" name="gender" value="2"checked>Female</input></td>
				 </tr>
				 <tr>
				   <td><input type="checkbox" name="scott_scholar" value="1">Scott Scholar</input></td>
				 </tr>
			</table>
		</div>
		<h3>Optional</h3>
		<div id= "sub_optional">
			<table border="0">
				 <tr><td><input type="checkbox" name="renewal" value="1">Lived here last year</input></td></tr>
			</table>
			<table border="0">
				 <tr>
					<td align="right">
					Select preferred
					</td>
					<td>
						<input type="hidden" name="req_build_name" value=<?php echo '"'. $COMPLEX .'"'?>/>
						<?php
							 echo $COMPLEX;
							 echo ':';
						?>
					</td>
				 </tr>
			<table border="0">
				 <tr>
					<td>
						<select id="pretty_drop" name="req_build_letter" >
							<?php
								$iterate =1;
								while($std_build_temp = mysqli_fetch_assoc($result_8))
								{
									foreach($std_build_temp as $std_build)
									{
										if ($iterate == 1)
										{	
											if (count($std_build_temp) != 1)
											{
												echo '<option value="" disabled="true" selected="true">Building</option>';
											}
											if ($std_build)
											{
												echo '<option value="' . $std_build . '">';
												echo $std_build;
												echo '</option>';
											}
										}
										else
										{
											
											if ($std_build)
											{
												echo '<option value="' . $std_build . '">';
												echo $std_build;
												echo '</option>';
											}
										}
										$iterate++;
									}
								}	
							?>
						</select> 
					</td>
					<td>
						<select id="pretty_drop" name="req_room_num" >
							<option value="" disabled="true" selected="true">Room</option>
							<?php
								$std_build2 = "1";
								echo '<option disabled="true">ajax needed</option>';
								$BUILD_ID = "SELECT build_id FROM building WHERE building_name ='" . $COMPLEX . "'AND building_letter ='". $std_build2 . "'";
								$result_9 = mysqli_query($dbconn, $BUILD_ID);
								while($build_id_tempp = mysqli_fetch_assoc($result_9))
								{
									foreach($build_id_tempp as $build_idd)
									{
										$ROOMSS = "SELECT room_num FROM rooms WHERE build_id = '" . $build_idd . "'";
										$result_10 = mysqli_query($dbconn, $ROOMSS);	
									
										while($std_rooms_temp = mysqli_fetch_assoc($result_10))
										{
											foreach($std_rooms_temp as $std_roomm)
											{	
												if ($std_roomm)
												{
													echo '<option value="'. $std_roomm . '">';
													echo $std_roomm;
													echo '</option>';
												}
											}
										}
									}
								}
							?>
						</select> 
					</td>
					<td>
						<select id="pretty_drop" name="req_bedroom_letter" >
							<option value="" disabled="true" selected="true">Bedroom Letter</option>
							<option value="" disabled="true">ajax needed</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>

						</select>
					</td>
				</tr>
				</table>
			</table>
			<p><b>Optional Desired Roommates:</b><br><br>
			Please note, your name must be also on their form (requests must be mutual.<br>
			In order to be placed with your desired roommate(s), your lease and your roommate(s) lease must be for the same property and for the same term.
			</p>
			<table>
				 <tr>
				   <td><input type="text" name="desired_roommate1" placeholder="Name"></input></td>
				   <td><input type="text" name="desired_roommate_ph1" placeholder="Phone number"></input></td>
				 </tr>
				 <tr>
				   <td><input type="text" name="desired_roommate2" placeholder="Name"></input></td>
				   <td><input type="text" name="desired_roommate_ph2" placeholder="Phone number"></input></td>
				 </tr>
				 <tr>
				   <td><input type="text" name="desired_roommate3" placeholder="Name"></input></td>
				   <td><input type="text" name="desired_roommate_ph3" placeholder="Phone number"></input></td>
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
							<option value="">ajax needed</option>     
							<option value="DeptA">DeptA</option>     
							<option value="DeptB">DeptB</option>     
						</select>
				 	</td>
			 	</tr>
			</table>
			<table id="form_questions_table">
			<?php 
				$q1  = "On average, what time do you normally go to sleep?";
				$q2  = "On average, what time do you normally wake up?";
				$q3  = "How would you describe yourself?";
				$q4  = "How would you describe yourself?";
				$q5  = "How comfortable will you be with guests sleeping over in your appartment?";
				$q6  = "How comfortable are you with the idea of sharing belongings such as food, toiletries and dishes?";
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
				priority("noise_rating","Noise Level");
				priority("cleanliness_rating","Cleanliness");
				priority("lifestyle_rating","Lifestyle (Smoke & Alcohol use)");
				priority("age_rating","Age of Roommates");
				priority("major_rating","College Major of Roommates");
				priority("guest_rating","Guests in Suite");
			?>
			</table>
			<p>Comments? Is there anything else you would like us to consider when assigning you to a room?</p>
			<textarea rows="2" cols="50" name="comments"></textarea>
			<br></br>
		</div>
		<table id="button_table" >
			<tr>
				<td><button type="reset" class="button1" onclick="" value="Reset">Reset</button></td>
				<td><button type="submit" value="Submit" class = "button1" >Submit</button></td>
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
			echo '<input type="radio" class="radio" value="'; 
			echo $ind;
			echo '" name="';
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
	
	include ('../includes/footer.html');
?>

