<?php
// TODO:
// add feedback that succesfully inserted
// add form input checks
include 'config.php';
// temp code
session_start(); 
// $_SESSION['id'] = 1;
$id = $_SESSION['id'];

// $_SESSION['guest_id'] = "1";
$_SESSION['guest_id'] =  "-1";


$sql = "SELECT * FROM weights WHERE user_id=$id ORDER BY id DESC LIMIT 1 ";
$result = $db->query($sql);
if ($result->num_rows < 1) {
  $weightRow = [
    'weight' => 1
  ];
}else {
  $weightRow = $result->fetch_assoc();
}

$sql = "SELECT * FROM users WHERE id=$id";
$result = $db->query($sql);
$userRow = $result->fetch_assoc();

// echo $userRow['image'];
// print_r($userRow);  
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
    <link rel="stylesheet" type="text/css" href="./profile.css" />
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
    <input type="hidden" id="view" value="<?php print $_SESSION['guest_id'] ?>">
    <div class="container-fluid h-100">
      <div class="row h-100">
        <div class="col-xl-5 h-100" id="left">
          <div class="container-fluid h-100" id="profileContainer">
            <div class="row align-items-center" id="profileTop">
              <div class="col-sm-5">
              <form action="YourLink.php" method="post">
                <button  
                  type="submit" 
                  style="border: 0; background: transparent">
                  <img id="profile_pic" src="<?php print $userRow['image']?>"/>
                </button>
                <!-- <input type="hidden" name="id" value="<?php print $userRow['id'] ?>"> -->
              </form>
                <!-- <img src="Resources/profile_pic.png" id="profile_pic" onclick="goToLinkPage()" /> -->
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
                    $result = $db->query($sql);
                    $followers = [];
                    if ($result->num_rows < 3) {
                      while ($row = $result->fetch_assoc()){
                        array_push($followers, getFollower($row['follower'], $db));
                      }
                      // print(count($followers));
                      while(count($followers) < 3){
                        array_push($followers, [
                          'image' => 'https://i.pinimg.com/originals/f5/05/24/f50524ee5f161f437400aaf215c9e12f.jpg',
                          'username' => ''
                        ]);
                      };
                    } else {
                      while ($row = $result->fetch_assoc()){
                        array_push($followers, getFollower($row['follower'], $db));
                      }
                      // print $followers[0]['image'];
                    }
                    // output data of each row
                    ?>
                    <a class="route d-flex">
                      <div
                        title="<?php print $followers[2]['username'];?>"
                        class="rounded-circle default-avatar member-overlap-item"
                        style="
                          background: url(<?php print $followers[2]['image']?>)
                            0 0 no-repeat;
                          background-size: cover;
                        "
                      ></div>
                      <div
                        title="<?php print $followers[1]['username'];?>"
                        class="rounded-circle default-avatar member-overlap-item"
                        style="
                        
                          background: url(<?php print $followers[1]['image']?>)
                            0 0 no-repeat;
                          background-size: cover;
                        "
                      ></div>
                      <div
                        title="<?php print $followers[0]['username'];?>"
                        class="rounded-circle default-avatar member-overlap-item"
                        style="
                          background: url(<?php print $followers[0]['image']?>)
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
                      <select 
                        id="exercise"
                        type="button"
                        class="form-select"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        style="position:absolute"
                      >
                        <option selected>Exercise:</option>
                        <?php
                              function printOption($option){
                                echo '<option value="';
                                echo $option;
                                echo '">';
                                echo $option;
                                echo '</option>';
                              }
                              $sql = "SELECT * FROM exercises";
                              $exerciseResults = $db->query($sql);
                              $exerciseDict = [];
                              if ($exerciseResults->num_rows > 0) {
                                // output data of each row
                                  while($row = $exerciseResults->fetch_assoc()) {
                                      // echo $row['id'] . $row['name']. $row['image_link'];
                                      printOption($row['name']);
                                      // print_r($exercideDict);
                                  }
                              }
                        ?>
                      </select>
              
                        <!-- this is here so width doesent get screwed -->
                        <input  style="visibility:   hidden; height: 0px;" id="exercise"/>
                    
                        <!-- <input type="text" id="exercise" name="exercise"/> -->
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
        <div class="col-xl-7 h-100" id="historyDiv">
          <div class="bg-light d-flex justify-content-between">
            <div class="bigText">History</div>
            <button type="button" id="LogOutButton" onclick="LogOut()">Log Out</button>
          </div>
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
                      printImage($exerciseDict[$row['exercise_id']][1], $row['id']);
                      printName($exerciseDict[$row['exercise_id']][0]);
                      printGeneral($row['location']);
                      printGeneral($row['people']);
                      printStatus($row['status'], $row['id']);
                    }
                  } else {
                    echo "0 results";
                  }
                  $db->close();

                  function printImage($img, $id){
                    echo '<div class="col-sm-1">';
                    echo '<img class="exerciseImage" src="';
                    echo $img;
                    echo '"';

                    echo ' id="img';
                    echo $id;
                    echo '" ';

                    echo 'onmouseover="mouseOver(';
                    echo $id;
                    echo ')" onmouseout="mouseOut(';
                    echo $id;
                    echo ", '";
                    echo $img;
                    echo "'";
                    echo ')"';

                    echo 'onclick="deleteExercise(';
                    echo $id;
                    echo ')"';

                    echo '></img>';
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
                  
                  function printStatus($status, $id){
                    $statusDict = [
                      "Not completed" => "#ff0000",
                      "In progress" => "#ffff00",
                      "Done" => "#32cd32"
                    ];

                    echo '<div class="col-sm-1">';
                    echo '<div class="status"';
                    echo ' onclick="changeStatus(';
                    echo $id;
                    echo ')"';
                    echo ' id="';
                    echo $id;
                    echo '" ';
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
              <button 
                type="button" 
                id="historyButton"
                onclick="goToHistoryPage()"
                >
                See history
              </button>
            

          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>

    window.onload = updateBMI();
    window.onload = setVisibility();

    function setVisibility(){
      if($('#view').val() !== "-1"){
        $('#profileCenter').hide();
        $('#profileBottom').hide();
        $('#followButton').hide();

        $('#LogOutButton').text("Back");

        $('.status').css("background-color", "white");
        
        $('#historyDiv').css("border-left", "2px solid #3581b8");
        $('#profileTop').css("border-right", "0px solid #3581b8");
        $('#profileSocial').css("border-right", "0px solid #3581b8");
      }
    }

    function mouseOver(id){
      if($('#view').val() === "-1"){
        let img = "Resources/close.png";
        let imgID = "#img" + id.toString();
        $(imgID).attr("src",img);
      }
    }

    function mouseOut(id, img){
      if($('#view').val() === "-1"){
        let imgID = "#img" + id.toString();
        $(imgID).attr("src",img);
      }
    }

    function changeStatus(id){
      if($('#view').val() === "-1"){
        var statusID = "#" + id.toString();
        let color = $(statusID).css("background-color");
        if(color === 'rgb(50, 205, 50)'){
          $(statusID).css("background-color", "#FF0000");
          updateStatusDB(0, id);
        } else if (color === 'rgb(255, 0, 0)'){
          $(statusID).css("background-color", "#FFFF00");
          updateStatusDB(1, id);
        } else {
          $(statusID).css("background-color", "#32CD32");
          updateStatusDB(2, id);
        }
      }
    }

    function deleteExercise(id){
      if($('#view').val() === "-1"){
        $.ajax({
            type: "POST",
            url: "db_manager.php",
            data: {function: "deleteExercise", "id": id},
            success: function(result){
              // alert(result)
              alert("Exercise has been deleted");
              window.location.reload();
            }
        });
      }
    }

    var statusValues = {
      0: "Not completed",
      1: "In progress",
      2: "Done"
    };

    function updateStatusDB(value, id){
      if($('#view').val() === "-1"){
        console.log(id)
        $.ajax({
            type: "POST",
            url: "db_manager.php",
            data: {function: "updateExercise", "id": id,
                  "value": statusValues[value]},
            success: function(result){
              alert(result);
              alert("Exercise has been updated");
            }
        });
      }
    }

    function goToHistoryPage(){
      window.location.href = 'History.php';
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

      if($(".dropbtn").css( "background-color" )=== "rgb(255, 255, 255)" || exercise=='Exercise:')
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
                // alert(result);
                alert("Exercises have been updated");
                window.location.reload() 
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
                  // alert(result);
                  alert("Your weight has been updated");

                  window.location.reload() 
              }
          });
      }
      return false;
    }
    function updateHeight(){
      if($('#view').val() === "-1"){
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
                    alert("Your height has been updated");
                    window.location.reload() 
                }
            });
        }
        return false;
      }
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
    function LogOut(){
      if($('#view').val() !== "-1"){
        alert("Implement going back to the user");
      } else {
        window.location.href = 'logout.php';
        return false;
      }
    }
  </script>
</html>
