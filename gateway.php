
<?php
 session_start();

 if (empty($_SESSION['user_logged_in']) ) {
     // User is not logged in, redirect to login page
     header("Location: login.php");
     exit;}else{
        $user=$_SESSION['user_logged_in'];
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="checkout.css">
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
                <a href="index.php" onclick="setActive(this)">Contact</a>  
            </li>
        </ul>
        
    </NAV>
	
	
   <br>
   <br>
    </div>
    <div class="user-wrapper">
                <?php if (isset($profile_picture)) { ?>
                    <div class="profile-picture">
                        <p> "<?php $user ?>" </p>
                    </div>
                <?php } ?>
   
	</header>
<div class="container">

    <form action="payment.php">

        <div class="row">

            <div class="col">

                <h3 class="title">billing address</h3>

                <div class="inputBox">
                    <span>full name :</span>
                    <input type="text" placeholder="john deo">
                </div>
                <div class="inputBox">
                    <span>email :</span>
                    <input type="email" placeholder="example@example.com">
                </div>
                <div class="inputBox">
                    <span>address :</span>
                    <input type="text" placeholder="room - street - locality">
                </div>
                <div class="inputBox">
                    <span>city :</span>
                    <input type="text" placeholder="mumbai">
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>state :</span>
                        <input type="text" placeholder="india">
                    </div>
                    <div class="inputBox">
                        <span>zip code :</span>
                        <input type="text" placeholder="123 456">
                    </div>
                </div>

            </div>

            <div class="col">

                <h3 class="title">payment</h3>

                <div class="inputBox">
                    <span>cards accepted :</span>
                    <img src="_images/card_img.png" alt="">
                </div>
                <div class="inputBox">
                    <span>name on card :</span>
                    <input type="text" placeholder="mr. john deo" required>
                </div>
                <div class="inputBox">
                    <span>credit card number :</span>
                    <input type="number" placeholder="1111-2222-3333-4444" required>
                </div>
                <div class="inputBox">
                    <span>exp month :</span>
                    <input type="text" placeholder="january" required>
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>exp year :</span>
                        <input type="number" placeholder="2022" required>
                    </div>
                    <div class="inputBox">
                        <span>CVV :</span>
                        <input type="text" placeholder="1234" required>
                    </div>
                </div>

            </div>
    
        </div>

        <input type="submit" value="proceed to checkout" class="submit-btn">

    </form>

</div>    
    
</body>
</html>