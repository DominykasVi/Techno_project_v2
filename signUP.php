<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>Sign up</title>

</head>
<body>
    <form action="validateSignUp.php" method="post">
        <?php if (isset($_GET['error'])) {?>
            <p class="error"><?php echo $_GET['error']?></p>
       <?php } ?>
        
       <label>Name:</label>
        <input type="text" name="name" placeholder="Name"><br>

        <label>Your username:</label>
        <input type="text" name="username" placeholder="Username"><br>

        <label>Email:</label>
        <input type="text" name="email" placeholder="Email"><br>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Password"><br>

        <label>Height:</label>
        <input type="text" name="height" placeholder="Height"><br>

        <label>Image link:</label>
        <input type="text" name="image" placeholder="paste image link here"><br>

        <button type="submit">Sign up</button>        
    </form>
</body>
</html>