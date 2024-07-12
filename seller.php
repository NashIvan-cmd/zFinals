<?php 
    session_start();
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $file_name = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
        $tempname = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';

        $uploadDirectory = 'Images/';
        //check if Images folder not exist
        if(!is_dir($uploadDirectory)){
            //create the folder 0 7 = write read execute 5 = read + execute
            mkdir($uploadDirectory, 0755, true);
        }
        $folder = $uploadDirectory . $file_name;
        //source to destination
        move_uploaded_file($tempname, $folder);

        $description = isset($_POST['description'])? strip_tags($_POST['description']) : '';
        $price = isset($_POST['price'])? strip_tags($_POST['price']) : '';
        $category = isset($_POST['category'])? $_POST['category'] : '';
        $gender = isset($_POST['Gender'])? $_POST['Gender'] : '';
        $type = isset($_POST['type'])? $_POST['type'] : '';
        $more_desc = isset($_POST['Text-area'])? strip_tags($_POST['Text-area']) : '';
        $stock = isset($_POST['Stock'])? strip_tags($_POST['Stock']) : '';

        $error = [];

        if(empty($description)){
            $error['description'] = "Required Field";
        }

        if(empty($price)){
            $error['price'] = "Required Field";
        }else if(!preg_match('/^[1-9][0-9]*$/', $price)){
            $error['price'] = "No leading 0 and Only Numbers";
        }

        if(empty($stock)){
            $error['Stock'] = "Required Field";
        }else if(!preg_match('/^[1-9][0-9]*$/', $stock)){
            $error['Stock'] = "No leading 0 and Only Numbers";
        }

        include('database_con.php');

        if(empty($error)){
            $_POST['description'] = $description;
            $_POST['price'] = $price;
            $_POST['Stock'] = $stock;


            $query = "INSERT INTO products(FILE, ITEM_DESC, PRICE, CATEGORY, GENDER, Ptype, MORE_DESC, STOCK)
                    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($con);
            mysqli_stmt_prepare($stmt, $query);
            mysqli_stmt_bind_param($stmt, 'ssssssss', $file_name, $description, $price, $category, $gender, $type, $more_desc, $stock);
            mysqli_stmt_execute($stmt);
            header('Location: seller.php');
        }
        
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
            
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Online Shopping System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="seller-styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class = "header">
    <div style = "width: 900px;">
        <p style = "margin-left: 75px; font-size: 25px;margin-top: 30px;color: #465a27; font-weight: bold;font-family: Times;">Online Shopping System<p>
    </div>
    <div style = "width: 300px">
        <button class = "shop-button">SHOP</button>
    </div>
</div>
<div class = "subheader">
    <div style = "padding-right: 600px; display: inline-block;">
        <p class = "subheading" style = "display: inline-block;">Seller</p>
    </div>
    <!-- Trigger the modal with a button -->
    <div style = "position: sticky; padding-right: 100px;">
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style = "display: inline-block; margin-bottom:30px; margin-top:70px">Add Item</button>
    </div>
</div>
<div style = "height: 1px; background-color: black;margin-left:230px;width:949.6px;margin-bottom:30px;"></div>
<div class="display-items"> 
        <?php  include ('functions.php');
         $products = getProducts(18);
         ?>
        <!-- call our functions here -->
        <?php
    if(is_array($products)) {
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
                    <?php
                    if($product['STOCK'] == 0) {
                        echo '<p class="stock" style="color: red; font-weight="bold;">Stock: ' . $product['STOCK'] . '</p>';
                    } else {
                        echo '<p class="stock">Stock: ' . $product['STOCK'] . '</p>';
                    }
                    ?>
                    <p class="category"><?php echo $product['CATEGORY']?></p>
                    <p class="Ptype"><?php echo $product['Ptype']?></p>
                    <a href="update.php?ID=<?php echo $product['ID'];?>">Update Item</a>
                    <form method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['ID']; ?>">
                    <input type="submit" name="delete" value="Delete Item" onclick="return confirm('Are you sure you want to Delete <?php echo $product['ITEM_DESC']?> $<?php echo $product['PRICE']?> this item from your store?');">
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        echo $products; // This will display the message "Your shop is ready, please add items"
    }
?>

</div>
<div class="sidebar">
    <div class="apparels">
        <h4>Apparels</h4>
        <div class="male">
            <h4>Male</h4>
            <a href="category.php?type=Brief&gender=male"><p>Brief</p></a>
            <a href="category.php?type=Jackets&gender=male"><p>Jackets</p></a>
            <a href="category.php?type=Jeans&gender=male"><p>Jeans</p></a>
            <a href="category.php?type=T-Shirt&gender=male"><p>T-shirt</p></a>
        </div>
        <div class="female">
            <h4>Female</h4>
            <a href="category.php?type=Blouse&gender=female"><p>Blouse</p></a> 
            <a href="category.php?type=Dress&gender=female"><p>Dress</p></a> 
            <a href="category.php?type=<?php echo urlencode('Maxi Dresses'); ?>&gender=female"><p>Maxi Dresses</p></a> 
            <a href="category.php?type=Cardigans&gender=female"><p>Cardigans</p></a> 
        </div>
    </div>
    <div class="accessory">
    <h4>Accessories</h4>
        <div class="male">
            <h4>Male</h4>
            <a href="category.php?type=Belts&gender=male"><p>Belts</p></a>
            <a href="category.php?type=Sunglasses&gender=male"><p>Sunglasses</p></a>
            <a href="category.php?type=Watch&gender=male"><p>Watch</p></a>
        </div>
        <div class="female">
            <h4>Female</h4>
            <a href="category.php?type=Belts&gender=female"><p>Belts</p></a> 
            <a href="category.php?type=Necklace&gender=female"><p>Necklace</p></a>
            <a href="category.php?type=Sunglasses&gender=female"><p>Sunglasses</p></a>
        </div>
    </div>
</div>
  

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Item</h4>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="upload-picture">
                <input type="file" name="image">
            </div>
        <div class="modal-body">
                <div class="item-description">
                    <label for="description">Product Description: </label>
                    <input type="text" name="description" placeholder="Product description">
                    <?php if (isset($error['description'])): ?>
                    <span class="error"><?php echo $error['description']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="item-price">
                    <label for="Price">Price: </label>
                    <input type="text" name="price" placeholder="Price">
                    <?php if (isset($error['price'])): ?>
                    <span class="error"><?php echo $error['price']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="Stock">
                    <label for="Stock">Stock: </label>
                    <input type="text" name="Stock" placeholder="Qty. of item you have.">
                    <?php if (isset($error['Stock'])): ?>
                    <span class="error"><?php echo $error['Stock']; ?></span>
                    <?php endif; ?>
                </div>
                    <div class="drop-down">
                        <label for="category">Category:</label>
                            <select name="category" id="category">
                                <option value="Apparels">Apparels</option>
                                <option value="Accessory">Accessory</option>
                            </select>
                        <label for="Gender">Gender:</label>
                            <select name="Gender" id="Gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        <label for="type">Type:</label>
                            <select name="type" id="type">
                                <!-- Initially empty; options will be added dynamically -->
                            </select>
                    </div>
                    <div class="textarea">
                    <p><label for="w3review">More Item-Description:</label></p>
                    <textarea id="w3review" name="Text-area" rows="4" cols="50">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</textarea>
                    </div>
        </div>
                    <div class="submit-button">
                            <input type="submit" value="Add Item">
                    </div>
          </form>
        </div>
        <div class="modal-footer">
          
        </div>
      </div>  
    </div>
</div>
    <script>
            const categoryDropdown = document.getElementById('category');
            const typeDropdown = document.getElementById('type');
            const genderDropdown = document.getElementById('Gender');

            // Define clothing types for each category and gender
            const Categories = {
                Apparels: {
                    male: ['Brief', 'Jackets', 'Jeans', 'T-shirt'],
                    female: ['Blouse', 'Dress', 'Maxi Dresses', 'Cardigans']
                },
                Accessory: {
                    male: ['Belts', 'Sunglasses', 'Watch'],
                    female: ['Belts', 'Necklace', 'Sunglasses']
                },
            };

            // Function to update type options based on selected category and gender
            function updateTypeOptions() {
                const selectedCategory = categoryDropdown.value;
                const selectedGender = genderDropdown.value;
                typeDropdown.innerHTML = ''; // Clear existing options

                // Add options based on selected category and gender
                if (selectedCategory === 'Watch') {
                    Categories.Watch[selectedGender].forEach(type => {
                        const option = document.createElement('option');
                        option.value = type;
                        option.textContent = type;
                        typeDropdown.appendChild(option);
                    });
                } else {
                    Categories[selectedCategory][selectedGender].forEach(type => {
                        const option = document.createElement('option');
                        option.value = type;
                        option.textContent = type;
                        typeDropdown.appendChild(option);
                    });
                }
            }

            // Initial update based on default selections
            updateTypeOptions();

            // Listen for changes in category and gender selections using jQuery
            $(document).ready(function() {
                $('#category, #Gender').on('change', updateTypeOptions);
            });

        </script>

</body>
</html>
