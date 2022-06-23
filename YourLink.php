<?php     
include 'config.php';
session_start();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="YourLink.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </head>
  <body>
  <input type="hidden" id="view" value="<?php print $_SESSION['guest_id'] ?>">

    <div id="main">
      <h1>Your Link</h1>
      <?php 
  

      $id = $_SESSION['id'];
      $sql = "SELECT custom_id FROM users WHERE id=$id";
      $result = $db->query($sql);
      // print_r($result);

      if ($result->num_rows > 0 || $result->num_rows > 1) {
          $row = $result->fetch_assoc();
          printID($row['custom_id']);
      } else {
        echo "Error";
      }
      
      $db->close();

      function printID($id){
        print '<h2>';
        print $id;
        print '</h2>';
      };
      ?>
      <form action="profile.php" method="post">
        <button  
          id='b'
          type="button"
          onclick="goToProfile()">
          Back
        </button>
        <!-- <input type="hidden" name="id" value="<?php print $id?>"> -->
      </form>

      <!-- <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
      </form> -->
      <input id="imgInput" onchange="submitForm()" type="text"></input>
    </div>
  </body>
</html>
</form>

<script>
  function goToProfile(){
    window.location.href = 'profile.php';
    return false;
  }
  function submitForm(){
    console.log($('#view').val())
    if($('#view').val() === "-1"){
        var img = $('#imgInput').val();
        // console.log(parseFloat(height))
        if(img !=='' || img!=null)
        {
            // Ajax code to submit form.
            $.ajax({
                type: "POST",
                url: "db_manager.php",
                data: {'function': 'updateImage','img': img},
                success: function(result){
                    alert(result)
                    alert("Your image has been updated");
                }
            });
        }
        return false;
      }
  }
</script>

