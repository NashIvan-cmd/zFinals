<<<<<<< HEAD
<?php 
    session_start(); // Start the session at the beginning
    if (isset($_SESSION['message'])) {
        echo "<script type='text/javascript'>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']); // Unset the message
    }

    if ($_SERVER['REQUEST_METHOD']  == "POST") {
        $username = isset($_POST['Username']) ? $_POST['Username'] : '';
        $password = isset($_POST['Password']) ? $_POST['Password'] : '';

        include ('database_con.php');

        // SQL query to select the record with the matching username
        $sql = "SELECT * FROM user_db WHERE USERNAME = ?";
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                // Check if the entered password matches the hashed password stored in the database
                if (password_verify($password, $row['PASSWORD'])) {
                    // Password is correct
                    $_SESSION['message'] = 'Login successful.';
                    $_SESSION['username'] = $username;
                    $_SESSION['USER_ID'] = $row['USER_ID'];
                    header('Location: buyer.php');
                } else {
                    echo 'Error: Invalid password.';
                }
            } else {
                echo 'Error: Invalid username.';
            }
        }
    }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Log-in</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="./images/fb.ico" type="image/x-icon">
</head>

<body>
    <main>
        <div class="main">
        <div class="heading-section">
            <img src="images/heyhey.jpg" class="logo-img">
            <div class="a-ri8"><span>ANA Accessories and Apparels</span></div>
        </div>

        <div class="form">
            <form class="a-form" method="post">
                <input type="Username" id="Username" class="a-email" name="Username" placeholder="Username"
                    autofocus="autofocus" />
                <input type="password" id="Password" class="a-pss" name="Password" placeholder="Password"
                    autofocus="autofocus" />
                <input type="submit" name="login" class="a-sub" value="Log In" />
                <!--<a href="" class="a-link">Forgotten password?</a>-->
                <hr class="a-hr">
                <a href="register.php"><input type="submit " value="Create New Account" class="a-but" /></a>
            </form>
            <div class="create-page">
            </div>
            </div>
        </div>

    </main>
</body>
=======
<?php 
    session_start(); // Start the session at the beginning
    if (isset($_SESSION['message'])) {
        echo "<script type='text/javascript'>alert('" . $_SESSION['message'] . "');</script>";
        unset($_SESSION['message']); // Unset the message
    }

    if ($_SERVER['REQUEST_METHOD']  == "POST") {
        $username = isset($_POST['Username']) ? $_POST['Username'] : '';
        $password = isset($_POST['Password']) ? $_POST['Password'] : '';

        include ('database_con.php');

        // SQL query to select the record with the matching username
        $sql = "SELECT * FROM user_db WHERE USERNAME = ?";
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                // Check if the entered password matches the hashed password stored in the database
                if (password_verify($password, $row['PASSWORD'])) {
                    // Password is correct
                    $_SESSION['message'] = 'Login successful.';
                    $_SESSION['username'] = $username;
                    $_SESSION['USER_ID'] = $row['USER_ID'];
                    header('Location: buyer.php');
                } else {
                    echo 'Error: Invalid password.';
                }
            } else {
                echo 'Error: Invalid username.';
            }
        }
    }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Log-in</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="./images/fb.ico" type="image/x-icon">
</head>

<body>
    <main>
        <div class="main">
        <div class="heading-section">
            <img src="images/heyhey.jpg" class="logo-img">
            <div class="a-ri8"><span>ANA Accessories and Apparels</span></div>
        </div>

        <div class="form">
            <form class="a-form" method="post">
                <input type="Username" id="Username" class="a-email" name="Username" placeholder="Username"
                    autofocus="autofocus" />
                <input type="password" id="Password" class="a-pss" name="Password" placeholder="Password"
                    autofocus="autofocus" />
                <input type="submit" name="login" class="a-sub" value="Log In" />
                <!--<a href="" class="a-link">Forgotten password?</a>-->
                <hr class="a-hr">
                <a href="register.php"><input type="submit " value="Create New Account" class="a-but" /></a>
            </form>
            <div class="create-page">
            </div>
            </div>
        </div>

    </main>
</body>
>>>>>>> origin/main
</html>