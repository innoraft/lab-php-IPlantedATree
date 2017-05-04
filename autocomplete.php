<?php
session_start();
?>
<?php

require_once __DIR__ . '/vendor/autoload.php';
$accessToken =  $_SESSION["facebook_access_token"];


$fb = new Facebook\Facebook([
    'app_id' => '1867029653544963',
  'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
  'default-graph_version' => 'v2.5'
  ]);

try {
  $friends = $fb->get('/me/taggable_friends?fields=name,id,picture.width(50),limit=5000',$accessToken); 
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

$totalFriends = count($friends);
$count = 0;
$friendIDs = '';
while($count < $totalFriends){
  if($count == 0)
      $friendIDs =  '"'.$friends[$count]['name'].'",';
  else if($count == $totalFriends-1)
      $friendIDs =  $friendIDs.'"'.$friends[$count]['name'].'"';
  else
      $friendIDs =  $friendIDs.'"'.$friends[$count]['name'].'",';

  $count++;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Autocomplete - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript">
    
  </script>
  <script>
  $( function() {
    var availableTags = [
      <?php echo $friendIDs;?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
</head>
<body>
 
<div class="ui-widget">
  <label for="tags">Tags: </label>
  <input id="tags">
</div>
 
 
</body>
</html>