<<<<<<< HEAD
<?php 
include('functions.php');

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
                location.href = "seller.php";
            }
        }, 1000);
    </script>';
    echo '</body></html>';
    exit();
}
    $ID = $_GET['product_id'];

    if(isset($_POST['delete'])){
        deleteItembyId($ID);
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
<h2>Online Shopping System</h2>
<div class="container">
    <div class="display-items">
        <!-- Call our functions here -->
        <?php
        $specific_product = getProductbyId($ID);

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
            <p class="price">$<?php echo $specific_product['PRICE'];?></p>
            <div class="item-category">
                <p class="category"><?php echo $specific_product['CATEGORY']; ?></p>
            </div>
            <div class="item-type">
                <p class="Ptype"><?php echo $specific_product['Ptype']; ?></p>
            </div>
            <div class="item-gender">
                <p class="gender"><?php echo $specific_product['GENDER']; ?></p>
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
    <div class="delete-button">
        <form method="POST">
            <input type="submit" name="delete" value="Delete Item">
        </form>
    </div>

    <div class="categories">
    <div class = "Home">
        <a href="seller.php"><h3>Main</h3></a>
    </div>
        <a href=""></a>
    <div class="apparels">
        <h4>Apparels</h4>
        <div class="male">
            <h5>Male</h5>
            <a href="category.php?type=Brief&gender=male"><p>Brief</p></a>
            <a href="category.php?type=Jackets&gender=male"><p>Jackets</p></a>
            <a href="category.php?type=Jeans&gender=male"><p>Jeans</p></a>
            <a href="category.php?type=T-Shirt&gender=male"><p>T-shirt</p></a>
        </div>
        <div class="female">
            <h5>Female</h5>
            <a href="category.php?type=Blouse&gender=female"><p>Blouse</p></a> 
            <a href="category.php?type=Dress&gender=female"><p>Dress</p></a> 
            <a href="category.php?type=<?php echo urlencode('Maxi Dresses'); ?>&gender=female"><p>Maxi Dresses</p></a> 
            <a href="category.php?type=Cardigans&gender=female"><p>Cardigans</p></a> 
        </div>
    </div>
    <div class="accessory">
    <h4>Accessories</h4>
        <div class="male">
            <h5>Male</h5>
            <a href="category.php?type=Belts&gender=male"><p>Belts</p></a>
            <a href="category.php?type=Sunglasses&gender=male"><p>Sunglasses</p></a>
            <a href="category.php?type=Watch&gender=male"><p>Watch</p></a>
        </div>
        <div class="female">
            <h5>Female</h5>
            <a href="category.php?type=Belts&gender=female"><p>Belts</p></a> 
            <a href="category.php?type=Necklace&gender=female"><p>Necklace</p></a>
            <a href="category.php?type=Sunglasses&gender=female"><p>Sunglasses</p></a>
        </div>
    </div>
    </div>

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
                        <a href="product.php?product_id=<?php echo $product['ID']; ?>" target = "blank"><img src="<?php echo "Images/{$product['FILE']}"?>" class="control-images"></a>
                        </div>
                        <div class="item-details">
                            <p class="title">
                                <a href="product.php?product_id=<?php echo $product['ID']; ?>" target = "blank"><?php echo $product['ITEM_DESC']?></a>
                            </p>
                            <p class="price">$<?php echo $product['PRICE']?></p>
                            <p class="category"><?php echo $product['CATEGORY']?></p> 
                            <p class="Ptype"><?php echo $product['Ptype']?></p> 
                        </div>
                    </div>  
                    <?php
                }
                ?>
            
    </div>
</body>
=======
<?php 
include('functions.php');

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
                location.href = "seller.php";
            }
        }, 1000);
    </script>';
    echo '</body></html>';
    exit();
}
    $ID = $_GET['product_id'];

    if(isset($_POST['delete'])){
        deleteItembyId($ID);
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
<h2>Online Shopping System</h2>
<div class="container">
    <div class="display-items">
        <!-- Call our functions here -->
        <?php
        $specific_product = getProductbyId($ID);

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
            <p class="price">$<?php echo $specific_product['PRICE'];?></p>
            <div class="item-category">
                <p class="category"><?php echo $specific_product['CATEGORY']; ?></p>
            </div>
            <div class="item-type">
                <p class="Ptype"><?php echo $specific_product['Ptype']; ?></p>
            </div>
            <div class="item-gender">
                <p class="gender"><?php echo $specific_product['GENDER']; ?></p>
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
    <div class="delete-button">
        <form method="POST">
            <input type="submit" name="delete" value="Delete Item">
        </form>
    </div>

    <div class="categories">
    <div class = "Home">
        <a href="seller.php"><h3>Main</h3></a>
    </div>
        <a href=""></a>
    <div class="apparels">
        <h4>Apparels</h4>
        <div class="male">
            <h5>Male</h5>
            <a href="category.php?type=Brief&gender=male"><p>Brief</p></a>
            <a href="category.php?type=Jackets&gender=male"><p>Jackets</p></a>
            <a href="category.php?type=Jeans&gender=male"><p>Jeans</p></a>
            <a href="category.php?type=T-Shirt&gender=male"><p>T-shirt</p></a>
        </div>
        <div class="female">
            <h5>Female</h5>
            <a href="category.php?type=Blouse&gender=female"><p>Blouse</p></a> 
            <a href="category.php?type=Dress&gender=female"><p>Dress</p></a> 
            <a href="category.php?type=<?php echo urlencode('Maxi Dresses'); ?>&gender=female"><p>Maxi Dresses</p></a> 
            <a href="category.php?type=Cardigans&gender=female"><p>Cardigans</p></a> 
        </div>
    </div>
    <div class="accessory">
    <h4>Accessories</h4>
        <div class="male">
            <h5>Male</h5>
            <a href="category.php?type=Belts&gender=male"><p>Belts</p></a>
            <a href="category.php?type=Sunglasses&gender=male"><p>Sunglasses</p></a>
            <a href="category.php?type=Watch&gender=male"><p>Watch</p></a>
        </div>
        <div class="female">
            <h5>Female</h5>
            <a href="category.php?type=Belts&gender=female"><p>Belts</p></a> 
            <a href="category.php?type=Necklace&gender=female"><p>Necklace</p></a>
            <a href="category.php?type=Sunglasses&gender=female"><p>Sunglasses</p></a>
        </div>
    </div>
    </div>

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
                        <a href="product.php?product_id=<?php echo $product['ID']; ?>" target = "blank"><img src="<?php echo "Images/{$product['FILE']}"?>" class="control-images"></a>
                        </div>
                        <div class="item-details">
                            <p class="title">
                                <a href="product.php?product_id=<?php echo $product['ID']; ?>" target = "blank"><?php echo $product['ITEM_DESC']?></a>
                            </p>
                            <p class="price">$<?php echo $product['PRICE']?></p>
                            <p class="category"><?php echo $product['CATEGORY']?></p> 
                            <p class="Ptype"><?php echo $product['Ptype']?></p> 
                        </div>
                    </div>  
                    <?php
                }
                ?>
            
    </div>
</body>
>>>>>>> origin/main
</html>