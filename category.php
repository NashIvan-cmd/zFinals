<?php
include ('functions.php');
$type = urldecode($_GET['type']); // Get the product type from the URL
$gender = urldecode($_GET['gender']); // Get the gender from the URL

if(isset($_POST['delete'])){
    include('database_con.php');
    $id = $_POST['product_id']; // Retrieve the product_id from the POST data
    $query = "DELETE FROM products WHERE ID = ?";
    $stmt = mysqli_stmt_init($con);
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Item deleted successfully.";
            } else {
                echo "Item not deleted. No item found with the given ID.";
            }
        } else {
            echo "Error executing statement.";
        }
    } else {
        echo "Error preparing statement.";
    }
}
?>

<!DOCTYPE html>
<html>
    <title>Category</title>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div class="item-details">
    <?php 
    $products = getProductsByTypeAndGender($type, $gender);
    if(!empty($products)) {
        foreach($products as $product){
            ?>
            <div class = "item-grid">
                <div class="images">
                <a href="product.php?product_id=<?php echo $product['ID'];?>"><img src="<?php echo "Images/{$product['FILE']}"?>" class="control-images"></a>
                </div>
                <div class="item-details">
                    <p class="title">
                        <a href="product.php?product_id=<?php echo $product['ID']; ?>" target = "blank"><?php echo $product['ITEM_DESC']?></a>
                    </p>
                    <p class="price">$<?php echo $product['PRICE']?></p>
                    <p class="category"><?php echo $product['CATEGORY']?></p>
                    <p class="Ptype"><?php echo $product['Ptype']?></p>
                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['ID']; ?>">
                        <input type="submit" name="delete" value="Delete Item" onclick="return confirm('Are you sure you want to Delete <?php echo $product['ITEM_DESC']?> $<?php echo $product['PRICE']?> this item from your store?');">
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        echo "There is not Item for this category - ". $type;
    }
    ?>
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
    </body>
</html>