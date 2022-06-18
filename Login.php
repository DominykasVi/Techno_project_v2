<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>LOGIN</title>

</head>
<body>
    <form action="validate.php" method="post">
        <?php if (isset($_GET['error'])) {?>
            <p class="error"><?php echo $_GET['error']?></p>
       <?php } ?>
        <label>Email:</label>
        <input type="text" name="email" placeholder="Email"><br>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit">Login</button>
        
        <button type="button" onclick="goToSignUp()">Sign up?</button>        
    </form>
</body>
<script>
    function goToSignUp(){
        window.location.href = 'signUP.php';
    }
</script>
</body>
</html>