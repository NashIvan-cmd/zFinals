<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<html> <body>';
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

    if ($_SERVER['REQUEST_METHOD'] == "POST"){

        $contact = isset($_POST['Contact']) ? $_POST['Contact'] : '';
        $house = isset($_POST['House_No']) ? $_POST['House_No'] : '';
        $baranggay = isset($_POST['Baranggay']) ? $_POST['Baranggay'] : '';
        $municipality = isset($_POST['Municipality']) ? $_POST['Municipality'] : '';
        $city = isset($_POST['City']) ? $_POST['City'] : '';

        $errors = isset($_POST['errors']) ? $_POST['errors'] : [];

        if(empty($contact)){
            $errors['Contact'] = "Contact field is required.";
        } elseif(!preg_match('/^[0-9]{11}$/', $contact)){
            $errors['Contact'] = "Not a valid Contact. Must be 11 numbers!";
        }

        if(empty($house)){
            $errors['House_No'] = "This field is required.";
        }

        if(empty($baranggay)){
            $errors['Baranggay'] = "This field is required.";
        }

        if(empty($municipality)){
            $errors['Municipality'] = "This field is required.";
        }
    
        if(empty($city)){
            $errors['City'] = "This field is required.";
        }
        
        $USER_ID = $_SESSION['USER_ID'];
        include('database_con.php');
        if(empty($errors)){
            $_POST['Contact'] = $contact;
            $_POST['House_No'] = $house;
            $_POST['Baranggay'] = $baranggay;
            $_POST['Municipality'] = $municipality;
            $_POST['City'] = $city;

            $query = "UPDATE user_db SET CELLPHONE = ?, HOUSE_NO = ?, BARANGGAY = ?, MUNICIPALITY = ?, CITY = ? WHERE USER_ID = ?";
            $stmt = mysqli_stmt_init($con);
            mysqli_stmt_prepare($stmt, $query);
            mysqli_stmt_bind_param($stmt, 'sssssi', $contact, $house, $baranggay, $municipality, $city, $USER_ID);
            mysqli_stmt_execute($stmt);

            $query_checkout = "INSERT INTO checkout SELECT * FROM buyer_db WHERE USER_ID = ?";
            $stmt_checkout = mysqli_stmt_init($con);
            mysqli_stmt_prepare($stmt_checkout, $query_checkout);
            mysqli_stmt_bind_param($stmt_checkout, 'i', $USER_ID);
            mysqli_stmt_execute($stmt_checkout);
        
            // Prepare the query to delete data from buyer_db
            $query_delete = "DELETE FROM buyer_db WHERE USER_ID = ?";
            $stmt_delete = mysqli_stmt_init($con);
            mysqli_stmt_prepare($stmt_delete, $query_delete);
            mysqli_stmt_bind_param($stmt_delete, 'i', $USER_ID);
            mysqli_stmt_execute($stmt_delete);

            header("LOCATION: checkout.php");
        }

        if(isset($_POST['delete'])){
            include('database_con.php');
            $id = $_POST['product_id']; // Retrieve the product_id from the POST data
        
            // Get the ITEM_DESC for the product
            $query = "SELECT ITEM_DESC FROM buyer_db WHERE ID = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $item_desc = $row['ITEM_DESC'];
        
            mysqli_begin_transaction($con);
        
            $query = "DELETE FROM buyer_db WHERE ID = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Item deleted successfully.";
        
                // Increment the STOCK by 1
                $query = "UPDATE products SET STOCK = STOCK + 1 WHERE ITEM_DESC = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, 's', $item_desc);
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_commit($con);
                    echo "Stock updated successfully.";
                } else {
                    mysqli_rollback($con);
                    echo "Error updating stock.";
                }
            } else {
                echo "Error deleting item or no item found with the given ID.";
            }
        
            mysqli_stmt_close($stmt);
            mysqli_close($con);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cart</title>
        <link rel="stylesheet" href="cart.css">
    </head>
    <body> 
    <div class = "header">
    <div style = "width: 900px;">
        <p style = "margin-left: 75px; font-size: 25px;margin-top: 30px;color: #465a27; font-weight: bold;font-family: Times;">Online Shopping System<p>
    </div>
    <div style = "width: 300px">
        <a href="buyer.php"><button class = "menu-button">SHOP</button></a>
        <form method="post">
            <button name="logout" class="menu-button" onclick="return confirm('Are you sure you want to logout?');">LOGOUT</button>
        </form>
    </div>
    </div>
    <div class = "subheader">
    <div style = "padding-right: 600px; display: inline-block;">
        <p class = "subheading" style = "display: inline-block;"><?php echo $_SESSION['username'];?> Cart!</p>
    </div>  
    <!-- Trigger the modal with a button -->
    </div>
    <div style = "height: 1px; background-color: black;margin-left:230px;width:949.6px;margin-bottom:30px;"></div>

    <div class="cart-products">
        <?php 
        include_once('functions.php');
        $USER_ID = $_SESSION['USER_ID'];
        $products = getAddedToCart($USER_ID);
        
        foreach ($products as $product) {
            ?>
                <div class="item-grid">
                    <div class="item-images">
                        <a href="buyer_product.php?product_id=<?php echo $product['ID']; ?>" target="_blank">
                            <img src="<?php echo "Images/{$product['FILE']}"?>" class="control-images">
                        </a>
                    </div>
                    <div class="item-details">
                        <h4 class="item-desc"><?php echo $product['ITEM_DESC']?></h4>
                        <p class="order-id">Order ID# <?php echo $product['ORDER_ID']?></p>
                        <p class="price">$<?php echo $product['PRICE']?></p>
                        <p class="category"><?php echo $product['CATEGORY']?></p>
                        <p class="Ptype"><?php echo $product['Ptype']?></p>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['ID']; ?>">
                            <input type="submit" name="delete" value="Remove" class="remove-button1">
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="summary">
            <?php
            include('database_con.php');
            $subPrice = 0;
            $query = "SELECT PRICE FROM buyer_db WHERE USER_ID = ?";
            $stmt = mysqli_stmt_init($con);
            mysqli_stmt_prepare($stmt, $query);
            mysqli_stmt_bind_param($stmt, 'i', $USER_ID);

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while($row = $result->fetch_assoc()) {
                $subPrice += $row['PRICE'];
            }

            $tax = $subPrice * 0.10;
            $totalPrice = $subPrice + $tax;
            ?>
            <h4>Order Summary</h4>
            <p class = "subtotal">Subtotal <?php echo $subPrice; ?></p>
            <p class = "tax">Tax <?php echo $tax; ?></p>
           <h4 class = "totalPrice">Total <?php echo $totalPrice; ?></h4>
        </div>
        </div>
        
            <div class="add-location">
                <!--thinking of using UPDATE query-->
                <?php
                include_once('functions.php');
                $USER_ID = $_SESSION['USER_ID'];
                $userDetails = fetchUserDetails($USER_ID, $con); 
                ?>
            <form method = "POST">
            <div class="input-box">
                <span class="details">Contact</span>
                <label for="Contact"></label>
                <input type="text" name="Contact" placeholder="e.g. 09434235419" title="Only 11 Numbers" value="<?php echo isset($userDetails['CELLPHONE']) ? $userDetails['CELLPHONE'] : ''; ?>">
                <?php if (isset($errors['Contact'])): ?>
                    <span class="error"><?php echo $errors['Contact']; ?></span>
                <?php endif; ?>
            </div>
            <div class="input-box">
                <span>House.No</span>
                <label for="House_No"></label>
                <input type="text" name="House_No" placeholder="eg. b839" value="<?php echo isset($userDetails['HOUSE_NO']) ? $userDetails['HOUSE_NO'] : ''; ?>">
                <?php if(isset($errors['House_No'])): ?>
                    <span class="error"><?php echo $errors['House_No']; ?></span>
                <?php endif; ?>
            </div>
            <div class="input-box">
                <span>Baranggay</span>
                <label for="Baranggay"></label>
                <input type="text" name="Baranggay" placeholder="eg. b839" value="<?php echo isset($userDetails['BARANGGAY']) ? $userDetails['BARANGGAY'] : ''; ?>">
                <?php if(isset($errors['Baranggay'])): ?>
                    <span class="error"><?php echo $errors['Baranggay']; ?></span>
                <?php endif; ?>
            </div>
            <div class="input-box">
                <span>Municipality</span>
                <label for="Municipality"></label>
                <input type="text" name="Municipality" placeholder="eg. Malolos" value="<?php echo isset($userDetails['MUNICIPALITY']) ? $userDetails['MUNICIPALITY'] : ''; ?>">
                <?php if(isset($errors['Municipality'])): ?>
                    <span class="error"><?php echo $errors['Municipality']; ?></span>
                <?php endif; ?>
            </div>
            <div class="input-box">
                <span>City</span>
                <label for="City"></label>
                <input type="text" name="City" placeholder="eg.Bulacan" value="<?php echo isset($userDetails['CITY']) ? $userDetails['CITY'] : ''; ?>">
                <?php if(isset($errors['City'])): ?>
                    <span class="error"><?php echo $errors['City']; ?></span>
                <?php endif; ?>
            </div>
            <div class="submit-button">
            <button type="submit" name="submit" value="Checkout" onclick="return confirmOrder()">Proceed to Checkout</button>
            </div>
            </form>
        </div>
    </body>
    <script>
function confirmOrder() {
    var r = confirm("Once you proceed with the checkout, there will be strictly no cancelling of orders. Do you want to continue?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}
</script>
</html>