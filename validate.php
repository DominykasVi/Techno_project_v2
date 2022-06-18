<?php
include "db_conn.php";
 if(isset($_POST['email'])&& isset($_POST['password'])){
     function validate($data){
        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
        return $data;
     }
     $email=validate($_POST['email']);
     $pass=validate($_POST['password']);

     if(empty($email)){
        header("Location:Login.php?error=Email is required");
        exit();
     }elseif (empty($pass)) {
        header("Location:Login.php?error=Password is required");
        exit();
     }else {
         $sql= "select * from users where email='$email' and password='$pass'"; 

         $result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)===1){
    $row = mysqli_fetch_assoc($result);

    if ($row['email']===$email && $row['password']===$pass) {
        header("Location:profile.php");
    }
}else{
    header("Location:Login.php?error=Incorrect Email or Password");
    exit();
}
     }
     

 }