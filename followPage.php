<?php 
include 'config.php';
session_start(); 
$id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>profile</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" type="text/css" href="followPage.css" />
  </head>
<body>
  <div class="row no gutters">
    <div class="col-md-6">
        <div id="coll">
            <div>
            <label>ENTER FOLLOW CODE</label>
            </div>
            <div>
              <input id= "SearchBar" type="text" name="User Tag" placeholder="..."><br>
          </div>
            <div>
              <button id="SearchButton" type="Search user" onclick="followUser()">FOLLOW</button>
          </div>
      </div>
  </div>
  <div class="col-md-6">
    <div id="colr">
        <div>
          <label id="following">FOLLOWING</label>
        </div>
        <div id="exerciseList" class="container align-items-center">
          <div>
            <?php
              // echo $id;
              $sql = "SELECT following FROM
                  relationships WHERE follower=$id";
              $followers = $db->query($sql);
              if ($followers->num_rows > 0) {
              // output data of each row
                $counter = 0;
                while($row = $followers->fetch_assoc()) {
                  $counter += 1;
                  $followingID = $row['following'];
                  $sql = "SELECT username, image FROM
                  users WHERE id=$followingID";
                  $result = $db->query($sql);
                  $row = $result->fetch_assoc();
                  // print_r($row);
                  // echo $followers->num_rows;
                  startRow();
                  printImage($row['image']);
                  printUsername($row['username'], $followingID);
                  endRow();
                }
              } else {
                echo "0 results";
              }

              function startRow(){
                echo '<div class="row align-items-center my-0">';
              }

              function endRow(){
                echo '</div';

              }

              function printImage($img){
                echo '<div class="col-sm-2">';
                echo '<img class="profileImage" src="';
                echo $img;
                echo '"';
                echo '></img>';
                echo '</div>';
              };

              function printUsername($username, $id){
                echo '<div class="username col-sm-10"';

                echo ' onclick="goToProfile(';
                echo $id;
                echo ')"';

                echo '>';
                echo $username;
                echo '</div>';
              }
              ?>
          </div>
        </div>
        
    </div>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  function followUser(){
    var tag = $('#SearchBar').val()
    if(tag !== ''){
      $.ajax({
            type: "POST",
            url: "db_manager.php",
            data: {"function": "followUser", "tag": tag},
            success: function(result){
              alert(result)
              // alert("User followed");
              window.location.reload();
            }
        });
    }
  }

  function goToProfile(id){
    $.ajax({
            type: "POST",
            url: "sessionManager.php",
            data: {'id': id},
            success: function(result){
              // alert(result);
              window.location.href = 'profile.php';

            }
        });

  }

</script>
</html>