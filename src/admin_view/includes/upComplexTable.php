<?php
$complex = mysqli_real_escape_string($dbconn, $_POST['complex']);

echo "<p>Selected Campus: $complex</p>";
echo '<form action="validate/update/upComplex.php" method="post">';
	echo "&nbsp; &nbsp; &nbsp; New complex name:";
	echo '<input name="oldComp" type="hidden" value="';
	echo $complex;
	echo '"/></input>';
	echo '<input name="newComp" type="text" value="';
	echo $complex;
	echo '"/></input><br/><br/>';
	echo "&nbsp; &nbsp; &nbsp; New campus:";
		echo'<select name="newCamp">';
			while( $row = mysqli_fetch_assoc($resCamp) ){
				foreach($row as $val){
					echo '<option value="'.$val.'">';
						echo $val;
					echo '</option>';
				}	
			}
		echo '</select><br/><br/>';
echo '<input class="button1" type="submit" value="Update"/><br/>';
echo '<br/><br/>';
