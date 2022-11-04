<?php
    session_start();
    require("./auth/register_user.class.php")
?>

<?php
    if (isset($_POST['submit'])) {
        $user = new RegisterUser($_POST['uid'], $_POST['pwd'], $_POST['pwd_var']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles:wght@700&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">
    <title>Sign Up</title>
</head>
<body>
<div class="title-container">
    <h1>Registration</h1>
</div>


    <div class="chalkboard-container">
    <form action="" method="post" enctype="multipart/form-data" class="login-form">
        <h4>All fields are required</h4>

        <label for="uid">Username:</label>
        <input type="text" name="uid" required>

        <label for="pwd">Password:</label>
        <input type="password" name="pwd" required>

        <label for="pwd_var">Verify password:</label>
        <input type="password" name="pwd_var" required>

        <button type="submit" name="submit" class="ltr-btn register-btn">Register</button>

        <p class="error"><?php echo @$user -> error; ?></p>
        <p class="success"><?php echo @$user -> success; ?></p>
    </form>
    </div>
<?php
    include_once('footer.php');
?>
</body>
</html>