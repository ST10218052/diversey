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

$checkValueExists = "SELECT id FROM diverseysa.customer 
					   WHERE 
					   customer.email='$Email'"; 
//$sql=mysqli_query($mysqli,$InsertSql);						
$result = mysqli_query($mysqli,$checkValueExists);
// verifying and checcking if the information entered does not already exist in the table
if($result){
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
 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="logIn.css">
    <title>Modern Login Page | AsmrProg</title>
</head>

<body>

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
                <input type="text" placeholder="Name" name="Name" id="Name">
                <input type="number" placeholder="PhoneNumber" name="PhoneNumber" id="PhoneNumber">
                <input type="email" placeholder="Email" name="email" id="email">
                <input type="password" placeholder="Password" name="password" id="password">
                <button>Sign Up</button>
            </form>
        </div>
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
                <input type="email" placeholder="Email" id="email1" name="email1">
                <?=htmlspecialchars($_POST["email"]??"")?>
              
                <input type="password" name="password" placeholder="Password" id="password">
               
                <a href="#">Forget Your Password?</a>
                <button>Sign In</button>
            </form>
            <script>
		document.getElementById('login_form').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form submission
  
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
