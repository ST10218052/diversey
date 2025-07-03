<?php
session_start();
  $mysql= require"DBConnect.php";
 
 if (isset($_POST['add_to_cart'])){
    $session_array= array(
        'id'=>$_GET['id'],
        
        );         
	 if(isset($_SESSION['cart'])){
       
         $count=count($_SESSION['cart']);
		 $item_array_id=array_column($_SESSION['cart'],"id");
		 $session_array= array(
            'id'=>$_GET['id'],
            
            );
		//$session_array= array(
         //   'id'=>$_GET['id'],
          //  'name'=>$_POST['name'],
          //  'price'=>$_POST['price'],
            
        // );
        
        
		 if(in_array($_POST['id'],$item_array_id)){
			
            $session_array= array(
                'id'=>$_Post['id'],
                
                );
         echo "<script>alert('Product is already added in the cart..!')</script>";
            
		 
		 //$_SESSION['cart'][]=$session_array;
			 
		 }else{
		
            $count = count($_SESSION['cart']);
            $session_array= array(
                'id'=>$_GET['id'],
                
                );
            
           
            
            
        }
	 } else{
       
        $count = count($_SESSION['cart']);
        $session_array= array(
            'id'=>$_GET['id'],
            
            );

        // Create new session variable
        $_SESSION['cart'][0] = $item_array;
        print_r($_SESSION['cart']);
    }
 }
 
 



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
       // $count=count($_SESSION['cart']);
        //echo"<span id=\"totalQuantity\" class=\"text-warming bg-light\"  font=\"80 px\" color=\"black\"  class=\>$count</spam>";
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
    <?php
    $mysql= require"DBConnect.php";
    $sql="SELECT * FROM diversey.products";
   $result=mysqli_query($mysql,$sql);
while($row=mysqli_fetch_array($result)){?>

<div class="listProduct">

<div class="item">
    <form method= "post" action ="index.php?id=<?=$row['productID']?>">
    <img src="_images/<?=$row['description']?>" alt="">
    <h2><?=$row['product_name'];?></h2>
    <div class="price">R<?=number_format($row['price'],2);?> </div>
    <P>AAAAAAAAAA</P>
    <input type="hidden" name="name" value="<?=$row['product_name'];?>">
    <input type="hidden" name="price" value="<?=$row['price'];?>">
    <input type= "submit" name="add_to_cart"  class="btn btn-warning btn-block my-2" value="Add To Cart"> 
     <input type="hidden" name="id" value="<?=$row['productID'];?>">

    </form>
    </div>

</div>


<?php }?>
    
</div>

<div class="cart">
    <h2>
        CART
    </h2>

    <div class="listCart">
     <?php
      $product_id=array_column($_SESSION['cart'],'id');
     print_r($_SESSION['cart']);
     $mysql= require"DBConnect.php";
     $sql="SELECT * FROM diversey.products";
    $result=mysqli_query($mysql,$sql);
 while($row=mysqli_fetch_array($result)){
   
    foreach ($product_id as $id ) {
         if($row['productID'] == $id){    ?>
            <div class="item">
            <img src="_images/<?=$row['description']?>">
            <div class="content">
                <div class="name">"<?=$row['product_name'];?>"</div>
                <div class="price">"<?=$row['price'];?>"</div>
            </div>
            <div class="quantity">
                <button>-</button>
                <span class="value">3</span>
                <button>+</button>
            </div>
        </div>


            
           <?php
         }
    }
   } ?>
    <div class="buttons">
        <div class="close" id="close">
            
             <div class="close1">
                
                    <button>close</button>
               
             </div>
        </div>
        <div class="checkout">
            
            <button id="checkout">checkout</button>
        </div>
    </div>
</div>
<?php
			if(isset($_GET['action'])){
				
				if ($_GET['action']=="clearall"){
					
					unset($_SESSION['cart']);
				}
				if ($_GET['action']=="remove"){
					
					foreach($_SESSION['cart'] as $key  => $value){
						if($value['productID']==$_GET['productID']){
							
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
</form>

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
<script src="app.js"></script>
<script src="checkout.js"></script>
<script src="script.js"></script>

<script src="payment.js"></script>
</body>
</html>