<?php
session_start();
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $target_dir = "Pictures";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $query = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$image_filename')";
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $query = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$target_file')";

            if (mysqli_query($conn, $query)) {
                header("Location: products.php");
                exit();
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $query = "DELETE FROM products WHERE id = '$product_id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: products.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

$recent_picture_query = "SELECT profile_picture FROM admin WHERE email = '{$_SESSION['email']}'";
$recent_picture_result = mysqli_query($conn, $recent_picture_query);
$recent_picture_row = mysqli_fetch_assoc($recent_picture_result);
$profile_picture = $recent_picture_row['profile_picture'];


$product_query = "SELECT * FROM products";
$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Products | Diversey Inc</title>
    <style>
        .remove-button {
            background: none;
            border: none;
            padding: 0;
            margin-left: .5rem;
            cursor: pointer;
            color: red;
            font-size: 2rem;
            outline: none;
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

<input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <!--<div class="side-logo">
            <img src="footer logo.png" alt="Diversey logo" width="345px" height="85px">
        </div>-->

        <div class="sideMenu">
            <ul>
                <li>
                    <a href="homepage.php"><span class="las la-igloo"></span>
                    <span>Dashboard</span></a>
                </li>
    
                <li>
                    <a href="customer.php"><span class="las la-users"></span>
                    <span>Customers</span></a>
                </li>
    
                <li>
                    <a href="products.php" class="active"><span class="las la-list"></span>
                    <span>Products</span></a>
                </li>
    
                <li>
                    <a href="order.php"><span class="las la-shopping-bag"></span>
                    <span>Orders</span></a>
                </li>
    
                <li>
                    <a href="messages.php"><span class="las la-envelope"></span>
                    <span>Messages</span></a>
                </li>
    
                <li>
                    <a href="admin.php"><span class="las la-user-circle"></span>
                    <span>Account</span></a>
                 </li>
                 
            </ul>
            <a href="logout.php"><span class="las la-sign-out-alt"></span>Logout</a>
        </div>
    </div>

    <div class="logo-2nd">
        <img src="_images/images.png" alt="second Company logo">
    </div>

    <div class="content">
        <header>
            <div class="logo">
                <img src="_images/header logo.jpeg" alt="Diversey logo" width="345px" height="78px">
            </div>

            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>

                Products
            </h2>

            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search here" />
            </div>
            
            <div class="user-wrapper">
            <?php if (isset($profile_picture)) { ?>
                    <div class="profile-picture">
                        <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture">
                    </div>
                <?php } ?>
                <div>
                    <h4><?php 
                            if(isset($_SESSION['email'])){
                             $email=$_SESSION['email'];
                             $query=mysqli_query($conn, "SELECT admin.* FROM admin WHERE admin.email='$email'");
                            while($row=mysqli_fetch_array($query)){
                            echo $row['admin_name'];
                            }
                        }
                    ?></h4>
                    <small>Company Admin</small>
                </div>
            </div>
        </header>
    </div>

    <main>
        <div class="product-box">
            <div class="card-header">
                <h3>Products List</h3>
                <button id="addProductBtn"><span class="las la-plus"></span>Add</button>
            </div>

            <div class="product-container">
                <?php while($product = mysqli_fetch_assoc($product_result)): ?>
                <div class="product-box">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <h4><?php echo $product['name']; ?></h4>
                    <p><?php echo $product['description']; ?></p>
                    <p class="price">R<?php echo $product['price']; ?></p>

                    <div class="more-options">
                        <span class="more">•••</span>
                        <div class="menu">
                        <div class="edit">
                                <span class="las la-edit"></span>
                            </div>

                            <form method="POST" action="products.php" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="remove" class="remove-button">
                            <span class="las la-trash"></span>
                        </button>
                    </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editID">
                    <div>
                        <label for="editName">Product Name</label>
                        <input type="text" id="editName">
                    </div>
                    <div>
                        <label for="editDescription">Description</label>
                        <input type="text" id="editDescription">
                    </div>
                    <div>
                        <label for="editPrice">Price</label>
                        <input type="text" id="editPrice">
                    </div>
                    <div>
                        <label for="editImage">Product Image</label>
                        <input type="text" id="editImage">
                    </div>
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>

        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="addForm" method="POST" action="products.php" enctype="multipart/form-data">
                    <div>
                        <label for="addName">Product Name</label>
                        <input type="text" id="addName" name="name" required>
                    </div>
                    <div>
                        <label for="addDescription">Description</label>
                        <input type="text" id="addDescription" name="description" required>
                    </div>
                    <div>
                        <label for="addPrice">Price</label>
                        <input type="text" id="addPrice" name="price" required>
                    </div>
                    <div>
                        <label for="addImage">Product Image</label>
                        <input type="file" id="addImage" name="image" required>
                    </div>
                    <button type="submit" name="add_product">Add</button>
                </form>
            </div>
        </div>
    </main>

    <script src="scripts.js"></script>
</body>
</html>