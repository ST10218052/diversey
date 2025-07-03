<?php


session_start();


// Check if form is submitted to save address details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Save the entered address in session
    $_SESSION['address_details'] = [
        'name' => $_POST['name'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'address' => $_POST['address'] ?? '',
        'country' => $_POST['country'] ?? '',
        'city' => $_POST['city'] ?? ''
    ];
}

// Get saved address details if available
$addressDetails = $_SESSION['address_details'] ?? [];

if (empty($_SESSION['user_logged_in']) ) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit;
}else{
if (!empty($_SESSION['cart'])) {

    $grandTotal = 0;
    $grandQ = 0;
    // Loop through the cart items and print them
    foreach ($_SESSION['cart'] as $item) {
        $productName = htmlspecialchars($item['name']);
        $productPrice = number_format($item['price'], 2);
        $productQuantity = htmlspecialchars($item['quantity']);
        $totalPrice = number_format($item['price'] * $item['quantity'], 2);
      /*
        echo "<tr>";
        echo "<td>$productName</td>";
        echo "<td>$$productPrice</td>";
        echo "<td>$productQuantity</td>";
        echo "<td>$$totalPrice</td>";
        echo "</tr>";
       */
        $grandTotal += $item['price'] * $item['quantity'];
        $grandQ += $item['quantity'];
    }

    

    echo "</table>";
} else {
    echo "<h2>Your cart is empty!</h2>";
}
}
// Check if the cart session exists and is not empty


if(isset($_SESSION['user_logged_in'])){
    $email=$_SESSION['user_logged_in'];
    echo  $email;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="checkout.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- custom css file link  -->
    <style>
        .delete {
            color: red;
            text-decoration: none;
            font-size: 2rem;
        }

        .profile-picture img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            object-fit: cover;
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
   
    </div>
    <div class="user-wrapper">
                <?php if (isset($_SESSION['user_logged_in'])) { 
                    $email=$_SESSION['user_logged_in'];
                    ?>

                    
                    <div>
                        <h4>
                        <?php $email ?>
                        </h4>
                    </div>
                <?php } ?>
     </div>
</header>
    <br>
    <br>
    <br>
   <br>
   <br class=""><br class=""><br class=""><br class=""><br class="">
   <br>
<div class="container">
    <div class="checkoutLayout">

        
        <div class="returnCart">
            <a href="index.php">keep shopping</a>
            <h1>List Product in Cart</h1>
            <div class="list">
           <?php
            $mysql= require"DBConnect.php";
             $sql="SELECT * FROM diverseysa.products";
              $result=mysqli_query($mysql,$sql);
                  while($row=mysqli_fetch_array($result)){
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $key => $item) {
                            $id=htmlspecialchars($item['id']);
                            $productQuantity = htmlspecialchars($item['quantity']);
                            $totalPrice = number_format($item['price'] * $item['quantity'], 2);
                           
                            if($row['id'] == $id){ ?>
                <div class="item">
                <img src="_images/<?=$row['image']?>">
                    <div class="info">
                        <div class="name"><?=$row['name'];?></div>
                        <div class="price"><?=$row['price'];?>/<?=$productQuantity;?> product</div>
                    </div>
                    <div class="quantity"> <?php echo htmlspecialchars($item['quantity']); ?></div>
                    <div class="returnPrice"><?=$totalPrice; ?></div>
                </div>
                <div>
                <p><?php
                 if(isset($_SESSION['user_logged_in'])){
                    $email=$_SESSION['user_logged_in'];
                    echo  $email;
               }
                ?></p>
                </div>
               
                <?php

                     }
                    
                    }

                }
                }
            
                ?>

            </div>
        </div>


        <div class="right">
            <h1>Checkout</h1>

            <div class="form">
                <div class="group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($addressDetails['name'] ?? '') ?>">
                </div>
    
                <div class="group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($addressDetails['phone'] ?? '') ?>">
                </div>
    
                <div class="group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" value="<?= htmlspecialchars($addressDetails['address'] ?? '') ?>">
              
                </div>
    
                <div class="group">
                    <label for="country">Country</label>
                    <select name="country" id="country">
                        <option value="">Choose..</option>
                        <option value="South Africa" <?= isset($addressDetails['country']) && $addressDetails['country'] == 'South Africa' ? 'selected' : '' ?>>South Africa</option>
                        </select>
                </div>
    
                <div class="group">
                    <label for="city">City</label>
                    <select name="city" id="city">
                        <option value="">Choose..</option>
                        <option value="Cape Town"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Cape Town' ? 'selected' : '' ?>>Cape Town</option>
                        <option value="Johannesburg"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Johannesburg' ? 'selected' : '' ?>>Johannesburg</option>
                        <option value="Bloemfontein"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Bloemfontein' ? 'selected' : '' ?>>Bloemfontein</option>
                        <option value="Durban"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Durban' ? 'selected' : '' ?>>Durban</option>
                        <option value="Pretoria"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Pretoria' ? 'selected' : '' ?>>Pretoria</option>
                        <option value="Gqeberha"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Gqeberha' ? 'selected' : '' ?>>Gqeberha</option>
                        <option value="East London"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'East London' ? 'selected' : '' ?>>East London</option>
                        <option value="Pietermaritzburg"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Pietermaritzburg' ? 'selected' : '' ?>>Pietermaritzburg</option>
                        <option value="Kimberley"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Kimberley' ? 'selected' : '' ?>>Kimberley</option>
                        <option value="Makhanda"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Makhanda' ? 'selected' : '' ?>>Makhanda</option>
                        <option value="Oudtshoorn"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Oudtshoorn' ? 'selected' : '' ?>>Oudtshoorn</option>
                        <option value="Thohoyandaou"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Thohoyandaou' ? 'selected' : '' ?>>Thohoyandaou</option>
                        <option value="Newcastle"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Newcastle' ? 'selected' : '' ?>>Newcastle</option>
                        <option value="Rustenburg"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Rustenburg' ? 'selected' : '' ?>>Rustenburg</option>
                        <option value="George"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'George' ? 'selected' : '' ?>>George</option>
                        <option value="Polokwane"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Polokwane' ? 'selected' : '' ?>>Polokwane</option>
                        <option value="Mbombela"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Mbombela' ? 'selected' : '' ?>>Mbombela</option>
                        <option value="Upington"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Upington' ? 'selected' : '' ?>>Upington</option>
                        <option value="Klerksdrop"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Klerksdrop' ? 'selected' : '' ?>>Klerksdrop</option>
                        <option value="Komani"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Komani' ? 'selected' : '' ?>>Komani</option>
                        <option value="Vryheid"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Vryheid' ? 'selected' : '' ?>>Vryheid</option>
                        <option value="Maokeng"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Maokeng' ? 'selected' : '' ?>>Maokeng</option>
                        <option value="Volkstrust"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Volkstrust' ? 'selected' : '' ?>>Volkstrust</option>
                        <option value="Mthatha"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Mthatha' ? 'selected' : '' ?>>Mthatha</option>
                        <option value="Potchefstroom"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Potchefstroom' ? 'selected' : '' ?>>Potchefstroom</option>
                        <option value="KwaDukuza"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'KwaDukuza' ? 'selected' : '' ?>>KwaDukuza</option>
                        <option value="Sasolburg"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Sasolburg' ? 'selected' : '' ?>>Sasolburg</option>
                        <option value="Ermelo"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Ermelo' ? 'selected' : '' ?>>Ermelo</option>
                        <option value="Krugersdrop"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Krugersdrop' ? 'selected' : '' ?>>Krugersdrop</option>
                        <option value="Mashishing"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Mashishing' ? 'selected' : '' ?>>Mashishing</option>
                        <option value="Greytown"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Greytown' ? 'selected' : '' ?>>Greytown</option>
                        <option value="Witbank"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Witbank' ? 'selected' : '' ?>>Witbank</option>
                        <option value="Bothaville"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Bothaville' ? 'selected' : '' ?>>Bothaville</option>
                        <option value="Ulundi"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Ulundi' ? 'selected' : '' ?>>Ulundi</option>
                        <option value="Kokstad"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Kokstad' ? 'selected' : '' ?>>Kokstad</option>
                        <option value="Alice"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Alice' ? 'selected' : '' ?>>Alice</option>
                        <option value="Mooi River"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Mooi River' ? 'selected' : '' ?>>Mooi River</option>
                        <option value="Giyani"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Giyani' ? 'selected' : '' ?>>Giyani</option>
                        <option value="Nqweba"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Nqweba' ? 'selected' : '' ?>>Nqweba</option>
                        <option value="Frankfort"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Frankfort' ? 'selected' : '' ?>>Frankfort</option>
                        <option value="Stellenbosch"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Stellenbosch' ? 'selected' : '' ?>>Stellenbosch</option>
                        <option value="Vereeniging"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Vereeniging' ? 'selected' : '' ?>>Vereeniging</option>
                        <option value="Malalane"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Malalane' ? 'selected' : '' ?>>Malalane</option>
                        <option value="Matatiele"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Matatiele' ? 'selected' : '' ?>>Matatiele</option>
                        <option value="Flagstaff"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Flagstaff' ? 'selected' : '' ?>>Flagstaff</option>
                        <option value="Soweto"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Soweto' ? 'selected' : '' ?>>Soweto</option>
                        <option value="Parys"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Parys' ? 'selected' : '' ?>>Parys</option>
                        <option value="Worcester"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Worcester' ? 'selected' : '' ?>>Worcester</option>
                        <option value="Mossel Bay"<?= isset($addressDetails['city']) && $addressDetails['city'] == 'Mossel Bay' ? 'selected' : '' ?>>Mossel Bay</option>
                    </select>
                </div>
            </div>
            <div class="return">
                <div class="row">
                    <div>Total Quantity</div>
                    <div class="totalQuantity"><?=$grandQ?></div>
                </div>
                <div class="row">
                    <div>Total Price</div>
                    <div class="totalPrice"><?= number_format($grandTotal, 2)  ;?></div>
                </div>
            </div>

            
            <form action="payment.php" method="POST">
            <button type="submit"  class="buttonCheckout" id="buttonCheckout" >Checkout</button>
    </form>

    <div id="paypal-button-container"></div>
        <p id="result-message"></p>
            

        
        <!-- Initialize the JS-SDK -->
        <script
            src="https://www.paypal.com/sdk/js?client-id=AXMm35jX5hAbt64HuYy5MlRWAUEccTNmp6ovdKOyeYwWx_UMsIbHg1evC_-tZEnjl-7SoUia2YwQz_6c&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo"
            data-sdk-integration-source="developer-studio"
        ></script>
    
        <script>
            import express from "express";
import fetch from "node-fetch";
import "dotenv/config";
import path from "path";

const { PAYPAL_CLIENT_ID, PAYPAL_CLIENT_SECRET, PORT = 8888 } = process.env;
const base = "https://api-m.sandbox.paypal.com";
const app = express();

// host static files
app.use(express.static("client"));

// parse post params sent in body in json format
app.use(express.json());

export default async function generateAccessToken() {
    // To base64 encode your client id and secret using NodeJs
    const BASE64_ENCODED_CLIENT_ID_AND_SECRET = Buffer.from(
        `${PAYPAL_CLIENT_ID}:${PAYPAL_CLIENT_SECRET}`
    ).toString("base64");

    const request = await fetch(
        "https://api-m.sandbox.paypal.com/v1/oauth2/token",
        {
            method: "POST",
            headers: {
                Authorization: `Basic ${BASE64_ENCODED_CLIENT_ID_AND_SECRET}`,
            },
            body: new URLSearchParams({
                grant_type: "client_credentials",
                response_type: "id_token",
                intent: "sdk_init",
            }),
        }
    );
    const json = await request.json();
    return json.access_token;
} 
async function handleResponse(response) {
    try {
        const jsonResponse = await response.json();
        return {
            jsonResponse,
            httpStatusCode: response.status,
        };
    } catch (err) {
        const errorMessage = await response.text();
        throw new Error(errorMessage);
    }
}

/**
 * Create an order to start the transaction.
 * @see https://developer.paypal.com/docs/api/orders/v2/#orders_create
 */
const createOrder = async (cart) => {
    // use the cart information passed from the front-end to calculate the purchase unit details
    console.log(
        "shopping cart information passed from the frontend createOrder() callback:",
        cart
    );

    const accessToken = await generateAccessToken();
    const url = `${base}/v2/checkout/orders`;

    const payload = {
        intent: "CAPTURE",
        purchase_units: [
            {
                amount: {
                    currency_code: "USD",
                    value: "100",
                },
            },
        ],
    };
    

    const response = await fetch(url, {
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${accessToken}`,
            // Uncomment one of these to force an error for negative testing (in sandbox mode only).
            // Documentation: https://developer.paypal.com/tools/sandbox/negative-testing/request-headers/
            // "PayPal-Mock-Response": '{"mock_application_codes": "MISSING_REQUIRED_PARAMETER"}'
            // "PayPal-Mock-Response": '{"mock_application_codes": "PERMISSION_DENIED"}'
            // "PayPal-Mock-Response": '{"mock_application_codes": "INTERNAL_SERVER_ERROR"}'
        },
        method: "POST",
        body: JSON.stringify(payload),
    });

    return handleResponse(response);
};

// createOrder route
app.post("/api/orders", async (req, res) => {
    try {
        // use the cart information passed from the front-end to calculate the order amount detals
        const { cart } = req.body;
        const { jsonResponse, httpStatusCode } = await createOrder(cart);
        res.status(httpStatusCode).json(jsonResponse);
    } catch (error) {
        console.error("Failed to create order:", error);
        res.status(500).json({ error: "Failed to create order." });
    }
});



/**
 * Capture payment for the created order to complete the transaction.
 * @see https://developer.paypal.com/docs/api/orders/v2/#orders_capture
 */
const captureOrder = async (orderID) => {
    const accessToken = await generateAccessToken();
    const url = `${base}/v2/checkout/orders/${orderID}/capture`;

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${accessToken}`,
            // Uncomment one of these to force an error for negative testing (in sandbox mode only).
            // Documentation:
            // https://developer.paypal.com/tools/sandbox/negative-testing/request-headers/
            // "PayPal-Mock-Response": '{"mock_application_codes": "INSTRUMENT_DECLINED"}'
            // "PayPal-Mock-Response": '{"mock_application_codes": "TRANSACTION_REFUSED"}'
            // "PayPal-Mock-Response": '{"mock_application_codes": "INTERNAL_SERVER_ERROR"}'
        },
    });

    return handleResponse(response);
};

// captureOrder route
app.post("/api/orders/:orderID/capture", async (req, res) => {
    try {
        const { orderID } = req.params;
        const { jsonResponse, httpStatusCode } = await captureOrder(orderID);
        res.status(httpStatusCode).json(jsonResponse);
    } catch (error) {
        console.error("Failed to create order:", error);
        res.status(500).json({ error: "Failed to capture order." });
    }
}); 

// serve index.html
app.get("/", (req, res) => {
    res.sendFile(path.resolve("./checkout."));
});

app.listen(PORT, () => {
    console.log(`Node server listening at http://localhost:${PORT}/`);
}); 
        </script>
        </div>

    </div>
</div>

<script>
    const paymentButton = document.getElementById('buttonCheckout');

paymentButton.addEventListener('click', function() {
    // Perform payment process here
    // Once payment is done, call the function to update login status
    updateLoginStatus();
    alert
});

exit;
</script>


</body>
</html>