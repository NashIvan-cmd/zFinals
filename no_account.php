<<<<<<< HEAD
<?php 
    if (isset($_POST["add"])){
        header('Location: register.php');
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Online Shopping System</title>
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div class = "header">
    <div style = "width: 900px;">
        <p style = "margin-left: 75px; font-size: 25px;margin-top: 30px;color: #465a27; font-weight: bold;font-family: Times;">Online Shopping System<p>
    </div>
    <div style = "width: 300px">
        <a href=""><button class = "shop-button">CART</button></a>
        <a href="register.php"><button name="sign-up" class="shop-button">SIGN UP</button></a>
       
    </div>
</div>
<div class = "subheader">
    <div style = "padding-right: 600px; display: inline-block;">
        <p class = "subheading" style = "display: inline-block;">Buyer / No Account</p>
    </div>
    <!-- Trigger the modal with a button -->
</div>
<div style = "height: 1px; background-color: black;margin-left:230px;width:949.6px;margin-bottom:30px;"></div>
<div class="display-items"> 
        <?php  include ('functions.php');
         $products = getProductsIF(20)
         ?>
        <!-- call our functions here -->
         <?php
            foreach($products as $product){
                ?>
                <div class = "item-grid">
                    <div class="images">
                        <img src="<?php echo "Images/{$product['FILE']}"?>" class="control-images">
                    </div>
                    <div class="item-details">
                        <p class="title">
                            <?php echo $product['ITEM_DESC']?>
                        </p>
                        <p class="price">$<?php echo $product['PRICE']?></p>
                        <p class="category">Category: <?php echo $product['CATEGORY']?></p>
                        <p class="gender">For: <?php echo $product['GENDER']?></p>
                        <p class="Ptype">Product type: <?php echo $product['Ptype']?></p>
                        <div class="add-to-cart">
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['ID']; ?>">
                            <input type="submit" name="add" value="Add to cart" onclick="return confirm('Please create account or login first to unlock more features');">
                        </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
</div>
    </body>
=======
<?php 
    if (isset($_POST["add"])){
        header('Location: register.php');
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Online Shopping System</title>
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div class = "header">
    <div style = "width: 900px;">
        <p style = "margin-left: 75px; font-size: 25px;margin-top: 30px;color: #465a27; font-weight: bold;font-family: Times;">Online Shopping System<p>
    </div>
    <div style = "width: 300px">
        <a href=""><button class = "shop-button">CART</button></a>
        <a href="register.php"><button name="sign-up" class="shop-button">SIGN UP</button></a>
       
    </div>
</div>
<div class = "subheader">
    <div style = "padding-right: 600px; display: inline-block;">
        <p class = "subheading" style = "display: inline-block;">Buyer / No Account</p>
    </div>
    <!-- Trigger the modal with a button -->
</div>
<div style = "height: 1px; background-color: black;margin-left:230px;width:949.6px;margin-bottom:30px;"></div>
<div class="display-items"> 
        <?php  include ('functions.php');
         $products = getProductsIF(20)
         ?>
        <!-- call our functions here -->
         <?php
            foreach($products as $product){
                ?>
                <div class = "item-grid">
                    <div class="images">
                        <img src="<?php echo "Images/{$product['FILE']}"?>" class="control-images">
                    </div>
                    <div class="item-details">
                        <p class="title">
                            <?php echo $product['ITEM_DESC']?>
                        </p>
                        <p class="price">$<?php echo $product['PRICE']?></p>
                        <p class="category">Category: <?php echo $product['CATEGORY']?></p>
                        <p class="gender">For: <?php echo $product['GENDER']?></p>
                        <p class="Ptype">Product type: <?php echo $product['Ptype']?></p>
                        <div class="add-to-cart">
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['ID']; ?>">
                            <input type="submit" name="add" value="Add to cart" onclick="return confirm('Please create account or login first to unlock more features');">
                        </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
</div>
    </body>
>>>>>>> origin/main
</html>