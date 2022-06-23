<?php
include 'config.php';
// Check connection
// print_r($_REQUEST);
session_start(); 


switch ($_REQUEST["function"]){
    case "insertExercise":
        insertExercise($db);
        break;
    case "insertWeight":
        insertWeight($db);
        break;
    case "updateHeight":
        updateHeight($db);
        break;
    case "copy":
        copyExercises($db);
        break;
    case "updateExercise":
        updateExercise($db);
        break;
    case "deleteExercise":
        deleteExercise($db);
        break;
    case "updateImage":
        updateImage($db);
        break;
    case "followUser":
        followUser($db);
        break;
        
}

function followUser($db){
    $tag = mysqli_real_escape_string($db, $_REQUEST['tag']);
    $sql = "SELECT id FROM users WHERE custom_id='$tag'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $_SESSION['id'];
        $following = $row['id'];
        
        $sql = "SELECT following FROM relationships WHERE follower='$id'";
        $result = $db->query($sql);
        while($row = $result->fetch_assoc()){
            $followID = $row['following'];
            if($followID == $following){
                echo "Already following user";
                return;
            };
        }

        $sql = "INSERT INTO relationships (follower, following) 
        VALUES ($id, $following);";
        if ($db->query($sql) === TRUE) {
            echo "User followed";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    } else {
        echo "no such user";
    };
}

function updateImage($db) {
    $img = mysqli_real_escape_string($db, $_REQUEST['img']);
    $id = $_SESSION['id'];
    $sql = "UPDATE users SET image='$img' WHERE id =$id ; ";
    if ($db->query($sql) === TRUE) {
        echo "Image updated";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
};

function deleteExercise($db){
    $id = mysqli_real_escape_string($db, $_REQUEST['id']);
    $sql = "DELETE FROM history WHERE id = $id";
    if ($db->query($sql) === TRUE) {
        echo "Success";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
};

function updateExercise($db){
    
    $status = mysqli_real_escape_string($db, $_REQUEST['value']);
    $id = mysqli_real_escape_string($db, $_REQUEST['id']);
    $date = date('Y-m-d');
    $sql = "UPDATE history SET status = '$status', date='$date'  WHERE id = $id";
    // echo $sql;
    if ($db->query($sql) === TRUE) {
        echo "Success";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}

function copyExercises($db){
    $data = json_decode(stripslashes($_POST['data']));
    $id = $_SESSION['guest_id'];
    foreach($data as $exercise){
        // echo $exercise;

        $sql = "SELECT * from history WHERE id=$exercise";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        
        $exercise_id = $row['exercise_id'];
        $location = $row['location'];
        $people = $row['people'];
        $status = $row['status'];
        $date = date('Y-m-d');
        $sql = "INSERT INTO history (user_id, exercise_id, location, people, status, date)
            VALUES ($id, $exercise_id, '$location', $people, '$status', '$date')";
        if ($db->query($sql) === TRUE) {
            echo "Exercises copied";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
     }

    // $sql = "SELECT username, email, custom_id from users WHERE id=$id";
    // $result = $db->query($sql);
    // $row = $result->fetch_assoc();

    // // $email = $row['email'];
    // $email = 'dominykas.vi@gmail.com';
    //     $username = $row['username'];
    // $custom_id = $row['custom_id'];
    // // the message
    // $msg = "The user :". $username . "(" . $custom_id . ") has copied your exercises" . $row['email'];

    // // use wordwrap() if lines are longer than 70 characters
    // $msg = wordwrap($msg,70);

    // // send email
    // if (mail($email,"Exercises copied",$msg) == TRUE){
    //     echo "email sent";
    // }else {
    //     echo "could not send email";
    // };
}

function insertExercise($db){
    $sql = "SELECT * FROM exercises";
    $exerciseResults = $db->query($sql);
    $exerciseDict = [];
    if ($exerciseResults->num_rows > 0) {
      // output data of each row
        while($row = $exerciseResults->fetch_assoc()) {
            // echo $row['id'] . $row['name']. $row['image_link'];
            $exerciseDict[$row['name']] = $row['id'];
            // print_r($exercideDict);
        }
    }
    $id=$_SESSION['id'];
    
    $status=mysqli_real_escape_string($db, $_REQUEST['status']);
    $exercise=$exerciseDict[mysqli_real_escape_string($db, $_REQUEST['exercise'])];

    if($_REQUEST['location'] != ""){
        $location=mysqli_real_escape_string($db, $_REQUEST['location']);
    } else {
        echo "location not set;";
        $location=" ";
    }
    if($_REQUEST['people'] != ""){
        $people=mysqli_real_escape_string($db, $_REQUEST['people']);
    } else {
        echo "people not set;";
        $people=1;
    }

   
    $date = date('Y-m-d');
    $sql = "INSERT INTO history (user_id, exercise_id, location, people, status, date)
    VALUES ($id, $exercise, '$location', $people, '$status', '$date')";

    echo $sql;
    if ($db->query($sql) === TRUE) {
        $last_id = $db->insert_id;
        echo "Success";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}

function insertWeight($db){
    $id=$_SESSION['id'];

    if($_REQUEST['weight'] != ""){
        $weight=mysqli_real_escape_string($db, $_REQUEST['weight']);
    } else {
        echo "weight not set;";
        return false;
    }
    $date = date('Y-m-d');

    // echo $_REQUEST['weight'];
    $sql = "INSERT INTO weights (user_id, weight, date) 
    VALUES ($id, $weight, '$date')";

    if ($db->query($sql) === TRUE) {
        $last_id = $db->insert_id;
        echo "Success";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}
function updateHeight($db){
    $id=$_SESSION['id'];

    if($_REQUEST['height'] != ""){
        $height=mysqli_real_escape_string($db, $_REQUEST['height']);
    } else {
        echo "height not set;";
        return false;
    }
    // $date = date('Y-m-d');

    // echo $_REQUEST['weight'];
    $sql = "UPDATE users SET `height`=$height WHERE id=$id";

    if ($db->query($sql) === TRUE) {
        $last_id = $db->insert_id;
        echo "Success";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}
// $sql = "INSERT INTO oil_change (name, email, date, plate, approved)
// VALUES ('$name', '$email', '$date', '$plate', 0)";

// if ($db->query($sql) === TRUE) {
//     $last_id = $db->insert_id;
//     echo "Thank you. the following query data is:<br>
//         $name, $email, $date, $plate<br>
//         You have the number $last_id, that you should use as a reference. ";
// } else {
//     echo "Error: " . $sql . "<br>" . $db->error;
// }

// $db->close();
?>