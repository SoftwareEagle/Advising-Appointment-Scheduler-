<!-- CEN 3073 Project
Advising Appointment Scheduler
Author: Justin Gosselin, Reza Ansary
Modified: March 7, 2015
-->

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

		<script src="js/vendor/custom.modernizr.js"></script>

	</head>
	<body>

		<div class="row">
			<div class="large-12 columns">
				<h1><img src="images/fgcu_logo.jpg" alt="logo">
                U.A. Whitaker College of Engineering
                </h1>
			</div>
		</div>

		<!-- End Header and Nav -->
	
		<div class="row">
			<div class="large-12 columns">
				<h4>Create an Account</h4>

				<p>
					Please fill out the information below to create an account. You should NOT use your existing FGCU login information!
                    <br>
                    <b>Note</b>: non-FGCU students should not make an account here. Please return to the homepage if you are not an FGCU student.
                    <br>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="large-6 columns">
					<form action="verify.php" method="post">

						<input type="text" name="firstName" autofocus placeholder="First name" maxlength="30" required>
						
						<input type="text" name="lastName" autofocus placeholder="Last name" maxlength="30" required>
                        
                        <input type="text" name="uin" autofocus placeholder="FGCU UIN" maxlength="9" required>
                        
                        <input type="password" name="pass" autofocus placeholder="Password" maxlength="25" required>
				
						<input type="text" name="email" autofocus placeholder="FGCU email address (used for login)" maxlength="70" required>
				
						<input type="text" name="phone" autofocus placeholder="Phone number" maxlength="10" required>

                        Select your major:
                        <br><br>
                        <select name="majors" onchange="major()">
                            <option value="bioeng">Bioengineering</option>
                            <option value="civileng">Civil Engineering</option>
                            <option value="enveng">Environmental Engineering</option>
                            <option value="sweng">Software Engineering</option>
                            <option value="undeclared">Undeclared</option>
                            <option value="other">Other</option>
                        </select>

                        If other, please specify:
                        <textarea id="otherMajor" name="otherMajor" autofocus="" maxlength="120" placeholder="Specify your major" style="width: 100%; height:95px; resize:none;" disabled="true"></textarea>

                        <!--
						Captcha:
						<form method="POST" action="verify.php">
                            <?php
                                require_once('recaptchalib.php');
                                $publickey = "6LcAywITAAAAAIUQYqNSkfExL75xpjQaR0LMkAVc"; 
                                echo recaptcha_get_html($publickey);
                            ?>
                        <br>
                        -->
                            
                        <input type="submit" name="cancel" id="cancel" value="Cancel" class="login" onclick="goBack()">
                        <script>
                            function goBack() {
                                window.history.back();
                            }
                            
                        </script>
                        <input type="submit" name="submit" id="submit" value="Submit" class="login">
                            
                        </form>
					</form>
				</p>
			</div>
</div>

		<!-- Call to Action Panel -->


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

        <script>
            function major() {
                var selectField = document.getElementById('majors');
                var selectedItem = selectField.options[selectField.selectedIndex].value;

                if (selectedItem == "other") {
                    document.getElementById('otherMajor').disabled=false;
                } else {
                    document.getElementById('otherMajor').disabled=true;
                }

            }

        </script>
		<!-- End Footer -->

	</body>
</html>

