<?php
include 'config.php';

session_start();
$_SESSION['id'] = 1;
$id = $_SESSION['id'];


$sql = "SELECT * FROM weights WHERE user_id=$id ORDER BY id DESC LIMIT 1 ";
$result = $db->query($sql);

$weightRow = $result->fetch_assoc();

$sql = "SELECT * FROM users WHERE id=$id";
$result = $db->query($sql);
$userRow = $result->fetch_assoc();

// echo $_REQUEST['guest_id'];
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
  <input type="hidden" id="view" value="<?php print $_REQUEST['guest_id'] ?>">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <div class="row">

    <div id="coll" class="container-fluid col-5">
      <div class="row align-items-center justify-content-center">
        <div class="col-sm-2">
          <button class="btn" onclick="goToProfilePage()"><i class="fa fa-home"> Profile</i></button>
        </div>
        <div class="mainHeading col-sm-9 text-center">
          History
        </div>
      </div>

      <div id="exercisesPageHeadings" class="row justify-content-center">
        <div class="col-sm-4"></div>
        <div class="col-sm-5 headingText">Exercise</div>
        <div class="col-sm-2 headingText">Status</div>
      </div>

      <div id="weightPageHeadings" class="row justify-content-center">
        <div class="col-sm-4"></div>
        <div class="col-sm-4 headingText">Weight</div>
        <div class="col-sm-3 headingText">Date</div>
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
                            history WHERE user_id=$id ORDER BY id DESC LIMIT 6";
            $historyResults = $db->query($sql);
            if ($historyResults->num_rows > 0) {
              // output data of each row
              while ($row = $historyResults->fetch_assoc()) {
                printImage($exerciseDict[$row['exercise_id']][1]);
                printName($exerciseDict[$row['exercise_id']][0]);
                printStatus($row['status'], $row['id']);
              }
            } else {
              echo "0 results";
            }
            $db->close();

            function printImage($img)
            {
              echo '<div class="col-sm-2 w-90">';
              echo '<img id="exerciseImage" src="';
              echo $img;
              echo '"></img>';
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

            <!-- TODO php for listing all weights -->


            <?php
            //     $sql2 = "SELECT * FROM exercises";
            //     $exerciseResults2 = $db->query($sql2);
            //     $exerciseDict2 = [];
            //     if ($exerciseResults2->num_rows > 0) {
            //         // output data of each row
            //         while($row2 = $exerciseResults2->fetch_assoc()) {
            //             $exerciseDict2[$row2['id']] = [$row2['name'], $row2['image_link']];
            //         }
            //         }

            //     $sql2 = "SELECT id, user_id, weight, date FROM
            //     weights WHERE user_id=$id ORDER BY id DESC LIMIT 6";
            //     $historyResults2 = $db->query($sql2);
            //     if ($historyResults2->num_rows > 0) {
            //     // output data of each row
            //         while($row2 = $historyResults2->fetch_assoc()) {
            //         printImage2($exerciseDict2[$row2['exercise_id']][1]);
            //         printWeight($row2['weight']);
            //         printDate($row2['date']);
            //         }
            //     } else {
            //         echo "0 results";
            //     }
            //     $db->close();

            //     function printImage2($img){

            //         echo '<div class="col-sm-3 w-90">';
            //         echo '<img id="exerciseImage" src="';
            //         echo $img;
            //         echo '"></img>';
            //         echo '</div>';

            //     }

            //     function printWeight($weight){
            //       echo '<div class="col-md-6 historyText">';
            //       echo '<p class="exerciseInfo">';
            //       echo $weight;
            //       echo '</p>';
            //       echo '</div>';
            //   }

            //   function printDate($date){
            //     echo '<div class="col-md-6 historyText">';
            //     echo '<p class="exerciseInfo">';
            //     echo $date;
            //     echo '</p>';
            //     echo '</div>';
            //   }


            // 
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

      <!--this is the first big div of "Exercises" tab-->
      <?php

      $dataPoints2 = array(
        array("label" => "Done", "y" => 51.7),
        array("label" => "In progress", "y" => 26.6),
        array("label" => "Not completed", "y" => 21.7)
      );

      $dataPoints3 = array(
        array("y" => 7, "label" => "March"),
        array("y" => 12, "label" => "April"),
        array("y" => 28, "label" => "May"),
        array("y" => 18, "label" => "June"),
        array("y" => 41, "label" => "July")
      );

      $dataPoints10 = array(
        array("label" => "Single", "y" => 13),
        array("label" => "Married", "y" => 21),
        array("label" => "Married and have Kids", "y" => 24),
        array("label" => "Single Parent", "y" => 15)
      );

      $dataPoints20 = array(
        array("label" => "Single", "y" => 6),
        array("label" => "Married", "y" => 12),
        array("label" => "Married and have Kids", "y" => 13),
        array("label" => "Single Parent", "y" => 7)
      );

      $dataPoints30 = array(
        array("label" => "Single", "y" => 5),
        array("label" => "Married", "y" => 9),
        array("label" => "Married and have Kids", "y" => 10),
        array("label" => "Single Parent", "y" => 6)
      );

      $dataPoints4 = array(
        array("label" => "Single", "y" => 3),
        array("label" => "Married", "y" => 8),
        array("label" => "Married and have Kids", "y" => 9),
        array("label" => "Single Parent", "y" => 3)
      );

      $dataPoints5 = array(
        array("label" => "Single", "y" => 3),
        array("label" => "Married", "y" => 5),
        array("label" => "Married and have Kids", "y" => 4),
        array("label" => "Single Parent", "y" => 2)
      );

      $dataPoints6 = array(
        array("label" => "Single", "y" => 2),
        array("label" => "Married", "y" => 3),
        array("label" => "Married and have Kids", "y" => 4),
        array("label" => "Single Parent", "y" => 2)
      );

      $dataPoints7 = array(
        array("label" => "Single", "y" => 5),
        array("label" => "Married", "y" => 9),
        array("label" => "Married and have Kids", "y" => 9),
        array("label" => "Single Parent", "y" => 5)
      );

      $lineDataPoints = array(
        array("x" => 946665000000, "y" => 3289000),
        array("x" => 978287400000, "y" => 3830000),
        array("x" => 1009823400000, "y" => 2009000),
        array("x" => 1041359400000, "y" => 2840000),
        array("x" => 1072895400000, "y" => 2396000),
        array("x" => 1104517800000, "y" => 1613000),
        array("x" => 1136053800000, "y" => 1821000),
        array("x" => 1167589800000, "y" => 2000000),
        array("x" => 1199125800000, "y" => 1397000),
        array("x" => 1230748200000, "y" => 2506000),
        array("x" => 1262284200000, "y" => 6704000),
        array("x" => 1293820200000, "y" => 5704000),
        array("x" => 1325356200000, "y" => 4009000),
        array("x" => 1356978600000, "y" => 3026000),
        array("x" => 1388514600000, "y" => 2394000),
        array("x" => 1420050600000, "y" => 1872000),
        array("x" => 1451586600000, "y" => 2140000)
      );

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

          var chart2 = new CanvasJS.Chart("chartContainer2", {
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
              dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart2.render();

          var chart3 = new CanvasJS.Chart("chartContainer3", {
            backgroundColor: "#dee2d6",
            animationEnabled: true,
            title: {
              text: "Weight per dates of exercises"
            },
            axisY: {
              title: "Weight in kilograms",
              includeZero: true,
              prefix: "",
              suffix: "kg"
            },
            data: [{
              type: "bar",
              yValueFormatString: "#,##0",
              indexLabel: "{y}",
              indexLabelPlacement: "inside",
              indexLabelFontWeight: "bolder",
              indexLabelFontColor: "white",
              dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart3.render();


          var chart4 = new CanvasJS.Chart("stackedChart", {
            title: {
              text: "Spending of Money Based on Household Composition"
            },
            theme: "light2",
            animationEnabled: true,
            toolTip: {
              shared: true,
              reversed: true
            },
            axisY: {
              suffix: "%"
            },
            data: [{
              type: "stackedColumn100",
              name: "Housing",
              showInLegend: true,
              yValueFormatString: "$#,##0 K",
              dataPoints: <?php echo json_encode($dataPoints10, JSON_NUMERIC_CHECK); ?>
            }, {
              type: "stackedColumn100",
              name: "Transportation",
              showInLegend: true,
              yValueFormatString: "$#,##0 K",
              dataPoints: <?php echo json_encode($dataPoints20, JSON_NUMERIC_CHECK); ?>
            }, {
              type: "stackedColumn100",
              name: "Food",
              showInLegend: true,
              yValueFormatString: "$#,##0 K",
              dataPoints: <?php echo json_encode($dataPoints30, JSON_NUMERIC_CHECK); ?>
            }, {
              type: "stackedColumn100",
              name: "Insurance and Pastion",
              showInLegend: true,
              yValueFormatString: "$#,##0 K",
              dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
            }, {
              type: "stackedColumn100",
              name: "Healthcare",
              showInLegend: true,
              yValueFormatString: "$#,##0 K",
              dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
            }, {
              type: "stackedColumn100",
              name: "Entertainment",
              showInLegend: true,
              yValueFormatString: "$#,##0 K",
              dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
            }, {
              type: "stackedColumn100",
              name: "Other",
              showInLegend: true,
              yValueFormatString: "$#,##0 K",
              dataPoints: <?php echo json_encode($dataPoints7, JSON_NUMERIC_CHECK); ?>
            }]
          });

          chart4.render();

          var chart5 = new CanvasJS.Chart("lineChartExercises", {
            animationEnabled: true,
            title: {
              text: "Company Revenue by Year"
            },
            axisY: {
              title: "Revenue in USD",
              valueFormatString: "#0,,.",
              suffix: "mn",
              prefix: "$"
            },
            data: [{
              type: "spline",
              markerSize: 5,
              xValueFormatString: "YYYY",
              yValueFormatString: "$#,##0.##",
              xValueType: "dateTime",
              dataPoints: <?php echo json_encode($lineDataPoints, JSON_NUMERIC_CHECK); ?>
            }]
          });

          chart5.render();
        }
      </script>

      <!--this is the first div of "Weights" tab-->

      <div id="pieChart" class="row justify-content-md-center" style="margin:20px; ">
        <div class="col-sm-6" id="chartContainer2" style="height:350px;"></div>
        <div id="colr_status" class="col-sm-6 text-center">
          Your Statistics
          <div class="container-fluid">
            <div class="row justify-content-center">
              <div id="info_div" class="col-sm-5" style="font-size:20px;">
                Done
                <h4>1100</h4>
                <!--TODO: Here calculate number of exercises-->
              </div>
              <div id="info_div" class="col-sm-5" style="font-size:20px;">
                In progress
                <h4>1100</h4>
                <!--TODO: Here calculate number of exercises-->
              </div>
            </div>
            <div class="row justify-content-md-center">
              <div id="info_div" class="col-sm-5" style="font-size:20px;">
                Not completed
                <h4>1100</h4>
                <!--TODO: Here calculate number of exercises-->
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
        <div class="col-sm-11" id="stackedChart" style="height:350px;"></div>
      </div>


      <!--This is the div showed when "choose exercise" is clicked-->
      <!--        <div id="about_exercise" class="row container-fluid justify-content-between">
            <div id="info_about_exercise" class="col-sm-8">
                <div class="container" style="margin-top:40px;">
                    <div class="row">
                        <div class="col-sm-4" id="info_div" style="margin-right:10px;">
                            Calories
                            <h4>1100</h4>
                            kcal
                        </div>
                        <div class="col-sm-4" id="info_div">
                            Time spent
                            <h4>4</h4>
                            minutes
                        </div>
                        <div class="w-100"></div>
                        <div class="col-sm-4" id="info_div" style="margin-right:10px;">
                            Effort grade
                            <h4>10/10</h4>
                        </div>
                        <div class="col-sm-4" id="info_div">
                            <div>Status</div>
                            <img id="load_char" src="Resources/round-chart.png" />
                        </div>
                    </div>
                </div>          
            </div>

            <div class="col-sm-4">
                <img id="pilates_img" alt="Responsive image" src="Resources/pilates.png" style="margin-top:20px; margin-right:20px;"/>
            </div>

        </div> -->



      <!--this is the last button div of "Exercises" tab-->
      <!-- <div  class="row justify-content-md-center">
            <div id="choose_exercise" class="col-sm-8">Choose exercise</div>
        </div>-->



      <!--this is the first big div of "Weights" tab-->
      <div id="weight_graph" class="row container justify-content-center" style="margin:20px; padding:20px;">
        <div id="chartContainer3" class="col-sm-11" style="height: 350px;"></div>
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
      if ($('#view').val() !== "-1") {
        var selectorID = "#" + id.toString();
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
        // console.log(selectorID);
        // console.log($(selectorID).css("background-color"))
        // console.log(exercisesToCopy)
      }
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

        $("#weightsRow").show();
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
  </script>
</body>

</html>