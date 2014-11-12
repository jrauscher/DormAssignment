	<!DOCTYPE html>
	<html>
			<head>
			<link rel="stylesheet" href="../css/stylesheet.css" type="text/css">
			<link rel="stylesheet" href="../css/table.css" type="text/css">
			<link rel="stylesheet" href="../css/v_table.css" type="text/css">
			<link rel="shortcut icon" href="http://jtrtoday1.sytes.net:10080/Capstone/src/admin_view/favicon.ico"/>
			<meta charset="UTF-8">
			</head>
			<body>
			
		<div class="wrapper">


				<div id="header">
					<div id="navbar">
							<div class="img"><a href="index.php"><img src ="../images/scottcampuslogo.png"/></a></div>

						<ul>
<?php 
// Error vars
	$error1 = 'Error: building without a letter';
	

	function make_div()
	{
		echo '<div class="tab_div" id="';
			if((isset($_GET['tab'])) && ($_GET['tab'] == "home"))
			{
				echo 'home_div';
			}
			elseif((isset($_GET['tab'])) && ($_GET['tab'] == "manage"))
			{
				echo 'manage_div';
			}	
			elseif((isset($_GET['tab'])) && ($_GET['tab'] == "emails"))
			{
				echo 'emails_div';
			}	
			elseif((isset($_GET['tab'])) && ($_GET['tab'] == "settings"))
			{
				echo 'settings_div';
			}
			elseif((isset($_GET['tab'])) && ($_GET['tab'] == "submission_form"))
			{
				echo 'submit_div';
			}
				
		else
		{
				if(isset($_GET["page"]))
				{
					echo 'settings_div';
				}
				elseif (isset($_GET["sort"]))
				{
					echo 'emails_div';
				}
				else
				{
					echo 'home_div';
				}
		}
		echo '"></div>';
	}
	function make_tab($link,$id,$value,$pos)
	{
		$tab_c = strtolower($value);
		if ( preg_match('/\s/',$tab_c) )
		{
			$tab_c = preg_replace('/\s+/', '_', $tab_c); 
		}
		
		$label = '<label';	
		$checkness =  'list_of_elements';
		echo $label;		
	/*	echo '_newright';
*/
		echo '><li id="';
		//echo $id;
		//echo '" ';
		//if (isset($_GET['tab']) && ($value == $_GET['tab']))
		if (isset($_GET['tab']) && ($tab_c == $_GET['tab']))
		{
			//$label = '<label for="home2_tab';
			$id = $id .'2';
			$checkness ='list_of_elements_checked';
		}
		echo $id;
		echo '" ';
		echo 'class="'.$checkness.'"';
		echo '>'; 
?>

		<div class="tab_wrapper" id="tricky">
			<label for="tab_sub">
				<div class="tab_left" <?php echo 'id="'.$id; 
					if ($pos =="first")
					{
						echo '_first';
					}
					echo'_parts"'?>>
					<div <?php echo 'id="'.$id; 
					if ($pos =="first")
					{
						echo '_first';
					}
					echo '_left_circle"'?>></div>
				</div>
			</label>
			<?php echo'<div class="'. $id .'_newleft"><div></div></div>';?>
			<div class="tab_content" <?php echo 'id="'.$id.'_parts"'?>>
				<div class="tab_text">
					<font class="tab_font">
						<?php 
						echo $value; 
						?>
					</font>
				</div>
			</div>
			<?php echo'<div class="'. $id .'_newright"><div></div></div>';?>
			<label for="tab_sub">
				<div class="tab_right" <?php echo 'id="'.$id; 
					if ($pos =="last")
					{
						echo '_last';
					}
					echo '_parts"'?>>
					<div <?php echo 'id="'.$id; 
					if ($pos =="last")
					{
						echo '_last';
					}
					echo '_right_circle"'?>></div>
				</div>
			</label>
		</div>
	</li>
<?php
		echo '<form style="visibility:hidden; display:none" action="';
		echo $link;
		echo '" method="get">';
		echo '<input type="submit" id="tab_sub" name="tab';
		echo '" style="visibility: hidden;" value="';
		echo $tab_c;
		//echo $value;
		echo '">';
		echo '</form>';
		echo '</label>';
		
		$id3 = $id;
	}
?>
