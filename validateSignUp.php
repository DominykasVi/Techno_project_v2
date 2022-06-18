<?php
    include 'config.php';
    session_start();

    function validate($data){
        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
        return $data;
    }
    $email=validate($_POST['email']);
    $pass=validate($_POST['password']);
    $username=validate($_POST['username']);
    $name=validate($_POST['name']);
    $height=validate($_POST['height']);
    if(empty($email)){
        header("Location:signUP.php?error=Email is required");
        exit();
    }elseif (empty($pass)) {
        header("Location:signUP.php?error=Password is required");
        exit();
    }else if (empty($username)){
        header("Location:signUP.php?error=Username is required");
        exit();
    }
    else if(empty($name)){
        header("Location:signUP.php?error=Name is required");
        exit();

    }else if(empty($height)){
        header("Location:signUP.php?error=Height is required");
        exit();

    }else {
        if(floatval($height) <= 0){
            header("Location:signUP.php?error=Height is not a number");
            exit();
        }
        
        $pass = generatePassword($db->real_escape_string($_POST["password"]));
        // $custom_id= $username . ;

        $sql= "SELECT custom_id FROM users WHERE username='$username' ORDER BY id 
        DESC LIMIT 1";

        $result = $db->query($sql);
        if ($result->num_rows < 1) {
            $custom_id = $username . "#0000";
        }else {
            $row = $result->fetch_assoc();
            $arr = explode("#", $row['custom_id']);
            // print_r($arr);
            $num = (int)$arr[1] + 1;
            $num_length = strlen((string)$num);
            // print($num_length);
            while($num_length < 4){
                $num = "0" . (string)$num;
                $num_length = strlen($num);
            }
            $custom_id = $username . "#". $num;
        };

        $sql= "SELECT email FROM users WHERE username='$email'";

        $result = $db->query($sql);
        if ($result->num_rows > 1) {
            header("Location:signUP.php?error=Email already in use");
            exit();
        }


        if($_POST['image'] != ''){
            if(strlen($_POST['image']) > 16000){
                header("Location:signUP.php?error=Image link is too long");
                exit;
            }else {
                $img = $_POST['image'];
            }
        }else{
            $img = "https://cdn-icons-png.flaticon.com/512/747/747376.png";
        }


        $sql= "insert into users(name, username, email, custom_id, password, image, height) 
        values('$name', '$username','$email', '$custom_id', '$pass', '$img', $height)";

        if ($db->query($sql) === TRUE) {
            $last_id = $db->insert_id;
            $_SESSION['id'] = $last_id;
            $_SESSION['guest)id'] = -1;
            header("Location: profile.php");   
        } else {
            echo "Error: " . $db->error;
        }
    }