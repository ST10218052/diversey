<?php
session_start();
  $mysql= require"DBConnect.php";
 $Q=1;
 if (isset($_POST['add_to_cart'])){
	 if(isset($_SESSION['cart'])){
		 
		 $session_array_id=array_column($_SESSION['cart'],"id");
        
		 
		 if (!in_array($_GET['id'],$session_array_id)){
			 $session_array= array(
		 'id'=>$_GET['id'],
		 'name'=>$_POST['name'],
		 'price'=>$_POST['price'],
         'quantity'=>$Q
		 );echo "<script>alert('Product added')</script>";
		 $_SESSION['cart'][]=$session_array;
			 
		 }else  {
          
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $_GET['id']) {
                    $item['quantity'] += 1; // Increase quantity by 1
                    $found = true; // Set found to true if product exists
                    echo "<script>alert('Quantity increased by 1')</script>";
                    break;
                }
            }
            
           
           
        
          
           
          
         }
	 }else{
        $session_array= array(
            'id'=>$_GET['id'],
            'name'=>$_POST['product_name'],
            'price'=>$_POST['price']
            
            );
		 $_SESSION['cart'][]=$session_array;
		 
	 }
 }
 
 $mysql= require"DBConnect.php";


 
 $sql = "SELECT * FROM diverseysa.messages ORDER BY created_at ASC";
$result1=mysqli_query($mysql,$sql);
 
 $messages = [];

 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<header class="header" >
    <a href="#home" class="logo">
       <img src="_images\logo2.jpg" alt="logo">
    </a>


   
    <NAV class="navbar" id="navbar">

        <ul id="navbar"> 
                
            <li>
                <a  href="index.html" class="active" onclick="setActive(this)" >home</a>                 
            </li>
            <li>
                <a href = "#about"  onclick="setActive(this)">about us </a>
            </li>
            <li>
                <a href = "#products" onclick="setActive(this)">products </a>
            </li>
           
            <li>
                <a href="#contact" onclick="setActive(this)">ContactUs</a>  
            </li>
            <li>
                <a  href="Login.php" onclick="setActive(this)" class="login">login</a>                 
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
       
        
      
      
        echo"<span id=\"totalQuantity\" class=\"text-warming bg-light\"  font=\"80 px\" color=\"black\"  class=\>$count</spam>";
        ?>

        </div>
        
    </div>
   </div>
   
</header>    

<section class="home" id="home">
 <div class="home-content">
 <h3>Welcome to</h3>
 <h1>Diversy</h1>
 <h3>Going beyond clean</h3>
 <a href="#products" class="btn">Our Products</a>
 </div>

</section>

<section class="about" id="about">
<div class="about-content">
    <h2 class="heading">About <span>Us</span></h2>
   <p>100 years later, the Diversey name has become synonymous with innovation and quality. Diversey is a trusted leading global pure-play provider to the cleaning and hygiene industry for the institutional and food & beverage markets.</p>
<a  class="btn" id="popupBtn">Read More</a>
<div id="popup" class="popup">
    <!-- Popup content -->
    <div class="popup-content">
        <span class="close">&times;</span>
        <p> A Solenis Company, we are relentlessly pursuing our purpose to go beyond clean to take care of what’s precious. In today’s world of increasing resource scarcity – including water, energy, materials, and labor – we need to achieve more with less for the well-being of today’s generations and for future generations.</p>
</p>
    </div>
</div>

<script>
    // Get the popup
    var popup = document.getElementById("popup");

    // Get the button that opens the popup
    var btn = document.getElementById("popupBtn");

    // Get the <span> element that closes the popup
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the popup
    btn.onclick = function() {
        popup.style.display = "block";
    }

    // When the user clicks on <span> (x), close the popup
    span.onclick = function() {
        popup.style.display = "none";
    }

    // When the user clicks anywhere outside of the popup, close it
    window.onclick = function(event) {
        if (event.target == popup) {
            popup.style.display = "none";
        }
    }
</script>
</div>

</section>
<section class="products" id="products" >
<div class="container">
<div class="listProduct">
    <?php
    $mysql= require"DBConnect.php";
    $sql="SELECT * FROM diverseysa.products";
   $result=mysqli_query($mysql,$sql);
while($row=mysqli_fetch_array($result)){?>



<div class="item">
    <form method= "post" action ="index.php?id=<?=$row['id']?>">
    <img src="_images/<?=$row['image']?>" alt="">
    <h2><?=$row['name'];?></h2>
    <div class="price">R<?=number_format($row['price'],2);?> </div>
    <P>AAAAAAAAAA</P>
    <input type="hidden" name="name" value="<?=$row['name'];?>">
    <input type="hidden" name="price" value="<?=$row['price'];?>">
    <input type= "submit" name="add_to_cart"  class="btn btn-warning btn-block my-2" value="Add To Cart"> 


    </form>
    </div>




<?php }?>
</div>
</div>

<div class="cart">
    <h2>
        CART
    </h2>

    <div class="listCart">

     
     

    <?php
  
 $mysql= require"DBConnect.php";
 $sql="SELECT * FROM diverseysa.products";
$result=mysqli_query($mysql,$sql);
while($row=mysqli_fetch_array($result)){

    // Check if the cart is not empty
    if (!empty($_SESSION['cart'])) {
        // Loop through the cart items
        foreach ($_SESSION['cart'] as $key => $item) {
            $id=htmlspecialchars($item['id']);
            if($row['id'] == $id){
            ?>
             <div class="item">
            <img src="_images/<?=$row['name']?>">
            <div class="content">
                <div class="name">"<?=$row['name'];?>"</div>
                <div class="price">"<?=$row['price'];?>"</div>
            </div>
            <div class="quantity">

            <div>
                <form action="quantity.php" method="post">
                   
                    <!-- Decrease Quantity Button -->
                    <button type="submit" name="action" value="decrease"> < </button>
                  <span class="value"><?php echo htmlspecialchars($item['quantity']); ?></span>
                    <!-- Increase Quantity Button -->
                    <button type="submit" name="action" value="increase"> > </button>
                    
                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                </form>
            </div>
            </div>
           
           
            </div>
            <?php
            }
        }
    }; 
}
    ?>
      
   
    </div>
    
    <div class="buttons">
        <div class="close" id="close">
            
             <div class="close1">
                
                    <button>close</button>
               
             </div>
        </div>
        <form action="checkout.php"  class="checkout">
            
            <button id="checkout1"  >checkout</button>
        </form>
    </div>
</div>
<?php
			if(isset($_GET['action'])){
				
				if ($_GET['action']=="clearall"){
					
					unset($_SESSION['cart']);
				}
				if ($_GET['action']=="remove"){
					echo "<script>alert('Product added')</script>";
					foreach($_SESSION['cart'] as $key  => $value){

						if($value['id']==$_GET['id']){
							echo "<script>alert('Product added')</script>";
							unset($_SESSION['cart'][$key]);
						}
					}
				}
				
				
			}
			
			?>
</section>

<section class="contact" id="contact">
<h2 class="heading">Contact Us</h2>


<form action="#">
 <div class="input-box">
    <input type="text" placeholder="Full  Name">
    <input type="email" placeholder="Email">

 </div>
 <div class="input-box">
    <input type="number" placeholder="Phone Number">
    <input type="text" placeholder="subject">
 </div>
 <textarea name="" id=""  cols="30" rows="10" placeholder="Your Message">

 </textarea>
<input type="submit" value="Send Message" class="btn">
<a  class="btn" id="popupBtn1">check Messages</a>
<div class="card">

</form>



      <?php
while ($row=mysqli_fetch_array($result1)) {
  ?>

<div class="user">
<p><?=$row['username'];?></p>
<div class="message">
    <p><?=$row['message'];?></p>
</div>
</div>


<?php  echo json_encode($messages);}?>
<form id="chatForm" method="post" >
    <input type="hidden" name="user_type" value="user"> <!-- Adjust as needed -->
    <input type="text" name="message" id="messageInput" placeholder="Type your message..." autocomplete="off">
    <input type="submit" value="send" name="message1">
</form>
<?php



?>
<script>
    function fetchMessages() {
        fetch('get_messages.php')
            .then(response => response.json())
            .then(messages => {
                const chatbox = document.getElementById('chatbox');
                chatbox.innerHTML = '';
                messages.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('message', message.user_type);
                    messageElement.textContent = message.username + ': ' + message.message;
                    chatbox.appendChild(messageElement);
                });
                chatbox.scrollTop = chatbox.scrollHeight; // Scroll to bottom
            });
    }

    document.getElementById('chatForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        fetch('send_message.php', {
            method: 'POST',
            body: formData
        }).then(() => {
            document.getElementById('messageInput').value = ''; // Clear input
            fetchMessages(); // Refresh messages
        });
    });

    // Fetch messages every 2 seconds
   
    fetchMessages(); // Initial fetch
</script>

    





</section>

<footer class="footer">
<div class="socials" id="socials">
    
    
    <a href="#"><i class='bx bxl-instagram' ></i></a>
    <a href="#"> <i class='bx bxl-facebook' ></i></a>
  <a href="#"><i class='bx bxl-twitter'></i></a>
  <a href="#"><i class='bx bxl-whatsapp'></i></a>
 
</div>

<ul class="list">
    <li>
        <a href="#">FAQ</a>
    </li>
    <li>
        <a href="#products">products</a>
    </li>
    <li>
        <a href="#about">About Us</a>
    </li>
    <li>
        <a href="#contact">Contact</a>
    </li>
    <li>
        <a href="#">Privacy policy</a>
    </li>
    <li>
        <a href="messages_U.php">chat</a>
    </li>
</ul>

<p class="copyright">
    @ 2024 Diversey|inc 
</p>
</footer>
<script>
    function setActive(element) {
      var navItems = document.querySelectorAll('#navbar');
      navLinks.forEach(links=>{
        links.classList.remove('active');
      //  document.querySelector('header nav a [href*='+ id +']').classList.add('active')
    })
      element.classList.add('active');
    }
    </script>
   
   <script>
    let iconCart = document.querySelector('.iconCart');
let cart = document.querySelector('.cart');
let container = document.querySelector('.container');
let close = document.querySelector('.close1');

iconCart.addEventListener('click', function(){
    if(cart.style.right == '-100%'){
        cart.style.right = '0';
        container.style.transform = 'translateX(-400px)';
    }else{
        cart.style.right = '-100%';
        container.style.transform = 'translateX(0)';
    }
})
close.addEventListener('click', function (){
    cart.style.right = '-100%';
    container.style.transform = 'translateX(0)';
})
 


   </script>
   <?php


// Example: Initialize cart session for demonstration purposes


?>
<script src="app.js"></script>
<script src="checkout.js"></script>
<script src="script.js"></script>

<script src="payment.js"></script>
</body>
</html>