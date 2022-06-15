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

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>   

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />  
    <link rel="stylesheet" type="text/css" href="Project.css" />
  </head>
  
  <body>
  <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<div class="row">

    <div id = "coll" class="container-fluid col-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-sm-2">
                    <button class="btn" onclick="goToProfilePage()"><i class="fa fa-home"> Profile</i></button>
                </div>     
                <div class="mainHeading col-sm-9 text-center">
                    History
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-sm-5"></div>
                <div class="col-sm-4 headingText">Exercise</div>
                <div class="col-sm-3 headingText">Status</div>
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
                                while($row = $exerciseResults->fetch_assoc()) {
                                    $exerciseDict[$row['id']] = [$row['name'], $row['image_link']];
                                }
                                }

                            $sql = "SELECT id, exercise_id, location, people, status FROM
                            history WHERE user_id=$id ORDER BY id DESC LIMIT 6";
                            $historyResults = $db->query($sql);
                            if ($historyResults->num_rows > 0) {
                            // output data of each row
                                while($row = $historyResults->fetch_assoc()) {
                                printImage($exerciseDict[$row['exercise_id']][1]);
                                printName($exerciseDict[$row['exercise_id']][0]);
                                printStatus($row['status']);
                                }
                            } else {
                                echo "0 results";
                            }
                            $db->close();

                            function printImage($img){
                                echo '<div class="col-sm-3 w-90">';
                                echo '<img id="exerciseImage" src="';
                                echo $img;
                                echo '"></img>';
                                echo '</div>';

                            }

                            function printName($name){
                                echo '<div class="col-md-6 historyText">';
                                echo '<p class="exerciseInfo">';
                                echo $name;
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
                    </div>
                </div>

            </div>
    </div>

      <div class="container-fluid col-7">
            <div id="row" class="row justify-content-md-center">
                <div id="coll_slider" class="col col-sm-4">Exercises</div>
                <div id="colr_slider" class="col col-sm-4">Graphs</div>
            </div>

            <!--this is the first big div of "Exercises" tab-->
            <?php

                $dataPoints = array(
                    array("label"=> "Exercise1", "y"=> 60.0),
                    array("label"=> "Exercise2", "y"=> 6.5),
                    array("label"=> "Exercise3", "y"=> 4.6),
                    array("label"=> "Exercise4", "y"=> 2.4),
                    array("label"=> "Exercise5", "y"=> 1.9),
                    array("label"=> "Exercise6", "y"=> 1.8)
                );

                $dataPoints2 = array( 
                    array("label"=>"Done", "y"=>51.7),
                    array("label"=>"In progress", "y"=>26.6),
                    array("label"=>"Not completed", "y"=>21.7)
                );

                $dataPoints3 = array( 
                    array("y" => 7,"label" => "March" ),
                    array("y" => 12,"label" => "April" ),
                    array("y" => 28,"label" => "May" ),
                    array("y" => 18,"label" => "June" ),
                    array("y" => 41,"label" => "July" )
                );

            ?>
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

            <script>
                window.onload = function() {
                
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

                    var chart = new CanvasJS.Chart("chartContainer", {
                        backgroundColor: "#dee2d6",
                        animationEnabled: true,
                        theme: "light2",
                        title: {
                            text: "Calories per Exercise"
                        },
                        axisY: {
                            suffix: "",
                            scaleBreaks: {
                                autoCalculate: true
                            }
                        },
                        data: [{
                            type: "column",
                            yValueFormatString: "#,##0\"\"",
                            indexLabel: "{y}",
                            indexLabelPlacement: "inside",
                            indexLabelFontColor: "white",
                            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart.render();

                    var chart3 = new CanvasJS.Chart("chartContainer3", {
                        backgroundColor: "#dee2d6",
                        animationEnabled: true,
                        title:{
                            text: "Weight per dates of exercises"
                        },
                        axisY: {
                            title: "Weight in kilograms",
                            includeZero: true,
                            prefix: "",
                            suffix:  "kg"
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
            }
            </script>



            <div id="pieChart" class="row justify-content-md-center" style="margin:20px; ">
                <div class="col-sm-6" id="chartContainer2" style="height:350px;"></div>
                <div id="colr_status" class="col-sm-6 text-center">
                    Your Statistics
                    <div class="container-fluid">
                        <div class="row justify-content-center" >
                            <div id="info_div" class="col-sm-5" style="font-size:20px;">
                                Done                            
                                <h4>1100</h4> <!--TODO: Here calculate number of exercises-->
                            </div>
                            <div id="info_div" class="col-sm-5" style="font-size:20px;">
                                In progress
                                <h4>1100</h4><!--TODO: Here calculate number of exercises-->
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div id="info_div" class="col-sm-5" style="font-size:20px;">
                                Not completed
                                <h4>1100</h4><!--TODO: Here calculate number of exercises-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        <!--this is the second div of "Exercises" tab-->
        <div id="barChart" class="row justify-content-md-center" style="margin:20px; padding:20px;">
            <div class="col-sm-11" id="chartContainer" style="height:350px;"></div>
        </div>


        <!--This is the div showed when "choose exercise" is clicked-->
        <div id="about_exercise" class="row container-fluid justify-content-between">
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

        </div> 



        <!--this is the last button div of "Exercises" tab-->
        <div  class="row justify-content-md-center">
            <div id="choose_exercise" class="col-sm-8">Choose exercise</div>
        </div>

        <!--this is the first big div of "Graphs" tab-->



        <div id="main_graph" class="row container justify-content-center" style="margin:20px; padding:20px;">
            <div id="chartContainer3" class="col-sm-8" style="height: 300px;">
            </div>
        </div>

      </div>
    </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script>
        function goToProfilePage(){
            window.location.href = 'profile.php';
            return false;
        }

      $(document).ready(function () {
        $("#pieChart").show();
        $("#graph_number").show();
        $("#choose_exercise").show();
        $("#about_exercise").hide();
        $("#about_exercise_text").hide();
        $("#main_graph").hide();
        $("#graph_number_2").hide();
      });

      $(document).ready(function () {
        $("#coll_slider").click(function () {
          $("#pieChart").show();
          $("#barChart").show();
          $("#choose_exercise").show();
          $("#main_graph").hide();
          $("#graph_number_2").hide();
          $("#about_exercise").hide();
          $("#about_exercise_text").hide();
          $("#colr_slider").css("background-color", "white");
          $("#coll_slider").css("background-color", "#EDE6F2");
          $("#choose_exercise").text("Choose exercise");
        });
      });

      $(document).ready(function () {
        $("#coll_slider").hover(
          function () {
            $(this).css("background-color", "#CAB9D6");
          },
          function () {
            if ($("#pieChart").is(":hidden")) {
              $(this).css("background-color", "white");
            } else {
              $(this).css("background-color", "#EDE6F2");
            }
          }
        );
      });

      $(document).ready(function () {
        $("#colr_slider").click(function () {
          $("#coll_slider").css("background-color", "white");
          $("#colr_slider").css("background-color", "#EDE6F2");
          $("#pieChart").hide();
          $("#barChart").hide();
          $("#choose_exercise").hide();
          $("#about_exercise").hide();
          $("#about_exercise_text").hide();
          $("#main_graph").show();
          $("#graph_number_2").show();
        });
      });

      $(document).ready(function () {
        $("#colr_slider").hover(
          function () {
            $(this).css("background-color", "#CAB9D6");
          },
          function () {
            if ($("#main_graph").is(":hidden")) {
              //ovdje promijeni coll_pie u element sa druge stranice
              $(this).css("background-color", "white");
            } else {
              $(this).css("background-color", "#EDE6F2");
            }
          }
        );
      });

      $(document).ready(function () {
        $("#choose_exercise").hover(
          function () {
            $(this).css("background-color", "#CAB9D6");
          },
          function () {
            $(this).css("background-color", "#EDE6F2");
          }
        );
      });

      $(document).ready(function () {
        $("#choose_exercise").click(function () {
          if (this.innerHTML === "Choose exercise") {
            $("#pieChart").hide();
            $("#barChart").hide();
            $("#about_exercise").show();
            $("#about_exercise_text").show();
            this.innerHTML = "Exit exercise";
          } else {
            $("#pieChart").show();
            $("#barChart").show();
            $("#about_exercise").hide();
            $("#about_exercise_text").hide();
            this.innerHTML = "Choose exercise";
          }
        });
      });
    </script>
  </body>
</html>
