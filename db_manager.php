<?php
include 'config.php';
// Check connection
print_r($_REQUEST);
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
}

function copyExercises($db){
    $data = json_decode(stripslashes($_POST['data']));

    foreach($data as $exercise){
        // echo $exercise;

        $sql = "SELECT * from history WHERE id=$exercise";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        $id = $_REQUEST['guest_id'];
        $exercise_id = $row['exercise_id'];
        $location = $row['location'];
        $people = $row['people'];
        $status = $row['status'];
        $sql = "INSERT INTO history (user_id, exercise_id, location, people, status)
            VALUES ($id, $exercise_id, '$location', $people, '$status')";
        if ($db->query($sql) === TRUE) {
            echo "Success";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
     }
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

   

    $sql = "INSERT INTO history (user_id, exercise_id, location, people, status)
    VALUES ($id, $exercise, '$location', $people, '$status')";

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