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
</body>
</html>





<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Validated Login Form</title>
	<link rel="stylesheet" href="logIn.css">
	<link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>
<header class="header" >
    <a href="#home" class="logo">
       <img src="_images\logo2.jpg" alt="logo">
    </a>


   
    <NAV class="navbar" id="navbar">

        <ul id="navbar"> 
                
            <li>
                <a  href="index.php"  onclick="setActive(this)" >home</a>                 
            </li>
            <li>
                <a href = "index.php#about"  onclick="setActive(this)">about us </a>
            </li>
            <li>
                <a href = "index.php#products" onclick="setActive(this)">products </a>
            </li>
           
            <li>
                <a href="index.php#contact" onclick="setActive(this)">ContactUs</a>  
            </li>
            <li>
                <a  href="Login.php" class="active" onclick="setActive(this)" class="login">login</a>                 
            </li>
        </ul>
        
    </NAV>
   <br>
   <br>
   

   <div class="icons78">
    <i class='bx bx-menu' id="menu-icon"></i>
     <div class="iconCart">
        <img src="_images/icon.png">
        <div class="totalQuantity">
        <?php
       $count=0;
       
        
      
      
       // echo"<span id=\"totalQuantity\" class=\"text-warming bg-light\"  font=\"80 px\" color=\"black\"  class=\>$count</spam>";
        ?>

        </div>
        
    </div>
   </div>
   
</header>    

<body>
	
	<div class="container">
        <p class="form__text1">
            <a href="index.html"><i class='bx bx-arrow-back'></i></a>
        </p>
        
		<h1 class="label">User Register</h1>
		<form class="login_form"  method="post" onsubmit="return validated()"  >
			<div class="font font2">Full Name</div>
			<input type="text" name="Name" id="Name">

            <div class="font font2">Phone Number</div>
			<input type="number" name="PhoneNumber" id="PhoneNumber">

            <div class="font">Email</div>
			<input autocomplete="off" type="text" name="email" id="email">
			<div id="email_error">Please fill up your Email or Phone</div>
			

            <div class="font font2">Password</div>
			<input type="password" name="password" id="password">

			<div id="pass_error">Please fill up your Password</div>
			<br>
			<button type="submit" >Register</button>
			<p class="form__text">
                <a class="form__link" href="Login.php" id="linkLogin">Already have an account? Sign in</a>
            </p>
		</form>
	</div>	
	<script src="valid.js"></script>

   