<!-- CEN 3073 Project
Advising Appointment Scheduler
Author: Justin Gosselin, Reza Ansary
Modified: March 7, 2015
-->

<!DOCTYPE html>
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width"/>

    <title>FGCU Advising Scheduler</title>

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/project.css">
    <link rel="stylesheet" href="css/styles.css">

    <script src="js/vendor/custom.modernizr.js"></script>
    <script src="js/sweetalert-master/lib/sweet-alert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="js/sweetalert-master/lib/sweet-alert.css">

</head>
<body>
<div class="row">
    <div class="large-12 columns">
        <h1><img src="images/fgcu_logo.jpg" alt="logo">
            U.A. Whitaker College of Engineering
        </h1>
    </div>
</div>

<div class="row">
    <div class="large-10 columns">
        <h4>Welcome to the Engineering Advising Appointment Creator!</h4>
    </div>
    <div class="large-2 columns">
        <input type="submit" name="login" id="logout" value="Logout" class="login" onclick="logout()">
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <p>
            Select an appropriate date below.
            <?php
            session_start();

            if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true) {
                echo "<script>alert (\"You must be logged in to use this page.\")</script>";
                echo "<script>window.location = 'default.php';</script>";
            }

            //echo $_SESSION['suin'];

            date_default_timezone_set('EST');

            $UIN = $_SESSION['suin'];

            echo "<input type='text' style='display:none' id ='myText' value='$UIN'>";


            define('DB_NAME', 'sweagle');
            define('DB_USER', 'root');
            define('DB_PASSWORD', '');
            define('DB_HOST', 'localhost');

            $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
            if (!$link) {
                die('Could not connect: ' . mysql_error());
            }
            $db_selected = mysql_select_db(DB_NAME, $link);
            if (!$db_selected) {
                die("Can't use" . DB_NAME . ":" . mysql_error());
            }


            function checkIfDateExistsDB($month, $day, $year)
            {
                $result = mysql_query("SELECT * FROM dates WHERE day = '$day' AND month = '$month' AND year = '$year' LIMIT 1");
                if (mysql_fetch_array($result) !== false)
                    return true;
                return false;
            }

            function getBlockedDates($day, $month, $year)
            {

                $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
                if (!$link) {
                    die('Could not connect: ' . mysql_error());
                }
                $db_selected = mysql_select_db(DB_NAME, $link);
                if (!$db_selected) {
                    die("Can't use" . DB_NAME . ":" . mysql_error());
                }

                if ($month == date('m')) {
                    for ($i = 1; $i < $day; $i++) {
                        if (!checkIfDateExistsDB($month, $i, $year)) {
                            //echo "Date doesn't exist: " . $i . "/" .$month . "/" . $year . "<br>";
                            $sqlInsertDate = "INSERT INTO dates(month, day, year, blocked) VALUES('$month', '$i', '$year', '1')";
                            mysql_query($sqlInsertDate);
                        } else {
                            //echo "Date exists: " . $i . "/" . $month . "/" . $year . "<br>";
                            $sqlUpdateDate = "UPDATE dates SET blocked='1' WHERE day='$i' AND month='$month' AND year='$year'";
                            mysql_query($sqlUpdateDate);
                        }
                    }
                }

                $sql = "SELECT month, day, year FROM dates WHERE blocked='1' AND month='$month' AND year = '$year'";
                $result = mysql_query($sql);
                $array_blocked_dates = array();
                $i = 0;
                while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
                    $array_blocked_dates[$i] = $row[1];
                    $i++;
                }

                // for every number less than the current date's number
                // we append to the array.

                sort($array_blocked_dates);
                mysql_close();

                return $array_blocked_dates;
            }


            function startsWith($haystack, $needle)
            {
                // search backwards starting from haystack length characters from the end
                return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
            }

            function endsWith($haystack, $needle)
            {
                // search forward starting from end minus needle length characters
                return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
            }


            /* draws a calendar */
            function draw_calendar($month, $year)
            {

                error_reporting(0);
                /* date settings */
                $month = (int)($_GET['month'] ? $_GET['month'] : date('m'));
                $year = (int)($_GET['year'] ? $_GET['year'] : date('Y'));
                $day = date('d');

                // prevent URl manipulation
                if ($month > date('m')+1 || $year > date('Y')) {
                    echo "<script>alert (\"I see you playing with the URL like that. You shall not pass!\")</script>";
                    $month = date('m'); // reset back to this month
                    $year = date('Y'); // reset back to this year
                }


                /* select month control */
                /*
                $select_month_control = '<select name="month" id="month">';
                for ($x = 1; $x <= 12; $x++) {
                    $select_month_control .= '<option value="' . $x . '"' . ($x != $month ? '' : '             selected="selected"') . '>' . date('F', mktime(0, 0, 0, $x, 1, $year)) . '</option>';
                }
                $select_month_control .= '</select>';


                /* select year control
                $year_range = 1;
                $select_year_control = '<select name="year" id="year">';
                for ($x = ($year - floor($year_range / 2)); $x <= ($year + floor($year_range / 2)); $x++) {
                    $select_year_control .= '<option value="' . $x . '"' . ($x != $year ? '' : ' selected="selected"') . '>' . $x . '</option>';
                }
                $select_year_control .= '</select>';
                */

                // only show next button for the next 1 month
                if ($month <= date('m'))
                    /* "next month" control */
                    $next_month_link = '<a href="?month=' . ($month != 12 ? $month + 1 : 1) . '&year=' . ($month != 12 ? $year : $year + 1) . '"    class="control">Next Month >></a>';

                // only show the previous button for any month after the current
                if ($month > date('m')) {
                    /* "previous month" control */
                    $previous_month_link = '<a href="?month=' . ($month != 1 ? $month - 1 : 12) . '&year=' . ($month != 1 ? $year : $year - 1) . '" class="control"><< 	Previous Month</a>';
                }

                /* bringing the controls together */
                $controls = '<form method="get">' . $previous_month_link . '     ' . $next_month_link . ' </form>';

                $dateObj = DateTime::createFromFormat('!m', $month);
                $monthName = $dateObj->format('F'); // month name

                echo '<h4 id="monthYear">' . $monthName . ' ' . $year . '</h4>';

                echo $controls;


                /* draw table */
                $calendar = '<table cellpadding="0" cellspacing="0" class="calendar" id="calendar">';

                /* table headings */
                $headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

                /* days and weeks vars now ... */
                $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
                $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
                $days_in_this_week = 1;
                $day_counter = 0;
                $dates_array = array();

                /* row for week one */
                $calendar .= '<tr class="calendar-row">';

                /* print "blank" days until the first of the current week */
                for ($x = 0; $x < $running_day; $x++):
                    $calendar .= '<td class="calendar-day-np"> </td>';
                    $days_in_this_week++;
                endfor;

                $counter = 0;

                $blocked_dates = getBlockedDates($day, $month, $year);

                /* keep going with days.... */
                for ($list_day = 1; $list_day <= $days_in_month; $list_day++):

                    if ($counter >= count($blocked_dates)) {
                        $counter = 0;
                    }

                    if (count($blocked_dates) == 0) {
                        $calendar .= '<td class="calendar-day">';
                        $calendar .= '<div class="day-number" id="day-number">' . $list_day . '</div>';
                    } else {
                        if ($list_day == $blocked_dates[$counter]) {
                            $calendar .= '<td class="calendar-day-blocked"></td>';
                            //$calendar .= '<div style="display: none" id="day-number">' . $list_day . '</div>';
                            $counter++;
                        } else {
                            $calendar .= '<td class="calendar-day">';
                            $calendar .= '<div class="day-number" id="day-number">' . $list_day . '</div>';
                        }
                    }

                    // class="day-number"
                    /* add in the day number */
                    //$calendar .= '<div class="day-number" id="day-number">' . $list_day . '</div>';

                    /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
                    $calendar .= str_repeat('<p> </p>', 2);


                    $calendar .= '</td>';
                    if ($running_day == 6):
                        $calendar .= '</tr>';
                        if (($day_counter + 1) != $days_in_month):
                            $calendar .= '<tr class="calendar-row">';
                        endif;
                        $running_day = -1;
                        $days_in_this_week = 0;
                    endif;
                    $days_in_this_week++;
                    $running_day++;
                    $day_counter++; //$counter++;

                endfor;

                /* finish the rest of the days in the week */
                if ($days_in_this_week < 8):
                    for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
                        $calendar .= '<td class="calendar-day-np"> </td>';
                    endfor;
                endif;

                /* final row */
                $calendar .= '</tr>';

                /* end the table */
                $calendar .= '</table>';


                /* all done, return result */
                return $calendar;
            }

            $todaysDate = date("Y/m/d");
            $year = substr($todaysDate, 0, 4);
            $month = substr($todaysDate, 5, 2);
            $day = substr($todaysDate, 8, 2);
            // if the first character in the String is a zero,
            // remove it
            if (startsWith($month, "0")) {
                $month = substr($month, 1, 1);
            }
            if (startsWith($day, "0")) {
                $day = substr($day, 1, 1);
            }

            // convert to int
            $year = intval($year);
            $month = intval($month);
            $day = intval($day);


            // without quotes on months
            $dateExists = checkIfDateExistsDB($month, $day, $year);

            if (!$dateExists) {
                $sql = "INSERT INTO dates(month,day,year) VALUES($month,$day,$year)";
                if (!mysql_query($sql)) {
                    die('Error: ' . mysql_error());
                }

                $result = mysql_query("SELECT id FROM dates WHERE day = '$day' AND month = '$month' AND year = '$year' LIMIT 1");

                $id = mysql_fetch_array($result, MYSQL_NUM);

                $sql = "INSERT INTO times(id,blocked_times) VALUES($id[0],'')";

                if (!mysql_query($sql)) {
                    die('Error: ' . mysql_error());
                }


            }
            // pass current date
            //$arrayOfBlockedDates = getBlockedDates($day, $month, $year);

            //mysql_close();

            /* sample usages */
            //$blocked_dates = array(6, 10, 14, 22, 25, 28); // has to be in increasing order!
            echo draw_calendar($month, $year);

            ?>
            <br>

        <div id="times" style="display: none; float: right" class="large-6 columns">
            <h4>Select an available appointment slot below:</h4>
            <table border="1" id="timeSlots">
                <tr>
                    <th>Time</th>
                </tr>
                <tr>
                    <td>8:00 am</td>
                    <td>8:30 am</td>
                    <td>9:00 am</td>
                    <td>9:30 am</td>
                    <td>10:00 am</td>
                    <td>10:30 am</td>
                </tr>
                <tr>
                    <td>11:00 am</td>
                    <td>11:30 am</td>
                    <td>12:00 pm</td>
                    <td>12:30 pm</td>
                    <td>1:00 pm</td>
                    <td>1:30 pm</td>
                </tr>
                <tr>
                    <td>2:00 pm</td>
                    <td>2:30 pm</td>
                    <td>3:00 pm</td>
                    <td>3:30 pm</td>
                    <td>4:00 pm</td>
                    <td>4:30 pm</td>
                </tr>

            </table>

        </div>
        <div class="large-6 columns" style="float: left">
            <h4>Select the closest reason for your visit below. Default time is 30 minutes.</h4>
            <input type="radio" name="reason" value="pgrad"
                   onclick="document.getElementById('otherReason').disabled = true; " checked="checked">Plan to
            Graduation<br>
            <input type="radio" name="reason" value="major"
                   onclick="document.getElementById('otherReason').disabled = true;">Change of Major<br>
            <input type="radio" name="reason" value="questions"
                   onclick="document.getElementById('otherReason').disabled = true;">Questions about my classes<br>
            <input type="radio" name="reason" value="gquestions"
                   onclick="document.getElementById('otherReason').disabled = true;">General questions<br>
            <input type="radio" name="reason" value="other"
                   onclick="document.getElementById('otherReason').disabled = false;">Other<br>
            If other, please specify:
            <textarea id="otherReason" name="otherReason" autofocus placeholder="Reason for Visit"
                      style="width: 100%; height:95px; resize:none;" disabled="true" maxlength="200"></textarea>
        </div>

        <div id="confirm" style="display: none; float: left">
        </div>
        </p>
    </div>
</div>

<!-- Footer -->
<footer class="row">
    <div class="large-12 columns">
        <hr/>
        <div class="row">
            <div class="large-6 columns">

                <section class="grid_5" id="footerlink2">

                    <p>
                        &copy; 2015, SWEagle, Florida Gulf Coast University
                    </p>

                </section>
            </div>
        </div>
    </div>
</footer>

<script type="text/javascript">

    var table = document.getElementById("calendar");

    if (table != null) {
        for (var i = 0; i < table.rows.length; i++) {
            for (var j = 0; j < table.rows[i].cells.length; j++)
                table.rows[i].cells[j].onclick = function () {
                    tableText(this);
                };
        }
    }

    function tableText(tableCell) {

        if (tableCell.className == "calendar-day-blocked") {
            alert("This day is not available for appointments. Please select a different date.");
        } else if (tableCell.className == "calendar-day") {


            var confirm = document.getElementById('confirm');
            confirm.innerHTML = "";
            document.getElementById('times').style.display = "block";

            var slots = document.getElementById('timeSlots');

            var dayNumber = tableCell.children[0].innerHTML;
            var monthYear = document.getElementById('monthYear').innerHTML;
            var mName = monthYear.substr(0, monthYear.indexOf(' '));
            var dat = new Date('1 ' + mName + ' 1999');
            var month = dat.getMonth() + 1;
            var year = monthYear.substr(monthYear.indexOf(' ') + 1);

            var selectedReasons = document.getElementsByName("reason");

            //var textReason = document.getElementById("otherReason").value;

            // The code underneath is an AJAX implementation

            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    var blockedTimes = xmlhttp.responseText;

                    blockedTimes = blockedTimes.slice(1, blockedTimes.length - 1);

                    var bTimesArray = new Array();

                    bTimesArray = blockedTimes.split(",");

                    for (x in bTimesArray) {
                        bTimesArray[x] = bTimesArray[x].replace("_", " ");
                        //alert(bTimesArray[x]);
                    }

                    if (slots != null) {
                        for (var i = 1; i < slots.rows.length; i++) {
                            for (var k = 0; k < slots.rows[1].cells.length; k++) {
                                slots.rows[i].cells.item(k).style.backgroundColor = "white";
                                for (var j = 0; j < bTimesArray.length; j++) {
                                    if (slots.rows[i].cells.item(k).innerHTML == bTimesArray[j]) {
                                        slots.rows[i].cells.item(k).style.backgroundColor = "red";
                                    }
                                }

                                slots.rows[i].cells.item(k).onclick = function () {
                                    checkTimes(this, month, dayNumber, year, blockedTimes, selectedReasons);
                                };
                            }


                        }

                    }

                }
            }
            xmlhttp.open("Get", "getBlockedTimes.php?day=" + dayNumber + "&month=" + month + "&year=" + year, true);
            xmlhttp.send();

        }

    }


    function checkTimes(cell, month, day, year, blockedTimes, reasons) {
        if (cell.style.backgroundColor == "red") {
            alert("This time is not available for appointments. Please select another time.");
            document.getElementById('confirm').style.display = "none";
        } else {

            var confirmDiv = document.getElementById('confirm');
            confirmDiv.innerHTML = "";
            var br = document.createElement("br");
            confirmDiv.appendChild(br);
            var time = cell.innerHTML;
            var printOutString = "You have selected an appointment for " + month + "/" + day + "/" + year + " at " + time;
            var timeBox = document.createTextNode(printOutString);

            confirmDiv.appendChild(timeBox);

            var br = document.createElement("br");
            confirmDiv.appendChild(br);

            var button = document.createElement("BUTTON");
            var t = document.createTextNode("Confirm");
            button.appendChild(t);
            confirmDiv.appendChild(button);

            confirmDiv.style.display = "block";

            button.onclick = function () {
                // make an appointmenttime
                // NOTE WE HAVE LEFT OUT THE INSERT OF ISTHIRTY
                /*This may require post*/
                for (var i = 0; i < reasons.length; i++) {
                    if (reasons[i].checked == true) {
                        var reason = reasons[i].value;
                    }
                }
                if (reason == "other") {
                    var otherReason = document.getElementById("otherReason").value;
                }

                swal({
                    title: "Are you sure?",
                    text: "Are you ABSOLUTELY SURE that you want to schedule an appointment for " + month + "/" + day + "/" + year + " at "
                    + time + "?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, schedule it!",
                    cancelButtonText: "No, go back",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        xmlhttp.onreadystatechange = function () {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                                var successful = xmlhttp.responseText;

                                //alert(successful);

                                if (successful == 0) {
                                    sweetAlert("Error", "You already have a scheduled appointment. " +
                                    "Please contact Rachel Boyce at rboyce@fgcu.edu if you wish to cancel.", "error");
                                } else if (successful == 1) {
                                    swal({
                                        title: "Success!",
                                        text: "Appointment scheduled successfully!",
                                        type: "success"
                                    }, function(){
                                        window.location.replace("default.php");
                                    });
                                    //window.location.replace("default.php");
                                }

                            }

                        }
                        xmlhttp.open("Get", "createAppointment.php?month=" + month + "&day=" + day + "&year=" + year + "&start=" + time + "&btimes=" + blockedTimes + "&uin=" + document.getElementById("myText").value
                        + "&reason=" + reason + "&text=" + otherReason, true);
                        xmlhttp.send();
                        //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    } else {
                        swal("Cancelled", "No appointment created.", "error");
                    }
                });

                /* backup of non sweet alert because "You Know" -- Reza Ansary
                if (!confirm("Are you ABSOLUTELY SURE that you want to schedule an appointment for" +
                    " " + month + "/" + day + "/" + year + " at " + time + "?")) {
                    alert("No appointment scheduled.");
                } else {
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                            var successful = xmlhttp.responseText;

                            //alert(successful);

                            if (successful == 0) {
                                alert("You already have a scheduled appointment. " +
                                "Please contact Rachel Boyce at rboyce@fgcu.edu if you wish to cancel.");
                            } else if (successful == 1) {
                                alert("Appointment scheduled successfully!");
                                location.reload();
                            }

                        }

                    }
                    xmlhttp.open("Get", "createAppointment.php?month=" + month + "&day=" + day + "&year=" + year + "&start=" + time + "&btimes=" + blockedTimes + "&uin=" + document.getElementById("myText").value
                    + "&reason=" + reason + "&text=" + otherReason, true);
                    xmlhttp.send();
                }
                */

            };
        }

    }


</script>
<script>
    document.write('<script src=js/vendor/' + ('__proto__' in {} ? 'zepto' : 'jquery') + '.js><\/script>');
</script>

<script>
function logout() {
    $.ajax({
        type: "POST",
        url: "logout.php"
    }).done(function() {
        window.location.replace("default.php");
    });
//window.location.replace("default.php");
}
</script>

<script src="js/foundation.min.js"></script>
<script>
    $(document).foundation();
</script>
<!-- End Footer -->

</body>

</html>
