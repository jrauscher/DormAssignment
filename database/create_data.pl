#!/usr/bin/perl

use strict;
use warnings;
use List::Util qw(shuffle);

my $num_buildings = 0;
my @num_rooms = (50,20,40,50,40,30,20,15,50,60,30,20,40,50,30);
my $num_students = 545 * 4;
my $scott_scholar = 120;
my $num_admins = 1;

my @lease = (9,12);
my @NS = ("North","South");

print "\n-- Building DATA  --\n";

for (my $i=1; $i<=$num_buildings; $i++){
	my $floor = int(rand(8)) + 3;
	my $rand2 = int(rand(2));
	my $bin2 = int(rand(2));
	my $RA = int(rand(2));
	my $HC = int(rand(2));
	
	print 'INSERT INTO `building` (`build_id`,`building_name`,`building_letter`,`campus`,`num_rooms`,`floor`,`lease`,`RA_rooms`,`handicapped_rooms`)';
	print 'VALUES ("DEFAULT","building_name'.$i.'","","'.$NS[$bin2].'",'.$num_rooms[$i-1].','.$floor.','.$lease[$rand2].','.$RA.','.$HC.');' . "\n";
}


print "\n-- Rooms DATA  --\n";

for (my $i=1; $i<=$num_buildings; $i++){
	for (my $j=1; $j<=$num_rooms[$i-1]; $j++){
		$j += 100;
		my $floor = int(rand(4)) + 1;
		my $gender = int(rand(2));
		my $smoking = int(rand(2));

		print 'INSERT INTO `rooms` (`room_num`,`build_id`,`group_id`,`num_students`,`floor`,`gender`,`smoking`)';
		print 'VALUES ('."$j".',"'.$i.'","0","0",'.$floor.','.$gender.','.$smoking.');' . "\n";

		$j-= 100;
	}
	print "\n";
}


print "\n-- Room_Letter DATA  --\n";

for (my $i=1; $i<=$num_buildings; $i++){
	for (my $j=1; $j<=$num_rooms[$i-1]; $j++){
		$j += 100;		

		for (my $k=0; $k <4; $k++){
			print 'INSERT INTO `room_letter` (`room_num`,`build_id`,`student_id`,`letter`)';
			
			if ($k == 0){
				print 'VALUES ('.$j.','.$i.',0,"A");' . "\n";
			}
			if ($k == 1){
				print 'VALUES ('.$j.','.$i.',0,"B");' . "\n";
			}
			if ($k == 2){
				print 'VALUES ('.$j.','.$i.',0,"C");' . "\n";
			}
			if ($k == 3){
				print 'VALUES ('.$j.','.$i.',0,"D");' . "\n";
			}
		}

		$j -= 100;
	}
	print "\n";
}	


print "\n-- Student DATA  --\n";
$num_students -= 8;
my $std_id = 10000000;
my @col = ("College IST","Business","ART","Science","Math");
my @maj = ("Computer Science","MIS","IA","Phyiscs","Drawing");
my @btime = ("10:00:00","11:00:00","12:00:00","01:00:00","02:00:00","03:00:00");
my @wtime = ("05:00:00","06:00:00","07:00:00","08:00:00","09:00:00","10:00:00");
my @rate = (1,2,3,4,5,6);

for (my $i=1; $i<=$num_students; $i++){
	my $floor = int(rand()) + 1;
	my $binrand = int(rand(2));
	my $binrand2 = int(rand(2));
	my $grade_lvl = int(rand(5));
	my $college = int(rand(5));
	my $month = int(rand(12));
	my $day = int(rand(28));
	my $Hnum = int(rand(899)) + 100;
	my $Cnum = int(rand(899)) + 100;
	my $age = int(rand(40)) + 18;
	my $city = int(rand(25));
	my $clean = int(rand(5));
	my $noise = int(rand(5));
	my $guestS = int(rand(5));
	my $share = int(rand(5));
	my $coll = int(rand(5));
	my $bedT = int(rand(6));
	my $wakeT = int(rand(6));
	my $smoking = int(rand(6));
	my $assoc = int(rand(4));
	my @rrate = shuffle(@rate);	

	print 'INSERT INTO `students` (`student_id`,`group_id`,`room_num`,`build_id`,`first_name`,`last_name`,`gender`,`birthdate`,`cell_phone`,';
	print '`home_phone`,`email`,`age`,`address`,`city`,`state`,`zip`';
	print ',`lease`,`renewal`,`sub_date`,`scott_scholar`,`desired_roommate1`,`desired_roommate2`,`desired_roommate3`,`grade_lvl`,`enrolled_college`';
	print ',`enrolled_department`,`cleanliness`,`noise`,`guest_sleeping`,`share_belongings`,`bed_time`,`wakeup_time`,`gathering`,`drink_alchohol`,';
	print '`others_drink`,`smoking`,`others_smoking`,`noise_rateing`,`cleanliness_rateing`,`lifestyle_rateing`,`age_rateing`,`major_rateing`,`guest_rateing`,';
	print '`comments`,`comments_resolved`)'; 
	

	if($i < $scott_scholar){
		print 'VALUES ('.$std_id.',0,0,0,"stdFname'.$i.'","stdLname'.$i.'",'.$binrand.',"1990-'.$month.'-'.$day.'","'.$Cnum.'-'.$Cnum.'-'.$Cnum.'"';
		print ',"'.$Hnum.'-'.$Hnum.'-'.$Hnum.'","stdFname'.$i.'@testemail.com","'.$age.'","'.$day.''.$Hnum.' N St.","city'.$city.'","NE","68116",';
    	print '"'.$lease[$binrand].'","'.$binrand2.'","2014-6-'.$day.'","Y","","","","'.$grade_lvl.'","'.$col[$college].'",';
		print '"'.$maj[$clean].'","'.$clean.'","'.$noise.'","'.$guestS.'","'.$share.'","'.$btime[$bedT].'","'.$wtime[$wakeT].'","'.$clean.'","'.$noise.'",';
		print '"'.$share.'","'.$smoking.'","'.$smoking.'","'.$rrate[1].'","'.$rrate[2].'","'.$rrate[3].'","'.$rrate[4].'","'.$rrate[5].'","'.$rrate[0].'",';
		print '"Comments","N");';

	}
	elsif (($assoc == 3) && (($i % 2) == 0)){
		my $match = $i - 1;
		print 'VALUES ('.$std_id.',0,0,0,"stdFname'.$i.'","stdLname'.$i.'",'.$binrand.',"1990-'.$month.'-'.$day.'","'.$Cnum.'-'.$Cnum.'-'.$Cnum.'"';
		print ',"'.$Hnum.'-'.$Hnum.'-'.$Hnum.'","stdFname'.$i.'@testemail.com","'.$age.'","'.$day.''.$Hnum.' N St.","city'.$city.'","NE","68116",';
    	print '"'.$lease[$binrand].'","'.$binrand2.'","2014-6-'.$day.'","N","stdFname'.$match.'@testemail.com","","","'.$grade_lvl.'","'.$col[$college].'",';
		print '"'.$maj[$clean].'","'.$clean.'","'.$noise.'","'.$guestS.'","'.$share.'","'.$btime[$bedT].'","'.$wtime[$wakeT].'","'.$clean.'","'.$noise.'",';
		print '"'.$share.'","'.$smoking.'","'.$smoking.'","'.$rrate[1].'","'.$rrate[2].'","'.$rrate[3].'","'.$rrate[4].'","'.$rrate[5].'","'.$rrate[0].'",';
		print '"Comments","N");';
	}
	else {
		print 'VALUES ('.$std_id.',0,0,0,"stdFname'.$i.'","stdLname'.$i.'",'.$binrand.',"1990-'.$month.'-'.$day.'","'.$Cnum.'-'.$Cnum.'-'.$Cnum.'"';
		print ',"'.$Hnum.'-'.$Hnum.'-'.$Hnum.'","stdFname'.$i.'@testemail.com","'.$age.'","'.$day.''.$Hnum.' N St.","city'.$city.'","NE","68116",';
    	print '"'.$lease[$binrand].'","'.$binrand2.'","2014-6-'.$day.'","N","","","","'.$grade_lvl.'","'.$col[$college].'",';
		print '"'.$maj[$clean].'","'.$clean.'","'.$noise.'","'.$guestS.'","'.$share.'","'.$btime[$bedT].'","'.$wtime[$wakeT].'","'.$clean.'","'.$noise.'",';
		print '"'.$share.'","'.$smoking.'","'.$smoking.'","'.$rrate[1].'","'.$rrate[2].'","'.$rrate[3].'","'.$rrate[4].'","'.$rrate[5].'","'.$rrate[0].'",';
		print '"Comments","N");';

	}

	print "\n";
	$std_id ++;
}

print "\n-- User DATA  --\n";
my @complex = ("Scott Residence Hall","Scott Village","Scott Court");
$std_id = 10000000;
for (my $i=1; $i<=$num_students; $i++){
	if($i < $scott_scholar){
		my $randB = int(rand(2));
		print 'INSERT INTO `users` (`student_id`,`username`,`password`,`pwd_reset`,`needs_email`,`form_completion`,`building_name`)';
		print ' VALUES ("'.$std_id.'","stdFname'.$i.'@testemail.com","password'.$i.'","0","1","1","'.$complex[$randB].'");';
	}
	else {
		my $randB = int(rand(3));
		print 'INSERT INTO `users` (`student_id`,`username`,`password`,`pwd_reset`,`needs_email`,`form_completion`,`building_name`)';
		print ' VALUES ("'.$std_id.'","stdFname'.$i.'@testemail.com","password'.$i.'","0","1","1","'.$complex[$randB].'");';
	}

	$std_id ++;
	print "\n";
}

print "\n-- Admin DATA  --\n";
for (my $i=1; $i<=$num_admins; $i++){
	print 'INSERT INTO `admins` (`admin_id`,`username`,`password`,`pwd_reset`)'; 
	print 'VALUES ("'.$i.'","admin'.$i.'","apassword'.$i.'","0");';
	print "\n";
}





