<?php
/**
 * Created by Notepad++.
 * User: Justin Gosselin, Reza Ansary
 * Modified : Reza Ansary
 * Date: 4/19/2015
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
        <h4>Password Recovery</h4>
        Enter your FGCU e-mail and  your password will be sent to that email address.
		</br>
		</br>
    </div>
</div>
<div class="row">
    <div class="large-6 columns">
	<form action="sendEmail.php" method="post">
		<input type="text" name="email" id = "email" autofocus placeholder="FGCU E-mail" maxlength="70" required>
        <input id="button" type="submit" name="button" value="Submit" class="login" />
        <button type="button" onclick="goBack()" class="login">Back</button>
    </form>
	</div>
</div>
</body>

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
    function goBack() {
        window.history.back();
    }
</script>
</html>
