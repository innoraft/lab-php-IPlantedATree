<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
$accessToken =  $_SESSION["facebook_access_token"];
include('assets/config/fbCredentials.php');
var_dump($_GET['tagged_friends']);
  try {
     $profile_request = $fb->get('/me?fields=name,id',$accessToken);
     $profile = $profile_request->getGraphNode()->asArray();
    $friends = $fb->get('/me/taggable_friends?fields=name,id,limit=1000',$accessToken); 
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
  
  include('conn.php');
  $name = $profile['name'];
  $id = $profile['id'];
  $fileName = $_GET['fileName'];

  $path = "assets/uploads";
  $path .= "/".$fileName;
  $totalFriends = count($friends);
  
  $sql = "INSERT INTO `user` values('$name','$id','$path')";
  if($conn->query($sql)){}
    //echo "Successful insertion";
  else{}
    //echo "Unsuccessful insertion";
  $i = 0;

/*getting friend name from temp access token*/
$friendID = $friends[0]['id'];


/* getting friend name from temp access token*/
  
  $count = 0;
  $friendIDs = '';
    
$tagged_friends = $_GET['tagged_friends'];
$tagged_friends_length = strlen($tagged_friends);
$count = 0;
$count1 = 0;

while($count < $tagged_friends_length){
  if($tagged_friends[$count] != ','){
    //$_SESSION[$tagged_friends[$count]]['id'];
    echo "Tagged friends ".$tagged_friends[$count]."\n";
    if($count1 == 0)
      $friendIDs =  $_SESSION['friends'][$tagged_friends[$count]]['id'].',';
    else if($count1 == $tagged_friends_length-1)
      $friendIDs =  $friendIDs.$_SESSION['friends'][$tagged_friends[$count]]['id'];
    else
      $friendIDs =  $friendIDs.$_SESSION['friends'][$tagged_friends[$count]]['id'].',';

    $count1++;
  }
  $count++;
}

  $link = "http://".$_SERVER['SERVER_NAME']."/content.php?contentId=".$_SESSION['saveContentID'];
  $description = $_GET['description'];
  $tags = $friendIDs;
  $msg = ['message' => $description,'link' => $link,'description' => $description, 'caption' => 'Plant your trees with us' , 'tags' => $tags];
 

  try{
$response = $fb->post('/me/feed', $msg,$accessToken);
$graphNode = $response->getGraphNode();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

if(!isset($_SESSION['saveContentID'])){
  $graphNodeId = $graphNode['id'];
  $sql = "INSERT INTO `userContent` values('',$id,'$description','$path','$graphNodeId')";
  $conn->query($sql);
  mysqli_close($conn);
}
else{
  $date = new DateTime();

  $sql = "UPDATE `userContent` SET post_id='".$graphNode['id']."' ,timestamp=".$date->getTimestamp()." WHERE id=".$_SESSION['saveContentID'];
  if($conn->query($sql)){
    echo "Successful updation\n";
    $_SESSION['saveContentID'] = '';
    unset($_SESSION['saveContentID']);
  }
  else
    echo "Error : ".mysqli_error($conn)."\n";
  mysqli_close($conn);
}

header('location:http://'.$_SERVER['SERVER_NAME'].'/thankyou.php');

?>
