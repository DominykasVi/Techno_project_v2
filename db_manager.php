<?php
include 'config.php';

// Check connection
print_r($_REQUEST);
session_start(); 


switch ($_REQUEST["function"]){
    case "insertExercise":
        insertExercise($db);
        break;
}

function insertExercise($db){
    $exercises = [
        "bench press" => "1"
    ];
    $id=$_SESSION['id'];
    $status=$_REQUEST['status'];
    $exercise=$exercises[$_REQUEST['exercise']];

    if($_REQUEST['people'] = "location"){
        $location=$_REQUEST['location'];
    } else {
        echo "location not set;";

        $location=" ";
    }
    if($_REQUEST['people'] = ""){
        $people=$_REQUEST['people'];
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