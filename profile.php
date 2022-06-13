<?php
// TODO:
// add feedback that succesfully inserted
// add form input checks
include 'config.php';
// temp code
session_start(); 
$_SESSION['id'] = 1;
$id = $_SESSION['id'];

$sql = "SELECT * FROM weights WHERE user_id=$id ORDER BY id DESC LIMIT 1 ";
$result = $db->query($sql);

$weightRow = $result->fetch_assoc();

$sql = "SELECT * FROM users WHERE id=$id";
$result = $db->query($sql);
$userRow = $result->fetch_assoc();

// print_r($userRow['height']);
// print $row['weigth']
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
    <link rel="stylesheet" type="text/css" href="profile.css" />
  </head>
  <body>
    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
    
    <div class="container-fluid h-100">
      <div class="row h-100">
        <div class="col-xl-5 h-100" id="left">
          <div class="container-fluid h-100" id="profileContainer">
            <div class="row align-items-center" id="profileTop">
              <div class="col-sm-5">
                <img src="Resources/profile_pic.png" id="profile_pic" onclick="goToLinkPage()" />
              </div>

              <div class="col-sm-7">
                <input class="profileInfo" 
                        value="<?php print $userRow['height']?> cm"
                        onchange="updateHeight()"
                        id="height"></input>
                <p class="profileInfo" id="weight"><?php print $weightRow['weight'] ?></p>
                <p class="profileInfo" id="BMI"></p>
              </div>
            </div>
            <div class="row align-items-center" id="profileSocial">
              <div class="col-3" id="peopleFollowing">
                <table
                  id="grid_groups"
                  class="table table-hover w-100"
                  role="grid"
                >
                  <tbody>
                    <?php 
                    function getFollower($id, $db){
                      $sql = "SELECT username, image FROM users 
                      WHERE id=$id";
                      $userQuery = $db->query($sql);
                      return $userQuery->fetch_assoc();
                    }
                    $sql = "SELECT follower FROM relationships 
                    WHERE following=$id ORDER BY id DESC LIMIT 3";
                    $followers = $db->query($sql);
                    // output data of each row
                    $row = $followers->fetch_assoc();
                    $user = getFollower($row['follower'], $db);?>
                    <a class="route d-flex">
                      <div
                        title="<?php print $user['username'];?>"
                        class="rounded-circle default-avatar member-overlap-item"
                        style="
                          background: url(<?php print $user['image']?>)
                            0 0 no-repeat;
                          background-size: cover;
                        "
                      ></div>
                      <?php 
                      $row = $followers->fetch_assoc();
                      $user = getFollower($row['follower'], $db);?>
                      <div
                        title="<?php print $user['username'];?>"
                        class="rounded-circle default-avatar member-overlap-item"
                        style="
                        
                          background: url(<?php print $user['image']?>)
                            0 0 no-repeat;
                          background-size: cover;
                        "
                      ></div>
                      <?php 
                      $row = $followers->fetch_assoc();
                      $user = getFollower($row['follower'], $db);?>
                      <div
                        title="<?php print $user['username'];?>"
                        class="rounded-circle default-avatar member-overlap-item"
                        style="
                          background: url(<?php print $user['image']?>)
                            0 0 no-repeat;
                          background-size: cover;
                        "
                      ></div>
                    </a>
                  </tbody>
                </table>
              </div>
              <div class="col-3" id="followDiv">
                <button id="followButton" onclick="goToFollowPage()">Follow</button>
              </div>
              <div class="col-6" id="recomendationDiv">
                <p id="recomendationText">Recommended weight:</p>
                <p id="recomendedWeight"></p>
              </div>
            </div>
            <div class="row align-items-center" id="profileCenter">
              <!-- <form method="POST" action="db_manager.php"> -->
              <form>

                <input name="function" type="hidden" value="insertExercise"></input>
                <p class="bigText">Add exercise</p>
                <div class="container" id="addExerciseFormContainer">
                  <div class="row align-items-center" >
                    <div class="col-lg-2" >
                          <button class="dropbtn" onclick="showButton()" type="button"></button>
                          <input name="status" type="hidden" id="statusForm"></input>
                    </div>
                    <div class="col-lg-4">
                      <input type="text" id="exercise" name="exercise"/>
                    </div>
                    <div class="col-lg-3">
                      <div class="btn-group">
                        <button
                          type="button"
                          class="btn btn-danger dropdown-toggle"
                          data-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                          id="dropdownButton"
                        >
                          Options
                        </button>
                        <div class="dropdown-menu">
                          <!-- TODO: add form input for whole class -->
                          <form class="px-15">
                            <input
                              type="text"
                              class="form-control"
                              placeholder="Location"
                              name="location"
                              id="location"
                            />
                            <input
                              type="number"
                              class="form-control"
                              placeholder="People"
                              name="people"
                              id="people"
                            />
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <button type="button" id="addButton" onclick="submitForm(status)">Add</button>
                    </div>
                    <div>
                      <div class="one">
                        <button id="statusButtonOne" onclick="colorChange(2)" value="Completed"
                        type="button"></button>
                      </div>
                      <div class="two">
                        <button id="statusButtonTwo" onclick="colorChange(1)" value="In progress"
                        type="button">
                      </div>
                      <div class="three">
                        <button id="statusButtonThree" onclick="colorChange(0)" value="Not completed"
                        type="button">
                      </div>
                    </div>
                  </div>
                </div>
              <form>
            </div>
            <div class="row align-items-center" id="profileBottom">
              <form action=''>
              <p class="bigText">Add weight</p>
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-lg-9" style="position: relative">
                    <input
                      type="number"
                      class="form-control"
                      id="weightInput"
                    />
                  </div>
                  <div class="col-lg-3">
                    <button type="button" id="addWeightButton" onclick="submitWeight()">Add</button>
                  </div>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-xl-7 h-100" id="right">
          <div class="bigText">History</div>
          <div class="container py-0 my-0 text-center" id="historyContainer">
            <div
              class="row align-items-center my-0"
            >
              <div class="col-sm-1"></div>
              <div class="col-sm-4 historyText">Exercise</div>
              <div class="col-sm-3 historyText">Location</div>
              <div class="col-sm-3 historyText">People</div>
              <div class="col-sm-1"></div>
            </div>
            <div class="row align-items-center" id="historyRow">
              <div id="exerciseList" class="container align-items-center">
                <div
                  class="row align-items-center my-0"
                >
                  <!-- TODO: cahnge to shape with color property, js or php? -->
                  <?php
                  $sql = "SELECT * FROM exercises";
                  $exerciseResults = $db->query($sql);
                  $exerciseDict = [];
                  if ($exerciseResults->num_rows > 0) {
                    // output data of each row
                      while($row = $exerciseResults->fetch_assoc()) {
                        // echo $row['id'] . $row['name']. $row['image_link'];
                        $exerciseDict[$row['id']] = [$row['name'], $row['image_link']];
                        // print_r($exercideDict);
                      }
                    }
                  // print_r($exerciseDict);

                  $sql = "SELECT id, exercise_id, location, people, status FROM
                  history WHERE user_id=$id ORDER BY id DESC LIMIT 6";
                  $historyResults = $db->query($sql);
                  if ($historyResults->num_rows > 0) {
                  // output data of each row
                    while($row = $historyResults->fetch_assoc()) {
                      printImage($exerciseDict[$row['exercise_id']][1]);
                      printName($exerciseDict[$row['exercise_id']][0]);
                      printGeneral($row['location']);
                      printGeneral($row['people']);
                      printStatus($row['status']);
                    }
                  } else {
                    echo "0 results";
                  }
                  $db->close();

                  function printImage($img){
                    echo '<div class="col-sm-1">';
                    echo '<img id="exerciseImage" src="';
                    echo $img;
                    echo '"></img>';
                    echo '</div>';

                  }

                  function printName($name){
                    echo '<div class="col-sm-4 historyText">';
                    echo '<p class="exerciseInfo">';
                    echo $name;
                    echo '</p>';
                    echo '</div>';
                  }

                  function printGeneral($general){
                    echo '<div class="col-sm-3 historyText">';
                    echo '<p class="exerciseInfo">';
                    echo $general;
                    echo '</p>';
                    echo '</div>';
                  }
                  
                  function printStatus($status){
                    $statusDict = [
                      "Not completed" => "#ff0000",
                      "In progress" => "#ffff00",
                      "Done" => "#32cd32"
                    ];

                    echo '<div class="col-sm-1">';
                    echo '<div id="status"';
                    echo 'style="background-color:';
                    echo $statusDict[$status];
                    echo '"';
                    echo '></div>';
                    echo '</div>';
                  }
                  ?>
                  <!-- <div class="col-sm-1">
                    <img id="exerciseImage" src="Resources/fitness.png"></img>
                  </div>
                  <div class="col-sm-4 historyText">
                    <p class="exerciseInfo">Bicep Curls</p>
                  </div>
                  <div class="col-sm-3 historyText">
                    <p class="exerciseInfo">Home</p>
                  </div>
                  <div class="col-sm-3 historyText">
                    <p class="exerciseInfo">2</p>
                  </div>
                  <div class="col-sm-1">
                    <div id="status"></div>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
          <div class="text-center">
            <button id="historyButton" onclick="goToHistoryPage()">See history</button>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    function goToHistoryPage(){
      window.location.href = 'project.html';
      return false;
    }
    function goToLinkPage(){
      window.location.href = 'YourLink.html';
      return false;
    }

    function goToFollowPage(){
      window.location.href = 'follow.html';
      return false;
    };

    var status = -1;
    window.onload = updateBMI();
    function colorChange(value){
      showButton();
      switch (value) {
        case 0:
          $(".dropbtn").css("background-color", "#FF0000");
          $('#statusForm').val("Not completed");
          status = 0;
          break;
        case 1:
          $(".dropbtn").css("background-color", "#FFFF00");
          $('#statusForm').val("In progress");
          status = 1;
          break;
        case 2:
          $(".dropbtn").css("background-color", "#32CD32");
          $('#statusForm').val("Done");
          status = 2;
          break;
        default:
          $(".dropbtn").css("background-color", "white");
      }

    }

    function showButton(){
      $('.one').toggle();
      $('.two').toggle();
      $('.three').toggle();
      $(".dropbtn").css("background-color", "white");
    }
    statusDict = {
      0: "Not completed",
      1: "In progress",
      2: "Done"
    }
    function submitForm(){
      var statusForm = statusDict[status];
      var exercise = $("#exercise").val();
      var location = $("#location").val();
      var people = $("#people").val();
      console.log(status)
      var dataString = 'function=insertExercise&status=' + statusForm + '&location=' + location + '&people=' + people + '&exercise=' + exercise;

      if($(".dropbtn").css( "background-color" )=== "rgb(255, 255, 255)" || exercise=='')
      {
          alert("Please fill in all fields");
      }
      else
      {
          // Ajax code to submit form.
          $.ajax({
              type: "POST",
              url: "db_manager.php",
              data: dataString,
              success: function(result){
                alert("Exercises have been updated");
              }
          });
      }
      return false;
    }

    function submitWeight(){
      var weight = $("#weightInput").val();
      if(weight==='' || weight==null)
      {
          alert("Please fill in weight");
      }
      else
      {
        var weight = parseFloat(weight);
        var dataString = 'function=insertWeight&weight=' + weight;

          // Ajax code to submit form.
          $.ajax({
              type: "POST",
              url: "db_manager.php",
              data: dataString,
              success: function(result){
                  alert(result);
                  // window.location.reload() 
              }
          });
      }
      return false;
    }
    function updateHeight(){
      var height = parseFloat($("#height").val());
      // console.log(parseFloat(height))
      var dataString = 'function=updateHeight&height=' + height;
      if(height==='' || height==null)
      {
          alert("Please fill in weight");
      }
      else
      {
          // Ajax code to submit form.
          $.ajax({
              type: "POST",
              url: "db_manager.php",
              data: dataString,
              success: function(result){
                  alert(result);
                  window.location.reload() 
              }
          });
      }
      return false;
    }
    function updateBMI(){
      var weight = (parseFloat($("#weight").text()));
      var height = (parseFloat($("#height").val())/100);
      // while (weight == '' || height==''){
      //   weight = $("#weightInput").val();
      //   height = (parseFloat($("#height").val())/100);

      // }
      
      var bmi = (weight / (height * height)).toFixed(1);;
      $('#BMI').text(bmi);

      var recomendedWeight = (20 * (height*height)).toFixed(1);;
      $('#recomendedWeight').text(recomendedWeight);
    }
  </script>
</html>
