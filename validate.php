<?php
include "config.php";
 if(isset($_POST['email'])&& isset($_POST['password'])){
     function validate($data){
        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
        return $data;
     }
     $email=validate($_POST['email']);
     $pass=generatePassword($db->real_escape_string(validate($_POST["password"])));

     if(empty($email)){
        header("Location:Login.php?error=Email is required");
        exit();
     }elseif (empty($pass)) {
        header("Location:Login.php?error=Password is required");
        exit();
     }else {
         print($pass);
         $sql= "select * from users where email='$email' and password='$pass'"; 
         $result = mysqli_query($db, $sql);
    if(mysqli_num_rows($result)===1){
        $row = mysqli_fetch_assoc($result);

        if ($row['email']===$email && $row['password']===$pass) {
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['guest)id'] = -1;
            header("Location:profile.php");
        }
    }else{
        // print($pass) ;
        header("Location:Login.php?error=Incorrect Email or Password");
        exit();
        }
    }
     

 }