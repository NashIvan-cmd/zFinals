<?php 

include ('database_con.php');

if(!isset($_GET['product_id'])){
    echo '<html><body>';
    echo '<div id="countdown">Redirecting you to main page in <span id="time">5</span> seconds. Please access this with product id.</div>';
    echo '<script>
        var countdown = 5;
        var intervalId = setInterval(function() {
            countdown--;
            document.getElementById("time").textContent = countdown;
            if (countdown <= 0) {
                clearInterval(intervalId);
                location.href = "buyer.php";
            }
        }, 1000);
    </script>';
    echo '</body></html>';
    exit();
}

    session_start();
    if (!isset($_SESSION['username'])) {
        echo '<html><body>';
        echo '<div id="countdown">5</div>';
        echo '<div id="message">Please login with a valid account first.</div>';
        echo '<script>
            var countdownElement = document.getElementById("countdown");
            var messageElement = document.getElementById("message");
            var countdown = 5;
            var intervalId = setInterval(function() {
                countdown--;
                countdownElement.textContent = countdown;
                if (countdown <= 0) {
                    clearInterval(intervalId);
                    window.location.href = "no_account.php";
                }
            }, 1000);
        </script>';
        echo '</body></html>';
        exit;
    }

    if (isset($_POST['logout'])) {
        // Destroy the session
        session_destroy();
    
        // Redirect to login page
        header('Location: login.php');
        exit;
        }
    
    $ID = $_GET['product_id'];

    include_once ('functions.php');
    $specific_product = getProductbyId($ID);
    if(isset($_POST['add'])){
        //retrieve the ID 
        $ID = $_POST['product_id'];
        $USER_ID = $_SESSION['USER_ID'];
        
        $ORDER_ID = generateUniqueOrderId($con);
        $query ="INSERT INTO buyer_db (FILE, ITEM_DESC, PRICE, CATEGORY, GENDER, Ptype, USER_ID, ORDER_ID)
                SELECT FILE, ITEM_DESC, PRICE, CATEGORY, GENDER, Ptype, ?, ?
                FROM products
                WHERE ID = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'iii',$USER_ID, $ORDER_ID, $ID);
        mysqli_stmt_execute($stmt);
    
        // Handle success or error
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Product added to cart successfully!";
            $ID = $_POST['product_id'];
            // Decrement the STOCK by 1
            $query = "UPDATE products SET STOCK = STOCK - 1 WHERE ID = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'i', $ID);
            mysqli_stmt_execute($stmt);
    
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Stock updated successfully!";
            } else {
                echo "Error updating stock.";
            }
        } else {
            echo "Error adding product to cart.";
        }
    
        mysqli_stmt_close($stmt);
        mysqli_close($con);
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Shopping System</title>
    <style>
        .control-images{
    width: 300px;
    height: 200px;
    border-radius: 10px 10px 0px 0px;
    }

    .images{
        justify-items: center;
    }
    </style>
</head>
<body>

<div class = "header">
    <div style = "width: 900px;">
        <p style = "margin-left: 75px; font-size: 25px;margin-top: 30px;color: #465a27; font-weight: bold;font-family: Times;">Online Shopping System<p>
    </div>
    <div style = "width: 300px">
        <a href="cart.php"><button class = "menu-button">CART</button></a>
        <form method="post">
            <button name="logout" class="menu-button" onclick="return confirm('Are you sure you want to logout?');">LOGOUT</button>
        </form>
    </div>
    </div>
    <div class = "subheader">
    <div style = "padding-right: 600px; display: inline-block;">
        <p class = "subheading" style = "display: inline-block;">Welcome, <?php echo $_SESSION['username'];?>!</p>
    </div>  
    <!-- Trigger the modal with a button -->
    </div>
    <div style = "height: 1px; background-color: black;margin-left:230px;width:949.6px;margin-bottom:30px;"></div>

<div class="sidebar-category">
    <div class = "Home">
        <a href="buyer.php"><h3>Main</h3></a>
    </div>
        <a href=""></a>
        <h3 class = "sidebar-header">Apparels</h3>
    <div class="apparels">
            <div class="male">
                <h4 class = "sidebar-subheader">Male</h4>
                <a href="buyer_category.php"><p>Brief</p></a>
                <a href="buyer_category.php?type=Jackets&gender=male"><p>Jackets</p></a>
                <a href="buyer_category.php?type=Jeans&gender=male"><p>Jeans</p></a>
                <a href="buyer_category.php?type=T-Shirt&gender=male"><p>T-shirt</p></a>
            </div>
            <div class="female">
                <h4 class = "sidebar-subheader">Female</h4>
                <a href="buyer_category.php?type=Blouse&gender=female"><p>Blouse</p></a> 
                <a href="buyer_category.php?type=Dress&gender=female"><p>Dress</p></a> 
                <a href="buyer_category.php?type=<?php echo urlencode('Maxi Dresses'); ?>&gender=female"><p>Maxi Dresses</p></a> 
                <a href="buyer_category.php?type=Cardigans&gender=female"><p>Cardigans</p></a> 
            </div>
    </div>
    <h3 class = "sidebar-header">Accessories</h3>
    <div class="accessory">
            <div class="male">
                <h4 class = "sidebar-subheader">Male</h4>
                <a href="buyer_category.php?type=Belts&gender=male"><p>Belts</p></a>
                <a href="buyer_category.php?type=Sunglasses&gender=male"><p>Sunglasses</p></a>
                <a href="buyer_category.php?type=Watch&gender=male"><p>Watch</p></a>
            </div>
            <div class="female">
                <h4 class = "sidebar-subheader">Female</h4>
                <a href="buyer_category.php?type=Belts&gender=female"><p>Belts</p></a> 
                <a href="buyer_category.php?type=Necklace&gender=female"><p>Necklace</p></a>
                <a href="buyer_category.php?type=Sunglasses&gender=female"><p>Sunglasses</p></a>
            </div>
    </div>
    </div>

<div class="container">
    <div class="display-items">
        <!-- Call our functions here -->
        <?php

        if ($specific_product) { // Check if product exists
            ?>
            <div class="images">
                <img src="<?php echo "Images/{$specific_product['FILE']}"; ?>" class="control-images">
            </div>
            <div class="item-description">
                <p class="title">
                    <?php echo $specific_product['ITEM_DESC']; ?>
                </p>
            </div>
            <div class="item-price">
                <p class="Price">$<?php echo $specific_product['PRICE']; ?></p>
            </div>
            <div class="item-price">
                <p class="Stock">Stock: <?php echo $specific_product['STOCK']; ?></p>
            </div>
            <div class="item-category">
                <p class="category"><?php echo $specific_product['CATEGORY']; ?></p>
            </div>
            <div class="item-type">
                <p class="Ptype"><?php echo $specific_product['Ptype']; ?></p>
            </div>
            <div class="MORE_DESC">
                <p class="MORE_DESC"><?php echo $specific_product['MORE_DESC']; ?></p>
            </div>
            <?php
        } else {
            echo "Product not found."; // Handle case when product doesn't exist
        }
        ?>
    </div>
    <div class="add-to-cart">
        <form method="POST">
            <input type="hidden" name="product_id" value="<?php echo $specific_product['ID']; ?>">
            <input type="submit" name="add" value="Add to cart">
        </form>
    </div>
    <div class="display-addition-options">
        <?php
            include_once ('functions.php');
            $products = recommended($specific_product['CATEGORY']); 
        ?>
        <?php
                foreach($products as $product){
                    if($product['ID'] == $specific_product['ID']){
                        continue;
                    }
                    ?>
                    <div class = "item-grid">
                        <div class="images">
                            <img src="<?php echo "Images/{$product['FILE']}"?>" class="control-images">
                        </div>
                        <div class="item-details">
                            <p class="title">
                                <a href="buyer_product.php?product_id=<?php echo $product['ID']; ?>" target = "blank"><?php echo $product['ITEM_DESC']?></a>
                            </p>
                            <p class="price">$<?php echo $product['PRICE']?></p>
                            <p class="Stock">Stock: <?php echo $product['STOCK']?></p>   
                            <p class="category"><?php echo $product['CATEGORY']?></p> 
                            <p class="Ptype"><?php echo $product['Ptype']?></p> 
                        </div>
                    </div>  
                    <?php
                }
                ?>     
    </div>
</div>
</body>
</html>