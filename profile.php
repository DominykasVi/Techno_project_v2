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
                <img src="Resources/profile_pic.png" id="profile_pic" />
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
                    <a class="route d-flex">
                      <div
                        title="Profile 1"
                        class="rounded-circle default-avatar member-overlap-item"
                        style="
                          background: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQWb8K3oCadfjT91q1nyuzUHR4QjzVQYIDTvw&usqp=CAU)
                            0 0 no-repeat;
                          background-size: cover;
                        "
                      ></div>
                      <div
                        title="Profile 2"
                        class="rounded-circle default-avatar member-overlap-item"
                        style="
                        
                          background: url(https://media.vanityfair.com/photos/5eb06b3ec135d48f5b12097d/4:3/w_1116,h_837,c_limit/baby-yoda-craze.jpg)
                            0 0 no-repeat;
                          background-size: cover;
                        "
                      ></div>
                      <div
                        title="Profile 3"
                        class="rounded-circle default-avatar member-overlap-item"
                        style="
                          background: url(data:image/jpeg;base64,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)
                            0 0 no-repeat;
                          background-size: cover;
                        "
                      ></div>
                    </a>
                  </tbody>
                </table>
              </div>
              <div class="col-3" id="followDiv">
                <button id="followButton">Follow</button>
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
            <button id="historyButton">See history</button>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
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
          status = -1;
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

      var dataString = 'function=insertExercise&status=' + statusForm + '&location=' + location + '&people=' + people + '&exercise=' + exercise;
      if(status==-1 || exercise=='')
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
              // success: function(result){
              //     alert(result);
              // }
          });
      }
      return false;
    }

    function submitWeight(){
      var weight = parseFloat($("#weightInput").val());
      var dataString = 'function=insertWeight&weight=' + weight;
      if(weight==='' || weight==null)
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
