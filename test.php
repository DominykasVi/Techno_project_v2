<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project_database";

    $db = new mysqli($servername, $username, $password, $dbname);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    echo "hi";
    $sql = "SELECT * FROM
    exercises";
    echo "hi";

    $result = $db->query($sql);
    echo "hi";

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " .
        $row["name"];
        }
        } else {
        echo "0 results";
    }
    $db->close();
?>