<?php
/**
 * Created by PhpStorm.
 * User: Justin Gosselin, Reza Ansary
 * Date: 4/5/2015
 * Time: 1:40 PM
 */
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width" />

    <title>FGCU Advising Scheduler</title>

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/project.css">
    <link rel="stylesheet" href="css/elements.css">
    <link rel="stylesheet" href="http://css-spinners.com/css/spinner/spinner.css" type="text/css">

    <script src="js/vendor/custom.modernizr.js"></script>
    <script src="js/my_js.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="js/app.js"></script>

    <script src="js/sweetalert-master/lib/sweet-alert.min.js"></script>
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
    <div class="large-12 columns">
        <h4>Welcome to the Engineering Advising Appointment Creator!</h4>
        To begin, enter your FGCU e-mail and password below:
        <br><font size="2"><b>Note:</b> this login is separate from your normal FGCU logins.</font>
    </div>
</div>
<div class="row">
    <div class="large-6 columns">
        <p>
            <br>
            <input type="text" name="email" id = "email" autofocus placeholder="FGCU E-mail" maxlength="70" required>
            <input type="password" name="password" id = "password" autofocus placeholder="Password" maxlength="25" required>
            <input type="submit" name="login" id="login" value="Login" class="login" onclick="checkLogin()">
			
            <br>
            <br>
            First time here?
            <a href="CreateAccount.php">Click here to create an account.</a>
            <br>
            Not an FGCU student?
            <a href="#" onclick="div_show()">Click here.</a>
			 <br>
            Forgot Password?
            <a href="forgotpassword.php">Click here.</a>
        </p>
    </div>
</div>

<!-- Footer -->
<footer class="row">
    <div class="large-12 columns">
        <hr />
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

<script>
    document.write('<script src=js/vendor/' + ('__proto__' in {} ? 'zepto' : 'jquery') + '.js><\/script>');
</script>

<script src="js/foundation.min.js"></script>
<script>
    $(document).foundation();
</script>
<!-- End Footer -->

</body>

<div class="bodyPopup">
    <div id="abc" style="display: none;">
        <!-- Popup Div Starts Here -->
        <div id="popupContact">
            <div class="spinner" style="display: none;" id="spinner"></div>
            <!-- Contact Us Form -->
            <form id="contactForm" name="form" class="formPopup" method="POST" action="non_fgcu_email.php">
                <img id="closePopup" src="images/3.png" onclick ="div_hide()">
                <h2 class="h2Popup">Non-FGCU Students</h2>
                <hr class="hrPopup">
                <h4 class="h4Popup">Your information below will be sent to Rachel Boyce, the advising secretary.</h4>
                <hr class="hrPopup">
                <input id="name" name="name" placeholder="Name" type="text" class="inputPopup">
                <input id="email" name="email" placeholder="Email" type="text" class="inputPopup">
                <input id="phone" name="phone" placeholder="Phone Number" type="text" class="inputPopup" maxlength="10">
                <input id="school" name="school" placeholder="Institution" type="text" class="inputPopup">
                <textarea id="msg" name="msg" placeholder="Reason for Visit" class="textareaPopup"></textarea>
                <a href="javascript:%20check_empty()" id="submitPopup" class="link">Send</a>
            </form>
        </div>
        <!-- Popup Div Ends Here -->
    </div>
    <!-- Display Popup Button -->
    </body>
</div>

<script>
	
    function checkLogin() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        if(window.XMLHttpRequest){
            xmlhttp = new XMLHttpRequest();
        }else{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function(){
            if(xmlhttp.readyState == 4 && xmlhttp.status ==200){
                var successful = xmlhttp.response;

                //alert(successful);
                if(successful.charAt(0) == 1){

                    window.location.replace("scheduleAppointment.php");

                }else{
                    swal("Error", "Incorrect username or password.", "error");
                }
            }
        }
        xmlhttp.open("GET","login.php?username="+email+"&password="+password,true);
        xmlhttp.send();
    }
	



</script>

</html>