<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="logIn.css">
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
                <a  href="Login.php" class="active" onclick="setActive(this)" class="login">login</a>                 
            </li>
        </ul>
        
    </NAV>
   
   

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
<br>
<br>

<body>

<div class="container" id="container">
    
<div class="  form-container info">

<form method="POST"  class="verify_email">
<h1>verify your account</h1>
<input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>

<input type="text" name="verification_code" placeholder="Enter verification code" required />

<input type="submit" name="verify_email" value="Verify Email">
</form>
    </div>


</div>

</body>
</html>

<?php
$mysql = require "DBConnect.php";

if (isset($_POST["verify_email"])) {
    $email = $_POST["email"];
    $verification_code = $_POST["verification_code"];

    // Ensure email and verification code are provided
    if (!empty($email) && !empty($verification_code)) {

        // Prepare the SQL query with placeholders
        $stmt = $mysql->prepare("UPDATE diverseysa.customer SET email_verified_at = NOW() WHERE email = ? AND verification_code = ?");
        $stmt->bind_param("ss", $email, $verification_code);  // Bind parameters

        // Execute the statement
        $stmt->execute();

        // Check if any row was updated
        if ($stmt->affected_rows > 0) {
            echo '<script>alert("Verification successful. You can login now.");</script>';
            header("Location: Login.php");  // Redirect to login page
            exit();
        } else {
            echo "<script>alert('Verification code failed or is invalid. Please try again.');</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>alert('Both email and verification code are required.');</script>";
    }
}
?>
