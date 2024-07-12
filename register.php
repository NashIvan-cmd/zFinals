<?php 
    session_start(); // Start the session at the beginning
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $username = isset($_POST['Username']) ? $_POST['Username'] : '';
        $email = isset($_POST['Email']) ? $_POST['Email'] : '';
        $password = isset($_POST['Password']) ? $_POST['Password'] : '';

        $errors = isset($_POST['errors']) ? $_POST['errors'] : [];

        if (empty($username)) {
            $errors['Username'] = "Usernamename field is required.";
        } elseif (!preg_match("/^[a-zA-Z]/", $username)) {
            $errors['Username'] = "Not a valid name. Alphabets Prefix Only!";
        }
        $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

        if (empty($email)) {
            $errors['Email'] = "Email field is required.";
        } elseif (!preg_match($pattern, $email)) {
            $errors['Email'] = "Invalid email format.";
        }

        $pattern = '/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/';

        if (empty($password)) {
            $errors['Password'] = 'This field is required.';
        } elseif(!preg_match($pattern, $password)) {
            $errors['Password'] = 'Atleast 8 characters long. Atleast 1 number and capital letter';
        }

        include('database_con.php');
        $sql = "SELECT * FROM user_db WHERE USERNAME = ? OR EMAIL = ?";
        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {
            mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $errors['Username'] = "Username or Email already exists.";
            }
        }

        if(empty($errors)){
            $_POST['Username'] = $username;
            $_POST['Email'] = $email;
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO user_db(USERNAME, EMAIL, PASSWORD)
            VALUES (?, ?, ?)";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $hashed_password);
            }
            if(mysqli_stmt_execute($stmt)){
                $_SESSION['message'] = 'Account created successfully.';
                header('Location: login.php');
            }else{
                echo 'Error: '. mysqli_error($con);
            }
        }

    }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
                <h3>Sign up</h3><br>
                <input type="username" id="Username" class="a-email" name="Username" placeholder="Username"
                    autofocus="autofocus" />
                    <?php if(isset($errors['Username'])): ?>
                        <span class="error" style="color: red;"><?php echo $errors['Username'];?></span>
                    <?php endif; ?>
                <input type="email" id="Email" class="a-email" name="Email" placeholder="Email address"
                    autofocus="autofocus" />
                    <?php if (isset($errors['Email'])): ?>
                        <span class="error" style="color: red;"><?php echo $errors['Email']; ?></span>
                    <?php endif; ?>
                <input type="password" id="Password" class="a-pss" name="Password" placeholder="Password"
                    autofocus="autofocus" />
                    <?php if(isset($errors['Password'])): ?>
                        <span class="error" style="color: red;"><?php echo $errors['Password']; ?></span>
                    <?php endif; ?>
                <input type="submit" name="Register" class="a-sub" value="Register" />
                <hr class="a-hr">
                <h5>Already have account?</h5>
                <a href="login.php"><input  value="Login" class="a-but" /></a>
                <h5>Just view items.</h5>
                <a href="no_account.php"><input value="Click here" class="a-but" /></a>
            </form>
            </div>
        </div>

    </main>
</body>
</html>