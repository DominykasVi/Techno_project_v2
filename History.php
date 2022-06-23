<?php
include 'config.php';

session_start();
$_SESSION['id'] = 1;
$id = $_SESSION['id'];

//  $_SESSION['guest_id'] = -1
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="Project.css" />
</head>

<body>
  <!--<input type="hidden" id="view" value="<?php print $_SESSION['guest_id'] ?>"-->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <div class="row">

    <div id="coll" class="container-fluid col-5">
      <div class="row align-items-center justify-content-center">
        <div class="col-sm-2">
          <button class="btn" onclick="goToProfilePage()"><i id="profileText" class="fa fa-home" > Profile</i></button>
        </div>
        <div class="mainHeading col-sm-9 text-center">
          History
        </div>
      </div>

      <div id="exercisesPageHeadings" class="row justify-content-center">
        <div class="col-sm-1"></div>
        <div class="col-sm-7 headingText">Exercise</div>
        <div class="col-sm-1 headingText">Status</div>
      </div>

      <div id="weightPageHeadings" class="row justify-content-center">
        <div class="col-sm-4 headingText">Weight</div>
        <div class="col-sm-4 headingText">Date</div>
      </div>


      <div class="row align-items-center" id="historyRow">
        <div id="exerciseList" class="container align-items-center">
          <div class="row align-items-center">
            <?php
            $sql = "SELECT * FROM exercises";
            $exerciseResults = $db->query($sql);
            $exerciseDict = []; 
            if ($exerciseResults->num_rows > 0) {
              // output data of each row
              while ($row = $exerciseResults->fetch_assoc()) {
                $exerciseDict[$row['id']] = [$row['name'], $row['image_link']];
              }
            }

            $sql = "SELECT id, exercise_id, location, people, status FROM
                            history WHERE user_id=$id ORDER BY id DESC";
            $historyResults = $db->query($sql);
            if ($historyResults->num_rows > 0) {
              // output data of each row
              while ($row = $historyResults->fetch_assoc()) {
                printImage($exerciseDict[$row['exercise_id']][1], $row['id']);
                printName($exerciseDict[$row['exercise_id']][0]);
                printStatus($row['status'], $row['id']);
              }
            } else {
              echo "0 results";
            }
            //$db->close();

            function printImage($img, $id){
              echo '<div class="col-sm-2 w-90">';
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

            function printName($name)
            {
              echo '<div class="col-sm-8 historyText">';
              echo '<p class="exerciseInfo">';
              echo $name;
              echo '</p>';
              echo '</div>';
            }

            function printStatus($status, $id)
            {
              $statusDict = [
                "Not completed" => "#ff0000",
                "In progress" => "#ffff00",
                "Done" => "#32cd32"
              ];

              echo '<div class="col-sm-1">';
              echo '<div class="status"';

              echo 'id="';
              echo $id;
              echo '"';
              // echo 'id="18"';

              echo ' onclick="copyExercise(';
              echo $id;
              echo ')"';

              echo ' style="background-color:';
              echo $statusDict[$status];
              echo '"';
              echo '></div>';
              echo '</div>';
            }
            ?>
          </div>
        </div>
        <div class="text-center" style="width: 100%">
          <button id="copyButton" onclick="copyExercises()">Copy selected exercises</button>
        </div>
      </div>


      <div class="row align-items-center" id="weightsRow">
        <div id="weightsList" class="container align-items-center">
          <div class="row align-items-center">
            <?php
                $sql2 = "SELECT id, weight, date FROM weights WHERE user_id=$id ORDER BY id DESC";
                $weightRsesults2 = $db->query($sql2);
                if ($weightRsesults2->num_rows > 0) {
                // output data of each row
                    while($row2 = $weightRsesults2->fetch_assoc()) {
                      printSpace();
                      printWeight($row2['weight']);
                      printDate($row2['date']);
                    }
                } else {
                    echo "0 results";
                }
                //$db->close();

                function printSpace(){
                  echo '<div class="col-md-2">';
                  echo '</div>';
                }

                function printWeight($weight){
                  echo '<div class="col-md-4 historyText">';
                  echo '<p class="weightInfo">';
                  echo $weight;
                  echo '</p>';
                  echo '</div>';
                }

                function printDate($date){
                  echo '<div class="col-md-4 historyText">';
                  echo '<p class="weightInfo">';
                  echo $date;
                  echo '</p>';
                  echo '</div>';
                  echo '<div class="col-md-2 historyText"></div>';
                }
            ?>
          </div>
        </div>
      </div>


    </div>

    <div class="container-fluid col-7">
      <div id="row" class="row justify-content-md-center">
        <div id="coll_slider" class="col col-sm-4">Exercises</div>
        <div id="colr_slider" class="col col-sm-4">Weights</div>
      </div>

      <?php

         $sql = "SELECT * from history WHERE user_id=$id";
         if ($result = mysqli_query($db, $sql)) {
            $total = mysqli_num_rows( $result );
         }
         $sql = "SELECT * from history WHERE user_id=$id AND status = 'Done'";
         if ($result = mysqli_query($db, $sql)) {
            $done = mysqli_num_rows( $result );
         }
         $sql = "SELECT * from history WHERE user_id=$id AND status = 'In progress'";
         if ($result = mysqli_query($db, $sql)) {
            $inProgress = mysqli_num_rows( $result );
         }
         $sql = "SELECT * from history WHERE user_id=$id AND status = 'Not completed'";
         if ($result = mysqli_query($db, $sql)) {
            $notCompleted = mysqli_num_rows( $result );
         }
        $dataStatusPie = array(
          array("label" => "Done", "y" => $done/$total),
          array("label" => "In progress", "y" => $inProgress/$total),
          array("label" => "Not completed", "y" => $notCompleted/$total)
        );


        $sql = "SELECT id, weight, date FROM weights WHERE user_id=$id ORDER BY id ASC LIMIT 10";
        $weightResults = $db->query($sql);
        if ($weightResults->num_rows > 0) {
        $dataWeightChart = array();
          while ($row = $weightResults->fetch_assoc()) {
            array_push($dataWeightChart, array("y" => $row['weight'],"label" => $row['date']));
          }
        } else {
          echo "0 results";
        }

        // $sql = "SELECT * FROM history WHERE user_id=$id ORDER BY date ACS";
        // $weightResults = $db->query($sql);
        // if ($weightResults->num_rows > 0) {
        // // output data of each row
        // $lineDataPoints = array();
        //   while ($row = $weightResults->fetch_assoc()) {
        //     array_push($lineDataPoints, array("x" => $row['date'],"y" => $row['date']));
        //   }
        // } else {
        //   echo "0 results";
        // }
        $sql = "SELECT * from history WHERE user_id=$id";
        if ($result = mysqli_query($db, $sql)) {
           $total = mysqli_num_rows( $result );
        }

        $sql = "SELECT * FROM exercises";
            $exerciseResults = $db->query($sql);
            $exerciseDict = []; 
            if ($exerciseResults->num_rows > 0) {
              while ($row = $exerciseResults->fetch_assoc()) {
                $exerciseDict[$row['id']] = [$row['name'], $row['image_link']];
              }
            }

        $sql = "SELECT date, COUNT(*) as count from history WHERE user_id=$id GROUP BY date";
        $result = $db->query($sql);
          if ($result->num_rows > 0) {
            $lineDataPoints = array();
            while ($row = $result->fetch_assoc()) {
              array_push($lineDataPoints, array("label" => $row['date'], "y" => $row['count']));
            }
          } else {
            echo "0 results";
          }



        $sql = "SELECT * from history WHERE user_id=$id";
        if ($result = mysqli_query($db, $sql)) {
           $total = mysqli_num_rows( $result );
        }

        $sql = "SELECT * FROM exercises";
            $exerciseResults = $db->query($sql);
            $exerciseDict = []; 
            if ($exerciseResults->num_rows > 0) {
              while ($row = $exerciseResults->fetch_assoc()) {
                $exerciseDict[$row['id']] = [$row['name'], $row['image_link']];
              }
            }


        $sql = "SELECT exercise_id, COUNT(*) as count from history WHERE user_id=$id GROUP BY exercise_id";
        $result = $db->query($sql);
          if ($result->num_rows > 0) {
            $dataExercisePie = array();
            while ($row = $result->fetch_assoc()) {
              array_push($dataExercisePie, array("label" => $exerciseDict[$row['exercise_id']][0], "y" => $row['count']/$total));
            }
          } else {
            echo "0 results";
          }

      ?>
      <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
      <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

      <script>
        window.onload = function() {

          function setVisibility() {
            if ($('#view').val() !== "-1") {
              $('#statusText').text("Copy");
              $('.status').css("background-color", "white");
            } else {
              $('#copyButton').hide();
            }
          }
          setVisibility();
          var chart2 = new CanvasJS.Chart("statusPie", {
            backgroundColor: "#f3f8f2",
            theme: "light2",
            animationEnabled: true,
            title: {
              text: "Status of exercises"
            },
            data: [{
              type: "pie",
              indexLabel: "{y}",
              yValueFormatString: "#,##0.00\"%\"",
              indexLabelPlacement: "inside",
              indexLabelFontColor: "#36454F",
              indexLabelFontSize: 18,
              indexLabelFontWeight: "bolder",
              showInLegend: true,
              legendText: "{label}",
              dataPoints: <?php echo json_encode($dataStatusPie, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart2.render();

          var chart3 = new CanvasJS.Chart("weightChart", {
            backgroundColor: "#dee2d6",
            animationEnabled: true,
            title: {
              text: "Weight per dates"
            },
            axisY: {
              title: "Weight in kilograms",
              includeZero: true,
              prefix: "",
              suffix: "kg"
            },
            data: [{
              type: "bar",
              yValueFormatString: "#,##0.00",
              indexLabel: "{y}",
              indexLabelPlacement: "inside",
              indexLabelFontWeight: "bolder",
              indexLabelFontColor: "white",
              dataPoints: <?php echo json_encode($dataWeightChart, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart3.render();

          var chart = new CanvasJS.Chart("exercisesPie", {
          animationEnabled: true,
          backgroundColor: "transparent",
          title: {
            text: "Percentage of Exercises Done"
          },
          subtitles: [{
            text: ""
          }],
          data: [{
            type: "pie",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: <?php echo json_encode($dataExercisePie, JSON_NUMERIC_CHECK); ?>
          }]
          });
          chart.render();


          var chart = new CanvasJS.Chart("lineChartExercises", {
            backgroundColor: "#dee2d6",
            title: {
              text: "Number of exercises in each date"
            },
            axisY: {
              title: "Number of exercises"
            },
            data: [{
              type: "line",
              dataPoints: <?php echo json_encode($lineDataPoints, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart.render();
          
        }
      </script>

      <!--this is the first div of "Weights" tab-->

      <div id="pieChart" class="row justify-content-md-center" style="margin:20px; ">
        <div class="col-sm-6" id="statusPie" style="height:350px;"></div>
        <div id="colr_status" class="col-sm-6 text-center">
          Your Statistics
          <div class="container-fluid">
            <div class="row justify-content-center">
              <div id="info_div" class="col-sm-5" style="font-size:20px;">
                Done
                <?php
                  $sql = "SELECT * from history WHERE user_id=$id AND status = 'Done'";
                  if ($result = mysqli_query($db, $sql)) {
                      $rowcount = mysqli_num_rows( $result );
                      echo '<h4>';
                      echo $rowcount;
                      echo '</h4>';
                  }
                ?>
                
              </div>
              <div id="info_div" class="col-sm-5" style="font-size:20px;">
                In progress
                <?php
                  $sql = "SELECT * from history WHERE user_id=$id AND status = 'In progress'";
                  if ($result = mysqli_query($db, $sql)) {
                      $rowcount = mysqli_num_rows( $result );
                      echo '<h4>';
                      echo $rowcount;
                      echo '</h4>';
                  }
                ?>
              </div>
            </div>

            <div class="row justify-content-md-center">
              <div id="info_div" class="col-sm-5" style="font-size:20px;">
                Not completed
                <?php
                  $sql = "SELECT * from history WHERE user_id=$id AND status = 'Not completed'";
                  if ($result = mysqli_query($db, $sql)) {
                      $rowcount = mysqli_num_rows( $result );
                      echo '<h4>';
                      echo $rowcount;
                      echo '</h4>';
                  }

                    $db->close();
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!--this is the right side of "Exercises" tab-->

      <div id="lineChart" class="row justify-content-md-center" style="margin:20px; padding:20px;">
        <div class="col-sm-11" id="lineChartExercises" style="height:350px;"></div>
      </div>


      <div id="barChart" class="row justify-content-md-center" style="margin:20px; padding:20px;">
        <div class="col-sm-11" id="exercisesPie" style="height:350px;"></div>
      </div>


      <!--this is the first big div of "Weights" tab-->
      <div id="weight_graph" class="row container justify-content-center" style="margin:20px; padding:20px;">
        <div id="weightChart" class="col-sm-11" style="height: 400px;"></div>
      </div>

    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


  <script>
    function goToProfilePage() {
      window.location.href = 'profile.php';
      return false;
    }

    var exercisesToCopy = []

    function copyExercise(id) {
      var selectorID = "#" + id.toString();
      if ($('#view').val() !== "-1") {
        // console.log(id);
        if ($(selectorID).css("background-color") === 'rgb(50, 205, 50)') {
          $(selectorID).css("background-color", "white");
          const index = exercisesToCopy.indexOf(id);
          if (index > -1) {
            exercisesToCopy.splice(index, 1);
          }
        } else {
          $(selectorID).css("background-color", "#32cd32");
          exercisesToCopy.push(id);
        }
      } else {
        let color = $(selectorID).css("background-color");
        if(color === 'rgb(50, 205, 50)'){
          $(selectorID).css("background-color", "#FF0000");
          updateStatusDB(0, id);
        } else if (color === 'rgb(255, 0, 0)'){
          $(selectorID).css("background-color", "#FFFF00");
          updateStatusDB(1, id);
        } else {
          $(selectorID).css("background-color", "#32CD32");
          updateStatusDB(2, id);
        }
      }
    }

    var statusValues = {
      0: "Not completed",
      1: "In progress",
      2: "Done"
    };

    function updateStatusDB(value, id){
      console.log(id)
      $.ajax({
          type: "POST",
          url: "db_manager.php",
          data: {function: "updateExercise", "id": id,
                "value": statusValues[value]},
          success: function(result){
            // alert(result)
            alert("Exercise has been updated");
          }
      });
    }

    function copyExercises() {
      var jsonString = JSON.stringify(exercisesToCopy);
      $.ajax({
        type: "POST",
        url: "db_manager.php",
        data: {
          data: jsonString,
          function: "copy",
          guest_id: $('#view').val()
        },
        cache: false,
        success: function(result) {
          alert(result);
        }
      });
    }

    $(document).ready(function() {
      $("#barChart").show();
      $("#historyRow").show();
      $("#exercisesPageHeadings").show();
      $("#lineChart").show();


      $("#weightsRow").hide();
      $("#weightPageHeadings").hide();
      $("#pieChart").hide();
      $("#weight_graph").hide();
    });

    $(document).ready(function() {
      $("#coll_slider").click(function() {
        $("#barChart").show();
        $("#historyRow").show();
        $("#exercisesPageHeadings").show();
        $("#lineChart").show();

        $("#weightsRow").hide();
        $("#weightPageHeadings").hide();
        $("#weight_graph").hide();
        $("#pieChart").hide();

        $("#colr_slider").css("background-color", "white");
        $("#coll_slider").css("background-color", "#EDE6F2");

      });
    });

    $(document).ready(function() {
      $("#coll_slider").hover(
        function() {
          $(this).css("background-color", "#CAB9D6");
        },
        function() {
          if ($("#pieChart").is(":visible")) {
            $(this).css("background-color", "white");
          } else {
            $(this).css("background-color", "#EDE6F2");
          }
        }
      );
    });

    $(document).ready(function() {
      $("#colr_slider").click(function() {
        $("#coll_slider").css("background-color", "white");
        $("#colr_slider").css("background-color", "#EDE6F2");
        $("#barChart").hide();
        $("#historyRow").hide();
        $("#exercisesPageHeadings").hide();
        $("#lineChart").hide();

        $("#weightsRow").show();
        $("#weightPageHeadings").show();
        $("#weight_graph").show();
        $("#pieChart").show();
      });
    });

    $(document).ready(function() {
      $("#colr_slider").hover(
        function() {
          $(this).css("background-color", "#CAB9D6");
        },
        function() {
          if ($("#weight_graph").is(":hidden")) {
            $(this).css("background-color", "white");
          } else {
            $(this).css("background-color", "#EDE6F2");
          }
        }
      );
    });

    function mouseOver(id){
      if ($('#view').val() === "-1") {
        let img = "Resources/close.png";
        let imgID = "#img" + id.toString();
        $(imgID).attr("src",img);
      }
    }

    function mouseOut(id, img){
      if ($('#view').val() === "-1") {
        let imgID = "#img" + id.toString();
        $(imgID).attr("src",img);
      }
    }

    function deleteExercise(id){
      if ($('#view').val() === "-1") {
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
  </script>
</body>

</html>