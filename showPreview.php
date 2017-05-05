<?php
include('saveContent.php');

require_once __DIR__ . '/vendor/autoload.php';
$accessToken =  $_SESSION["facebook_access_token"];


$fb = new Facebook\Facebook([
    'app_id' => '1867029653544963',
  'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
  'default-graph_version' => 'v2.5'
  ]);

try {
  $response = $fb->get('/me?fields=name,id,first_name,last_name,email',$accessToken);
  $requestPicture = $fb->get('me/picture?redirect=false&height=300&width=300',$accessToken);
  $picture = $requestPicture->getGraphUser();
  $userNode = $response->getGraphUser();
  $friends = $fb->get('/me/taggable_friends?fields=name,id,picture.width(50)',$accessToken); 
  $friends = $friends->getGraphEdge()->asArray();  
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$_SESSION['id'] = $userNode->getId();
$_SESSION['friends'] = $friends;
$totalFriends = count($friends);
$count = 0;
$friendIDs = '';


?>

<!DOCTYPE html>
<html>
<head>
  <title>TreePlant123</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/js/homepage.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Alegreya:400,400i,700,700i" rel="stylesheet">
    <script type="text/javascript">
    </script>
    <script type="text/javascript">
      var tagged_friends = '';
    </script>
    <script type="text/javascript" src="scripts/js/showPreview.js"></script>
</head>
<body>


<div class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a href="#" class="navbar-brand">Treeplant</a>
      <button class="navbar-toggle" data-toggle="collapse" data-target=".myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Home</a></li>
        <li class="active"><a href="#">Profile</a></li>
        <li><a href="#">XYZ</a></li>
        <li><a href="#">About Us</a></li>
      </ul>
    </div>
  </div>
</div>

<div  class="row" id="profile_row">
  <div class="col-md-2 border" style="background-color: #52b3d9;height: 100vh;padding-right: 0px;">
    <?php echo "<img id='profile_picture' class='outset' src='".$picture['url']."'/>";
          echo 'Hello ' . $userNode->getName() . '!';
    ?>
  </div>
  <div class="col-md-10 border" style="background-color: #34495e;color:white;height: 100vh;">
    <div id="profile_heading">Ready to POST?</div>
    <form id="uploadForm" action="upload.php" method="POST"> <!-- Upload form begins-->
    <div id="imageContainer">
      <img id="imagePreview" name="imagePreview" src="<?php echo $target_file; ?>" alt="your image" width="400" height="300" /><br>
    </div>
    <div id="profile_fileUploadButtons">
      <label for="message" style="color:#fff;">Image Description</label>
      <textarea style="height: 50px;width:70%;margin:0 auto;resize: none;color:#000;background-color: #fff;text-align: left;" id="description" name="description"><?php echo $description; ?></textarea><br>
      <label id="lbl_tag_friends">Tag friends</label>
<?php
   
echo ' <input type="text" id="friends" list="taggable_friends">';
echo '<datalist id="taggable_friends">';
echo ' <!--[if lte IE 9]><select data-datalist="taggable_friends"><![endif]-->';
while($count < $totalFriends){
  if($count == 0)
      $friendIDs =  $friends[$count]['id'].',';
  else if($count == $totalFriends-1)
      $friendIDs =  $friendIDs.$friends[$count]['id'];
  else
      $friendIDs =  $friendIDs.$friends[$count]['id'].',';

  // echo '<option id="'.$count.'" value="'.$friends[$count]['name'].'">'.$friends[$count]['name']."</option>";

  echo '<option id="'.$count.'" value="'.$friends[$count]['name'].'"><img src="'.$friends[$count]['picture']['url'].'">'.$friends[$count]['name']."</option>";   
    

  $count++;
}
echo ' <!--[if lte IE 9]></select><![endif]-->';
echo '</datalist>';

                                                                     
?>
      <br>
      <input type="hidden" id="tagged_friends" name="tagged_friends" value="X">
      <input id="submit" type="submit" value="Upload Image" name="submit">
    </div>
    </form>
    <button style="color:#000;" id="btn_tag_friends">Tag friends</button>
    <!-- Upload form ends-->
  </div>
</div>
<!-- <script type="text/javascript">
$(document).ready(function() {
  
  $('#friends').on('input', function() {
    var userText = $(this).val();

    $("#taggable_friends").find("option").each(function() {
      if ($(this).val() == userText) {
        var description = $('#description').val();
        var thisVal = $(this).val();
        description += "@"+thisVal;
        $('#description').val(description);
        $('#friends').val('');
        tagged_friends  += ',' + ($(this).attr('id'));
        this.remove();
        //alert("Make Ajax call here.");
      }
    })
  })
});


  $("input[type='reset']").on("click", function(event){
        event.preventDefault();
        // stops the form from resetting after this function
        $(this).closest('form').get(0).reset();
        // resets the form before continuing the function
        $('#imagePreview').attr('src','assets/images/placeholder.jpg');
        $('#submit').attr('disabled','true');
        // executes after the form has been reset
    });

  $("input[type='submit']").on("click", function(event){
    // stops the form from resetting after this function
    if((document.getElementById("imagePreview").src).includes('placeholder.jpg')){
        alert('You need to select an image first!');
        event.preventDefault();
    }
    // executes after the form has been reset
    else{
        // console.log(document.getElementById("imagePreview").src);
        // console.log(document.getElementById("imagePreview").src == "http://treeplant123.com/assets/images/placeholder.jpg");
        //$('#tagged_friends').html(tagged_friends);
        $('#tagged_friends').val(tagged_friends);
        // console.log($('#tagged_friends').val());
        // alert('OK');
    }
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
            
        reader.onload = function (e) {
        $('#imagePreview').attr('src', e.target.result);
        document.getElementById('submit').disabled = false;
      }
            
      reader.readAsDataURL(input.files[0]);
      /*input.files[0].name; //displays the filename*/
    }
  }

  $("#fileToUpload").change(function(){
          readURL(this);
  });
</script>
 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

