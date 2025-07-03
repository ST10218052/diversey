<?php
 $is_invalid= false ;
  session_start();

 
	IF($_SERVER["REQUEST_METHOD"]==="POST" ){

        if (isset($_POST['email1'])){
            $mysqli= require "DBconnect.php";//connecting to the db page
            $sql=sprintf("SELECT * FROM diverseysa.customer
                         Where customer.email='%s'",
                         $mysqli->real_escape_string($_POST["email1"]));
            
            $Email=	$_POST["email1"];		 
            $result=$mysqli->query($sql);
            $user=$result->fetch_assoc();
            if($user){
               $Pword=$_POST["password"];
               
               if(password_verify($Pword, hash: $user["password"])){
                
                if(!$user["email_verified_at"]==null){
    
                    echo '<script>alert("Login successful")</script>';
                    $_SESSION['user_logged_in'] = $Email;
                   
                    header("Location:index.php");
                      exit;
                }else{
                    echo '<script>alert("Email not verified")</script>';
                    header("Location: email-verification.php?email=".$Email);
                    exit();
                }
                 
                 
               }else{
                   echo '<script>alert("invalid password")</script>';
                   
        
               }
               
               
            }else{
                echo '<script>alert("Email not registered ")</script>';
            }
            $is_ivalid= true;
        }
		
	}
?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 //Load Composer's autoloader
 require 'vendor/autoload.php';

if( isset($_POST['Name']) )
{ //geting the input from the user
$Fname = $_POST['Name'];
$Pword = $_POST['password'];
// $Email= $_POST['email'];
$Email= $_POST['email'];
$Pnumbers= $_POST['PhoneNumber'];
$N_orders=0;
$Address= 'ssssss';
$hashed_Pword = password_hash($Pword,PASSWORD_DEFAULT);

include "DBConnect.php";// connecting to the database
//the sql needed to store values in the table
//$InsertSql ="INSERT INTO diverseysa.customer(name,email,phone_number,password,num_of_orders,address) VALUES('$Fname','$Email',0693065526,'$hashed_Pword' ,0,'$Address');";
//$sql=mysqli_query($mysqli,$InsertSql);
//$sql=mysqli_query($mysqli,$InsertSql);	

$checkValueExists = "SELECT customerID FROM diverseysa.customer 
					   WHERE 
					   customer.email='$Email'"; 
//$sql=mysqli_query($mysqli,$InsertSql);						
$result = mysqli_query($mysqli,$checkValueExists);
// verifying and checcking if the information entered does not already exist in the table
if(!$result){
   echo '<script>alert("This User Already Exists")</script>';// if it does
}
else{

   
   // Instantiate PHPMailer object
   $mail = new PHPMailer(true);
   
   try {
	   // Server settings
	   $mail->SMTPDebug = 2;                      // Disable verbose debug output (set to 2 for debugging)
	   $mail->isSMTP();                           // Set mailer to use SMTP
	   $mail->Host       = 'smtp.gmail.com';    // Specify your SMTP server
	   $mail->SMTPAuth   = true;                  // Enable SMTP authentication
	   $mail->Username   = 'lethabodiversey@gmail.com'; // SMTP username
	   $mail->Password   = 'nyfciuooyjicanht';       // SMTP password
	   $mail->SMTPSecure = 'tls';                 // Enable TLS encryption, `ssl` also accepted
	   $mail->Port       = 587;                   // TCP port to connect to
   
	   // Recipients
	   $mail->setFrom('diverseySa@gmail.com', 'admin');   // Your email and name
	   $mail->addAddress('lethabodiversey@gmail.com', 'Itani Mulaudzi'); // Recipient's email and name
   
	   // Content
	   $mail->isHTML(true);                       // Set email format to HTML
	   
	   $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

	   $mail->Subject = 'Email verification';
	   $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

	   
   
	   $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

	   $mail->Subject = 'Email verification';
	   $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

	   $mail->send();
	   echo 'Message has been sent';

	   
	   $InsertSql ="INSERT INTO diverseysa.customer(name,email,phone_number,password,num_of_orders,address, verification_code, email_verified_at) VALUES('$Fname','$Email',0693065526,'$hashed_Pword' ,0,'$Address','$verification_code',NULL);";
	   mysqli_query($mysqli, 	$InsertSql );
	   header("Location: email-verification.php?email=".$Email);
	   exit();
	   
   } catch (Exception $e) {
	   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }		
 
 

   }
}
?>
 


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="logIn.css">
	<link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="CHECKOUT.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>/* Style all input fields */
input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
}

/* Style the submit button */
input[type=submit] {
  background-color: #04AA6D;
  color: white;
}

/* Style the container for inputs */
.container {
  background-color: #f1f1f1;
  padding: 20px;
}

/* The message box is shown when the user clicks on the password field */
#message {
  display:none;
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 2px;
  margin-top: 3px;
}

#message p {
  padding: 1px 2px;
  font-size: 10px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -5px;
  content: "*";
}

/* Add a red text color and an "x" icon when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -4px;
  content: "&#10006;";
}</style>
    <title>LOGIN</title>
</head>

<body>
<div class="content">
<header class="header" >
    <a href="#home" class="logo">
       <img src="_images\logo2.jpg" alt="logo">
    </a>
   
    <NAV class="navbar" id="navbar">

        <ul id="navbar"> 
        <li>
                <a  href="index.php" onclick="setActive(this)" >home</a>                 
            </li>
            <li>
                <a href = "index.php"  onclick="setActive(this)">about</a>
            </li>
            <li>
                <a href = "index.php" onclick="setActive(this)">products</a>
            </li>
            <li>
                <a href="#contact" onclick="setActive(this)">Contact</a>  
            </li>
            <li>
                <a  href="Login.php" class="active" onclick="setActive(this)" class="login">login</a>                 
            </li>
        </ul>
        
    </NAV>
	
	
   <br>
    </div>
	</header>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form class="createAccount_form"  method="post" onsubmit="return validated()">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registeration</span>
                <input type="text" placeholder="Name" name="Name" id="Name" required>
                <input type="number" placeholder="PhoneNumber" name="PhoneNumber" id="PhoneNumber" required>
                <input type="email" placeholder="Email" name="email" id="email" required>
                <input type="password"  placeholder="Password"  autocomplete="new-password"  name="password" id="password" autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                <button type="submit">Sign Up</button>
               
            </form>
            <div id="message">
  <h3>Password must contain the following:</h3>
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
</div>
        </div>
       
<script>
var myInput = document.getElementById("password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
}

  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
        <div class="form-container sign-in">
        <form method="post" class="login_form"  onsubmit="return validated()">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email password</span>
                <input type="email" placeholder="Email" id="email1" name="email1"  >
                <?=htmlspecialchars($_POST["email"]??"")?>
              
                <input type="password" name="password" placeholder="Password" id="password"  autocomplete="new-password" >
               
                <a href="#">Forget Your Password?</a>
                <button>Sign In</button>
            </form>
            <script>
		document.getElementById('login_form').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form submission
  ////autocomplete="new-password"
  var username = document.getElementById('username').value;
  var password = document.getElementById('password').value;
  
  // Dummy authentication - Replace with actual authentication logic
  if (username === 'user123' && password === 'password') {
    // Set the logged in status in localStorage
    localStorage.setItem('isLoggedIn', 'true');
    alert('Login successful!');
    window.location.href = 'checkout.html'; // Redirect to index page
  } else {
    alert('Invalid username or password. Please try again.');

  }
});
	</script>
        </div>
        <div class="toggle-container"> 
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script1.js"></script>
</body>

</html>
<script>
    const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});
</script>
