<?php
session_start();
$mysql = require "DBConnect.php";

// Quantity initialized to 1 (you can adjust this logic if needed)
$Q = 1;

// Add to cart functionality
if (isset($_POST['add_to_cart'])) {
    // Check if the cart session exists
    if (isset($_SESSION['cart'])) {
        // Extract the IDs of products already in the cart
        $session_array_id = array_column($_SESSION['cart'], "id");

        // If product is not in the cart, add it
        if (!in_array($_GET['id'], $session_array_id)) {
            $session_array = array(
                'id' => $_GET['id'],
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'quantity' => $Q
            );
            echo "<script>alert('Product added')</script>";
            $_SESSION['cart'][] = $session_array;
        } else {
            // If product is already in the cart, update the quantity
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $_GET['id']) {
                    $item['quantity'] += 1; // Increase quantity by 1
                    echo "<script>alert('Quantity increased by 1')</script>";
                    break;
                }
            }
        }
    } else {
        // If no cart session exists, create one and add the first product
        $session_array = array(
            'id' => $_GET['id'],
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'quantity' => $Q
        );
        echo "<script>alert('Product added')</script>";
        $_SESSION['cart'][] = $session_array;
    }
}

// Fetch messages from the database
$sql = "SELECT * FROM diverseysa.messages ORDER BY created_at ASC";
$result1 = mysqli_query($mysql, $sql);

// Initialize an empty array to store messages
$messages = [];

if ($result1) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $messages[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($mysql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="st.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        
        .profile {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
          pad;
        }
        .accountIcon i{
            
           font-size:35px;
           padding-left:40px ;
           margin-left: 10px;
           margin-right: 5px;
           margin-top:5px;
           color: rgb(0, 0, 235); 
        }.accountIcon {
            padding:10px ;
            padding-top: 1px;
            margin-right: -40px;
            margin-top: -25px;
        }
        

.dropdown-content {
    display: none;
    position: absolute;
    right: 90px;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 15px 8px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.account-dropdown:hover .dropdown-content {
    display: block;
}

#account-icon {
    cursor: pointer;
}

    /* Chatbot modal styling */
    .chatbot-modal {
            display: none;
            position: fixed;
            bottom: 0;
            right: 15px;
            width: 300px;
            height: 400px;
            background-color: white;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            z-index: 1000;
        }
        .chatbot-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chatbot-body {
            height: 80%;
            padding: 10px;
            overflow-y: auto;
            font-family: Arial, sans-serif;
        }
        .chatbot-footer {
            padding: 10px;
            display: flex;
            align-items: center;
            border-top: 1px solid #ddd;
        }
        .chatbot-footer input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .chatbot-footer button {
            background-color: #007bff;
            color: white;
            border: none;
            margin-left: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        /* Chat icon */
        #chatIcon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            padding: 15px;
            cursor: pointer;
            z-index: 999;
        }

        .prodHeader h1{
            color: blue;
            font-size: 50px;
            margin-bottom: 30px;
            padding-top: -20px;
        }

        .modal {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}
.modal-content {
    background: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    position: relative;
}
.modal-content p{
    font-size:20px;
}
.modal-content button,
.btn {
    padding: 10px;
    background: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    margin: 10px 0;
}
.close-btn {
    background: #f44336;
}
    </style>
   
</head>
<body>
<header class="header" >
    <a href="#home" class="logo">
       <img src="_images\logo2.jpg" alt="logo">
    </a>


   
    <NAV class="navbar" id="navbar">

        <ul id="navbar">        
            <li>
                <a  href="index.php" class="active" onclick="setActive(this)" >home</a>                 
            </li>
            <li>
                <a href = "#about"  onclick="setActive(this)">about</a>
            </li>
            <li>
                <a href = "#products" onclick="setActive(this)">products </a>
            </li>
            <li>
                <a href="#contact" onclick="setActive(this)">Contact</a>  
            </li>
        
            <li>
                <a href="bot.php" onclick="setActive(this)">Chat</a>  
            </li>
        </ul>
        
    </NAV>
    
<div class="accountIcon">
    <div class="account-dropdown">
        <i class="fa-solid fa-circle-user" id="account-icon"></i>
        <div class="dropdown-content" id="dropdown-menu">
            <a href="Login.php?role=user">User</a>
            <a href="#" onclick="showAdminPrompt()">Admin</a>
        </div>
    </div>
</div>
   
   <div class="icons78">
    <i class='bx bx-menu' id="menu-icon"></i>
     <div class="iconCart">
        <img src="_images/icon.png">
        <div class="totalQuantity">
        <?php
       $count=0;
       
      if(isset($_SESSION['cart'])){
        
        $count= count($_SESSION['cart']);
       }
      
      
      
       // echo"<span id=\"totalQuantity\" class=\"text-warming bg-light\"  font=\"80 px\" color=\"black\"  class=\>$count</spam>";
        
  
  
        echo"<span id=\"totalQuantity\" class=\"text-warming bg-light\"  font=\"80 px\" color=\"black\"  class=\>$count</spam>";
        ?>
        </div>
        
    </div>
    
   </div>
  
</header>    

<section class="home" id="home">
 <div class="home-content">
 <h3>Welcome to</h3>
 <h1>Diversey SA</h1>
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
    <div class="prodHeader">
        <h1>Products</h1>
    </div>
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
    <P color="black"><?=$row['description'];?></P>
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
            <img src="_images/<?=$row['image']?>">
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

<div id="adminPrompt" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Do you to procced to admin account?</p>
        <button onclick="handleAdminResponse(true)">Yes</button>
        <button onclick="handleAdminResponse(false)">No</button>
    </div>
</div>

<!--ChatBox code-->
<div id="chatIcon">
        <i class="fas fa-comments"></i>
    </div>

    <!-- Chatbot Modal -->
    <div class="chatbot-modal" id="chatbotModal">
        <div class="chatbot-header">
            <span>FAQ Chatbot</span>
            <button id="closeChatbot" style="background:none;border:none;color:white;font-size:16px;"><i class="fas fa-times"></i></button>
        </div>
        <div class="chatbot-body" id="chatBody">
            <b><p>Hello! How can I assist you today?</p></b>
            <center>
            <p>
                  1.What are your business hours?
            <br> 
            2.How can I contact customer service?
            <br> 
            3.What is your return policy?
            <br> 
            4.How do I track my order?
            <br> 
            5.Do you offer international shipping?
            <br> 
            6.How do I reset my password?
            <br> 
            Note: Answer numerically
            </p>
            </center>
        </div>
        <div class="chatbot-footer">
            <input type="text" id="userInput" placeholder="Ask a question..." />
            <button id="sendMessage"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <script>
        // Open and close chatbot modal
        var chatIcon = document.getElementById('chatIcon');
        var chatbotModal = document.getElementById('chatbotModal');
        var closeChatbot = document.getElementById('closeChatbot');

        chatIcon.addEventListener('click', function() {
            chatbotModal.style.display = 'block';
        });

        closeChatbot.addEventListener('click', function() {
            chatbotModal.style.display = 'none';
        });

        // Handle sending messages
        var sendMessageButton = document.getElementById('sendMessage');
        var userInput = document.getElementById('userInput');
        var chatBody = document.getElementById('chatBody');

        sendMessageButton.addEventListener('click', function() {
            var message = userInput.value;
            if (message.trim() !== "") {
                // Add user message to chat body
                var userMessage = document.createElement('p');
                userMessage.style.textAlign = 'right';
                userMessage.textContent = message;
                chatBody.appendChild(userMessage);

                // Clear input field
                userInput.value = '';

                // Send message to backend to get FAQ response
                fetch('faq_chatbot_backend.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    // Display the bot response
                    var botMessage = document.createElement('p');
                    botMessage.textContent = data.response;
                    chatBody.appendChild(botMessage);

                    // Scroll to the bottom
                    chatBody.scrollTop = chatBody.scrollHeight;
                })
                .catch(error => console.error('Error:', error));
            }
        });

        // Press "Enter" to send a message
        userInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                sendMessageButton.click();
            }
        });
    </script>

<section class="contact" id="contact">
    <h2 class="heading">Contact Us</h2>

    <form id="contactForm" action="save_message.php" method="POST">
        <div class="input-box">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-box">
            <input type="number" name="phone" placeholder="Phone Number" required>
            <input type="text" name="subject" placeholder="Subject" required>
        </div>
        <textarea name="message" cols="30" rows="10" placeholder="Your Message" required></textarea>
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
    <li>
        <a href="bot.php">Chat</a>
    </li>
    <li>
        <a href="order_history.php">history</a>
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
 
function showAdminPrompt() {
    document.getElementById("adminPrompt").style.display = "flex";
}

function handleAdminResponse(hasAccount) {
    // Hide the admin prompt modal
    document.getElementById("adminPrompt").style.display = "none";
    
    // If the user already has an admin account, redirect to login
    if (hasAccount) {
        window.location.href = "DiverseyInc1/index.php?role=admin";
    } else {
        // Otherwise, show the admin registration form
        document.getElementById("adminSignupModal").style.display = "flex";
    }
}

function closeAdminSignup() {
    // Close the registration form modal
    document.getElementById("adminSignupModal").style.display = "none";
}

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