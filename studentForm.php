<?php
include ('includes/header.html');
?>
<div id = "sub_content"> 
<form id ="subform"> 
<title>Sumbission Form</title>
<h2>Student Submission Form</h2>
<div id="sub_main">
<table border="0">
	<tr>
       <th align="right" >First Name:</th>
       <th><input type="text" name="first_name"></input></th>
       <th align="right">Last Name:</th>
       <th><input type="text" name="last_name"></input></th>
       <th><input type="radio" name="gender">Male</input></th>
       <th><input type="radio" name="gender" checked>Female</input></th>
     </tr>
     <tr>
       <th align="right">NU ID:</th>
       <th><input type="text"></input></th>
       <th align="right">Email:</th>
       <th><input type="email"></input></th>
       <th></th>
       <th><input type="checkbox">Scott Scholar (press space to select)</input></th>
     </tr>
     <tr>
       <th align="right">Cell Phone:</th>
       <th><input type="tel"></input></th>
       <th align="right">Home Phone:</th>
       <th><input type="tel"></input></th>
       <th align="right">Birthday:</th>
       <th><input type="date"></input></th>
       <th></th>
     </tr>
     <tr>
       <th align="right">Address Line 1:</th>
       <th><input type="text"></input></th>
     </tr>
     <tr>
       <th align="right">Address Line 2:</th>
       <th><input type="text"></input></th>
     </tr>
     <tr>
       <th align="right">City:</th>
       <th><input type="text"></input></th>
       <th align="right">State:</th>
       <th>
         <select align="right" id= "pretty_drop">
         	<option value="AL">Alabama</option>
         	<option value="AK">Alaska</option>
	        <option value="AZ">Arizona</option>
         	<option value="AR">Arkansas</option>
         	<option value="CA">California</option>
         	<option value="CO">Colorado</option>
         	<option value="CT">Connecticut</option>
         	<option value="DE">Delaware</option>
         	<option value="DC">District Of Columbia</option>
         	<option value="FL">Florida</option>
         	<option value="GA">Georgia</option>
         	<option value="HI">Hawaii</option>
         	<option value="ID">Idaho</option>
         	<option value="IL">Illinois</option>
         	<option value="IN">Indiana</option>
         	<option value="IA">Iowa</option>
         	<option value="KS">Kansas</option>
         	<option value="KY">Kentucky</option>
         	<option value="LA">Louisiana</option>
         	<option value="ME">Maine</option>
         	<option value="MD">Maryland</option>
         	<option value="MA">Massachusetts</option>
         	<option value="MI">Michigan</option>
         	<option value="MN">Minnesota</option>
         	<option value="MS">Mississippi</option>
         	<option value="MO">Missouri</option>
         	<option value="MT">Montana</option>
         	<option value="NE">Nebraska</option>
         	<option value="NV">Nevada</option>
         	<option value="NH">New Hampshire</option>
         	<option value="NJ">New Jersey</option>
         	<option value="NM">New Mexico</option>
         	<option value="NY">New York</option>
         	<option value="NC">North Carolina</option>
         	<option value="ND">North Dakota</option>
         	<option value="OH">Ohio</option>
         	<option value="OK">Oklahoma</option>
         	<option value="OR">Oregon</option>
         	<option value="PA">Pennsylvania</option>
         	<option value="RI">Rhode Island</option>
         	<option value="SC">South Carolina</option>
         	<option value="SD">South Dakota</option>
         	<option value="TN">Tennessee</option>
         	<option value="TX">Texas</option>
         	<option value="UT">Utah</option>
         	<option value="VT">Vermont</option>
         	<option value="VA">Virginia</option>
         	<option value="WA">Washington</option>
         	<option value="WV">West Virginia</option>
	    	<option value="WI">Wisconsin</option>
         	<option value="WY">Wyoming</option>
            <option value="AS">American Samoa</option>
            <option value="GU">Guam</option>
            <option value="MP">N Mariana Islands</option>
            <option value="PR">Puerto Rico</option>
            <option value="VI">Virgin Islands</option>
         </select>				
       </th>
       <th align="right">Zipcode:</th>
       <th><input type="text"></input></th>
        <th></th>
     </tr>
</table>
</div>
<h3>Optional</h3>
<div id= "sub_optional">
<table border="0">
     </tr>
       <th align="right">Suite Preference</th>
       <th><input type="text"></input></th>
       <th align="right">Building Preference</th>
       <th><input type="text"></input></th>
</table>
<p><b>Optional Desired Roommates:</b></p>
<p><b>Please note, your name must be also on their form (requests must be mutual). </b></p>
<p><b>In order to be placed with your desired roommate(s), your lease and your roommate(s) lease must be for the same property and for the same term.</b></p>
</p>
<table>
     <tr>
       <th align="right">Name:</th>
       <th><input type="text"></input></th>
       <th align="right">Phone Number:</th>
       <th><input type="text"></input></th>
     </tr>
     <tr>
       <th align="right">Name:</th>
       <th><input type="text"></input></th>
       <th align="right">Phone Number:</th>
       <th><input type="text"></input></th>
     </tr>
     <tr>
       <th align="right">Name:</th>
       <th><input type="text"></input></th>
       <th align="right">Phone Number:</th>
       <th><input type="text"></input></th>
     </tr>
</table>
<p></p>
<table>
     <tr>
      
       <th>What will be your grade level be for {year-year} at UNO?</th>
       <th>&nbsp&nbsp&nbsp&nbsp&nbsp</th>
       <th>
			<select id="pretty_drop">
         	<option value="AL">Freshman</option>
         	<option value="AK">Sophomore</option>
         	<option value="AL">Junior</option>
         	<option value="AK">Senior</option>
	       	<option value="AZ">Graduate</option>     
       		</select>
		</th>
     </tr>

</table>
<table>
  <tr>
   
       <th>What college / department are you enrolled in?</th>
       <th>&nbsp&nbsp&nbsp&nbsp&nbsp</th>
       <td align="right">College:</td>
       <th><input type="text"></input></th>
       <td align="right">Department:</td>
       <th><input type="text"></input></th>
  </tr>
</table>
<table>
  <tr>
    <th align="right">On Average, what time do you normally go to sleep?</th>
    <td align="right">P=PM & A=AM:</td>
    <td><input type="radio" name="x10">&lt;10P</input></td>
    <td><input type="radio" name="x10">11P</input></td>
    <td><input type="radio" name="x10">12A</input></td>
    <td><input type="radio" name="x10">1A</input></td>
    <td><input type="radio" name="x10">2A</input></td>
    <td><input type="radio" name="x10">&gt;2A</input></td>
  </tr>
  <tr>
    <th align="right">On Average, what time do you normally wake up?</th>
    <td align="right">AM:</td>
    <td><input type="radio" name="x9">&lt;5</input></td>
    <td><input type="radio" name="x9">6</input></td>
    <td><input type="radio" name="x9">7</input></td>
    <td><input type="radio" name="x9">8</input></td>
    <td><input type="radio" name="x9">&gt;9</input></td>
  </tr>
  <tr>
    <th align="right">How would you describe yourself?</th>
    <td align="right">(Very Neat)</td>
    <td><input type="radio" name="x8">1</input></td>
    <td><input type="radio" name="x8">2</input></td>
    <td><input type="radio" name="x8">3</input></td>
    <td><input type="radio" name="x8">4</input></td>
    <td><input type="radio" name="x8">5</input></td>
    <td align="left">(Untidy)</td>
  </tr>
  <tr>
    <th></th>
    <td align="right">(Very Quiet)</td>
    <td><input type="radio" name="x7">1</input></td>
    <td><input type="radio" name="x7">2</input></td>
    <td><input type="radio" name="x7">3</input></td>
    <td><input type="radio" name="x7">4</input></td>
    <td><input type="radio" name="x7">5</input></td>
    <td align="left">(Noisy)</td>
  </tr>
  <tr>
    <th align="right">How comfortable are will you be with guests sleeping over in your appartment?</th> 
    <td align="right">(Very Uncom.)</td>
    <td><input type="radio" name="x6">1</input></td>
    <td><input type="radio" name="x6">2</input></td>
    <td><input type="radio" name="x6">3</input></td>
    <td><input type="radio" name="x6">4</input></td>
    <td><input type="radio" name="x6">5</input></td>
    <td align="left">(Very Comfortable)</td>
  </tr>
  <tr>
    <th align="right">How comfortable are will you be with the idea of sharing belongings such as food, toiletries and dishes?</th> 
    <td align="right">(Very Uncomf.)</td>
    <td><input type="radio" name="x5">1</input></td>
    <td><input type="radio" name="x5">2</input></td>
    <td><input type="radio" name="x5">3</input></td>
    <td><input type="radio" name="x5">4</input></td>
    <td><input type="radio" name="x5">5</input></td>
    <td align="left">(Very Comfortable)</td>
  </tr>
  <tr>
    <th align="right">Do you expect your suite to be a place where people gather to relax?</th>
    <td align="right">(Strongly Disagree)</td>
    <td><input type="radio" name="x4">1</input></td>
    <td><input type="radio" name="x4">2</input></td>
    <td><input type="radio" name="x4">3</input></td>
    <td><input type="radio" name="x4">4</input></td>
    <td><input type="radio" name="x4">5</input></td>
    <td align="left">(Strongly Agree)</td>
  </tr>
  <tr>
    <th align="right">Do you expect your suite to be a place where people gather to relax?</th>
    <td align="right">(Never)</td>
    <td><input type="radio" name="x3">1</input></td>
    <td><input type="radio" name="x3">2</input></td>
    <td><input type="radio" name="x3">3</input></td>
    <td><input type="radio" name="x3">4</input></td>
    <td><input type="radio" name="x3">5</input></td>
    <td align="left">(Often)</td>
  </tr>
  <tr>
    <th align="right">Do you drink alcohol?</th>
    <td align="right">(Strongly Mind)</td>
    <td><input type="radio" name="x2">1</input></td>
    <td><input type="radio" name="x2">2</input></td>
    <td><input type="radio" name="x2">3</input></td>
    <td><input type="radio" name="x2">4</input></td>
    <td><input type="radio" name="x2">5</input></td>
    <td align="left">(Don't Mind)</td>
  </tr>
  <tr>
    <th align="right">Do you smoke?</th>
    <td align="right">(Never)</td>
    <td><input type="radio" name="x1">1</input></td>
    <td><input type="radio" name="x1">2</input></td>
    <td><input type="radio" name="x1">3</input></td>
    <td><input type="radio" name="x1">4</input></td>
    <td><input type="radio" name="x1">5</input></td>
    <td align="left">(Often)</td>
  </tr>
  <tr>
    <th align="right">Do you mind if others smoke?</th>
    <td align="right">(Strongly Mind)</td>
    <td><input type="radio" name="x0">1</input></td>
    <td><input type="radio" name="x0">2</input></td>
    <td><input type="radio" name="x0">3</input></td>
    <td><input type="radio" name="x0">4</input></td>
    <td><input type="radio" name="x0">5</input></td>
    <td align="left">(Don't Mind)</td>
  </tr>
</table>
<p><b><u>*Please note, alcohol is not permitted anywhere on UNO campus.</u></b></p>
<p><b><u>*Please note, smoking is not permitted inside the buildings or on balconies / patios.</u></b></p>

<p><b>Please rank the following topics in order of importance to you (please rank 1-6, 1 being the most important):</b></p>
<table>
  <tr>
       <th><input type="text" size ="2"></input></th>
       <th align="left">Noise Level</th>
  </tr>
  <tr>
       <th><input type="text" size ="2"></input></th>
       <th align="left">Cleanliness</th>
  </tr>
  <tr>
       <th><input type="text" size ="2"></input></th>
       <th align="left">Lifestyle (Smoke & Alcohol use)</th>
  </tr>
  <tr>
       <th><input type="text" size ="2"></input></th>
       <th align="left">Age of Roommates</th>
  </tr>
  <tr>
       <th><input type="text" size ="2"></input></th>
       <th align="left">College Major of Roommates</th>
  </tr>
  <tr>
       <th><input type="text" size ="2"></input></th>
       <th align="left">Guests in Suite</th>
  </tr>
</table>
<br></br>
<b>Comments? Is there anything else you would like us to consider when assigning you to a room?</b>
<br></br>
<textarea rows="2" cols="50">
</textarea>
<br></br>
</div>
<table id="button_table" >
<tr>
<td><button type="reset" id="pretty_large_button" onclick="" value="Reset">Reset</button></td>
<td><button type="button" id = "pretty_large_button" onclick="">Submit</button></td>
</tr>
</table>
</form>
</div>

<?php
include ('includes/footer.html');
?>

