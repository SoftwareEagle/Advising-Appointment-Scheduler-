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
		<!-- This is what you need -->
		<script src="js/sweetalert-master/lib/sweet-alert.min.js"></script>
		<link rel="stylesheet" href="js/sweetalert-master/lib/sweet-alert.css">
		<!--.......................-->
		
		
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
					<form action="verify.php" onsubmit ="return checkForm()" method="post">

						<input type="text" id="firstName" name="firstName" autofocus placeholder="First name" maxlength="30" required>
						
						<input type="text" id="lastName" name="lastName" autofocus placeholder="Last name" maxlength="30" required>
                        
                        <input type="text" id="uin" name="uin" autofocus placeholder="FGCU UIN" maxlength="9" required>
                        
                        <input type="password" id="pass" name="pass" autofocus placeholder="Password" maxlength="25" required>
						
						<input type="password" id="passTwo" name="passTwo" autofocus placeholder="Re-Enter Password" maxlength="25" required>
				
						<input type="text" id="email" name="email" autofocus placeholder="FGCU email address (used for login)" maxlength="70" required>
				
						<input type="text" id="phone" name="phone" autofocus placeholder="Phone number" maxlength="10" required>

                        <p>Select your major:<select name ="majors" id="majors" onchange="major()">
                            <option value="bioeng">Bioengineering</option>
                            <option value="civileng">Civil Engineering</option>
                            <option value="enveng">Environmental Engineering</option>
                            <option value="sweng">Software Engineering</option>
                            <option value="undeclared">Undeclared</option>
                            <option value="other">Other</option>
                        </select>
						Please specify:<textarea id="otherMajor" name="otherMajor" autofocus="" maxlength="120" placeholder="Specify your major" style="width: 100%; height:95px; resize:none;" disabled="true"></textarea>		
						<input type="submit" name="submit" id="submit" value="Submit" class="login">
						<button type="button" onclick="goBack()" class="login">Back</button>
						</p>

                        <!--
						Captcha:
						<form method="POST" action="verify.php">
                            <?php
                                require_once('recaptchalib.php');
                                $publickey = "6LcAywITAAAAAIUQYqNSkfExL75xpjQaR0LMkAVc"; 
                                echo recaptcha_get_html($publickey);
                            ?>
                        <br>
                       
                            
                        <input type="submit" name="cancel" id="cancel" value="Cancel" class="login" onclick="goBack()">
                        <script>
                            function goBack() {
                                window.history.back();
                            }
                            
                        </script>
                        <input type="submit" name="submit" id="submit" value="Submit" class="login">
                            
                        </form>
						 -->
						 
						 
						 
						 
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

        <script type="text/javascript">
			
            function major() {
                var selectField = document.getElementById('majors');
				
                var selectedItem = selectField.options[selectField.selectedIndex].value;
				

                if (selectedItem == "other") {
                    document.getElementById('otherMajor').disabled=false;
					
                } else {
                    document.getElementById('otherMajor').disabled=true;
                }

            }
			
			function goBack() {
                    window.history.back();
            }
			
			
			function checkForm()
			{
				
				// NAME VALIDATION
				var theFirstName = document.getElementById('firstName').value;
				var theLastName = document.getElementById('lastName').value;
				
				if(!(validateName(theFirstName) && validateName(theLastName)))
				{
					swal({   title: "Error!",   
							 text: "Ensure that you've entered your name correctly!",   
							 type: "error",   
							 confirmButtonText: "Cool" 
						});
					
					return false;
				}
			
				// UIN VALIDATION
				var theUin = document.getElementById('uin').value;
				if(!(theUin.match(/^[0-9]+$/) != null) || theUin.length != 9){
					
					swal({   title: "Error!",   
							 text: "Make sure you've entered your UIN correctly!",   
							 type: "error",   
							 confirmButtonText: "Cool" 
						});
					return false;
				}
			

				// PASSWORD VALIDATION
				var thePassword = document.getElementById('pass').value;
				var theReEnteredPassword = document.getElementById('passTwo').value;
				if(thePassword != theReEnteredPassword){
					
					swal({   title: "Error!",   
							 text: "The entered passwords differ!",   
							 type: "error",   
							 confirmButtonText: "Cool" 
						});
					return false;
				}
				
				
				// EMAIL VALIDATION
				var theEmail = document.getElementById('email').value;		
				if(!(verifyEmail(theEmail))){
					
					swal({   title: "Error!",   
							 text: "Not a valid email!",   
							 type: "error",   
							 confirmButtonText: "Cool" 
						});
					return false;
				}

				// PHONE VALIDATION
				var thePhoneNumber = document.getElementById('phone').value;
				if(!(thePhoneNumber.match(/^[0-9]+$/) != null)|| thePhoneNumber.length != 10){
					
					swal({   title: "Error!",   
							 text: "Your phone number should only include numbers and must be 10 digits",
							 type: "error",   
							 confirmButtonText: "Cool" 
						});
					
					return false;
				}

				// UIN DB EXISTENCE 
				if(uinExist(theUin)){
					
					swal({   title: "Error!",   
							 text: "UIN has already been registered",   
							 type: "error",   
							 confirmButtonText: "Cool" 
						});
						
					return false;
				} else if (emailExist(theEmail)) {
                    swal({   title: "Error!",
                        text: "Email has already been registered",
                        type: "error",
                        confirmButtonText: "OK"
                    });

                    return false;
                }
				else
				{
					swal({   title: "Success!",   
							 text: "Account Created! Please wait while redirect you back to the homepage.",   
							 type: "success",
                             timer: 10000,
                             showConfirmButton: false
						});
					
					alert("Account Created Successfully! Redirecting.......");

					return true;
					
				}
			}

			function uinExist(theUin){
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
						var responseFromPhp = xmlhttp.responseText;
						if(responseFromPhp == "E"){
							xmlhttp.onreadystatechange= true;
						}
					}
				}
				xmlhttp.open("GET", "checkUinExists.php?q=" + theUin, false);
				xmlhttp.send();
				if(xmlhttp.onreadystatechange===null){
					// Exists
					return true;
				}else{
					// DNE
					var boolCheck=null;
					swal("Good job!", "You clicked the button!", "success");
					setTimeout(function(){ 
						boolCheck=false;
					}, 3000);
					
					setTimeout(function(){ 
						boolCheck=false;
					}, 3000);
					
					
					
					
					
					
					return boolCheck;
					
				}	 
			}

            function emailExist(email){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
                        var responseFromPhp = xmlhttp.responseText;
                        if(responseFromPhp == "E"){
                            xmlhttp.onreadystatechange= true;
                        }
                    }
                }
                xmlhttp.open("GET", "checkEmailExists.php?q=" + email, false);
                xmlhttp.send();
                if(xmlhttp.onreadystatechange===null){
                    // Exists
                    return true;
                }else{
                    // DNE
                    var boolCheck=null;
                    swal("Good job!", "You clicked the button!", "success");
                    setTimeout(function(){
                        boolCheck=false;
                    }, 3000);

                    setTimeout(function(){
                        boolCheck=false;
                    }, 3000);






                    return boolCheck;

                }
            }
			
			
			
			function verifyEmail(email){
				var status = false;
				var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
				if (!(email.search(emailRegEx) == -1)) {
					status = true;
				}
				return status;
			}
			
			
			function validateName(name){ 
				
				var re = /^[A-Za-z]+$/;
				if(re.test(name))
					return true;
				else
					return false;
					     
			}

			
			
			

        </script>
		<!-- End Footer -->

	</body>
</html>

