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
    <div id="main">
      <h1>Your Link</h1>
      <?php 
      include 'config.php';

      // print_r($_REQUEST);
      session_start(); 

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
      <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" id="file" name="filename" onchange="submitForm();">
        <input type="hidden" name="id" id="imageUploadID" value="<?php print $row['custom_id']?>">
      </form>
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
    var file_data = $('#file').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    var id = $("#imageUploadID").val();
    form_data.append('id', id);
    $.ajax({
        url: 'upload.php',
        dataType: 'text', // what to expect back from the server
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (response) {
            alert(response)

            // $('#msg').html(response); // display success response from the server
        },
        error: function (response) {
            // $('#msg').html(response); // display error response from the server
        }
    });
  }
</script>

