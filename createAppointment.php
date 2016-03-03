<?php
date_default_timezone_set('EST');

	define('DB_NAME','sweagle');
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');

function hasAppointment($UIN){
    $result = mysql_query("SELECT hasUpApp FROM user WHERE UIN = '$UIN'");

    $row = mysql_fetch_array($result);

    return $row[0];

}
	
	$link = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	if(!$link){
		die('Could not connect: ' . mysql_error());
	}
	$db_selected = mysql_select_db(DB_NAME,$link);
	if(!$db_selected){
		die("Can't use" . DB_NAME . ":" . mysql_error());
	}


	$month=$_GET["month"];
	$day=$_GET["day"];
	$year=$_GET["year"];
	$start=$_GET["start"];
	$UIN = $_GET["uin"];
    $selectedReason = $_GET["reason"];
    $textReason = $_GET["text"];


/*
    $month=4;
    $day=28;
    $year=2015;
    $start="1:00 pm";
    $UIN = 814947531;
*/

	$btimes=$_GET["btimes"];

	$lengthOfMonth = strlen($month);
	if($lengthOfMonth == 1){
		// Append Leading Zero
		$s = "0";
		$month= $s . $month;
	}
	$lengthOfday = strlen($day);
	if($lengthOfday == 1){
		// Append Leading Zero
		$s = "0";
		$day= $s . $day;
	}

    if (!hasAppointment($UIN)) {
        $btimes = "\"".$btimes.",".$start."\"";


        $mdy = $month.$day.$year;

        $sql = "SELECT user_id FROM user WHERE UIN='$UIN'";

        $result = mysql_query($sql);
        $thing = mysql_fetch_array($result);

        if ($selectedReason != "other") {
            $sql = "INSERT INTO appointments(user_id,mdy,start,reason,isthirty)
                      VALUES('$thing[0]','$mdy','$start','$selectedReason','1')";
        } else if ($selectedReason == "other") {
            $sql = "INSERT INTO appointments(user_id,mdy,start,reason,isthirty)
                      VALUES('$thing[0]','$mdy','$start','$textReason','1')";
        } else {
            $sql = "INSERT INTO appointments(user_id,mdy,start,reason,isthirty)
				VALUES('$thing[0]','$mdy','$start','Error','1')";
        }

        if(!mysql_query($sql)){
            die('Error: '.mysql_error());
        }

        $sqlTwo = "SELECT id FROM dates WHERE day='$day' AND month='$month' AND year='$year'";

        $resultTwo = mysql_query($sqlTwo);
        $thingTwo = mysql_fetch_array($resultTwo);

        $sqlThree="UPDATE times SET blocked_times = '$btimes' WHERE id = '$thingTwo[0]'";

        if(!mysql_query($sqlThree)){
            die('Error: '.mysql_error());
        }
        $sqlUpdateAppt = "UPDATE user SET hasUpApp = '1' WHERE user_id ='$thing[0]'";
        if(!mysql_query($sqlUpdateAppt)){
            die('Error: '.mysql_error());
        }
        echo 1;
    } else {
        echo 0;
    }


/*
	if(!mysql_query($sql)){
		//die('Error: '.mysql_error());
		echo 0;
	} else {
        /*
        $msg = "You have scheduled an Engineering Advising appointment for ".$month."/".$day."/".$year." at ".$start;
        $msg = wordwrap($msg, 70);





        mail("seagermack@gmail.com", "ATTN: Engineering Advising Appointment", $msg);


        if(hasAppointment($UIN)){
            echo 0;
        }else{
            $sqlUpdateAppt = "UPDATE user SET hasUpApp = '1' WHERE user_id ='$thing[0]'";
            if(!mysql_query($sqlUpdateAppt)){
                die('Error: '.mysql_error());
            }
            echo 1;
        }

	}
*/
	
	
	
	
	mysql_close();
?>

