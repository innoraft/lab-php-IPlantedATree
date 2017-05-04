<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
$accessToken =  $_SESSION["facebook_access_token"];
$fb = new Facebook\Facebook([
    'app_id' => '1867029653544963',
  'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
  'default-graph_version' => 'v2.5'
  ]);

  try {
     $profile_request = $fb->get('/me?fields=name,id',$accessToken);
     $profile = $profile_request->getGraphNode()->asArray();
    $friends = $fb->get('/me/taggable_friends?fields=name,id',$accessToken); 
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
  $sql = "";
  for($i=0 ; $i<$totalFriends ; $i++){
    $friendID = $friends[$i]['id'];
    $link = "http://treeplant.com/visit.php?link=".$id.'_'.$friendID;
    if($i == 0)
      $sql = "INSERT INTO `invitation` values('$id','$friendID',0,'$link')";
    else
      $sql .= ",('$id','$friendID',0,'$link')";

    if($conn->query($sql)){}
      //echo "Successful insertion 2";
    else{}
      //echo "Unsuccessful insertion 2";
  }
  $conn->close();


/*getting friend name from temp access token*/
$friendID = $friends[0]['id'];


/* getting friend name from temp access token*/
  
  $count = 0;
  $friendIDs = '';
   
  // echo ' <input type="text" id="default" list="taggable_friends">';
  // echo '<datalist id="taggable_friends">';
  // echo ' <!--[if lte IE 9]><select data-datalist="taggable_friends"><![endif]-->';
  // while($count < $totalFriends){
  //   if($count == 0)
  //     $friendIDs =  $friends[$count]['id'].',';
  //   else if($count == $totalFriends-1)
  //     $friendIDs =  $friendIDs.$friends[$count]['id'];
  //   else
  //     $friendIDs =  $friendIDs.$friends[$count]['id'].',';

  //   echo '<option value="'.$friends[$count]['name'].'">'.$friends[$count]['name']."</option>";
    
$tagged_friends = $_GET['tagged_friends'];
$tagged_friends_length = strlen($tagged_friends);
$count = 0;
$count1 = 0;
while($count < $tagged_friends_length){
  if($tagged_friends[$count] != ','){
    //$_SESSION[$tagged_friends[$count]]['id'];

    if($count1 == 0)
      $friendIDs =  $_SESSION[$tagged_friends[$count]]['id'].',';
    else if($count1 == $tagged_friends_length-1)
      $friendIDs =  $_SESSION[$tagged_friends[$count]]['id'];
    else
      $friendIDs =  $_SESSION[$tagged_friends[$count]]['id'].',';
  }
  $count++;
}
var_dump($friendIDs);
  //   $count++;
  // }
  // echo ' <!--[if lte IE 9]></select><![endif]-->';
  // echo '</datalist>';
   $link = "http://treeplant123.com/homepage.php?link=".$id;
  $description = $_GET['description'];
  $description .= "<br>".$link;
  // $msg = ['message' => $description,'link' => $link ,'tags' => $friendIDs];
  $msg = ['message' => $description];
  //$photoToUpload = $_FILES['fileToUpload'];
  //echo $path;
  $data = ['source'=>$fb->fileToUpload($path),'message' => $description, 'link' => $link];
  //echo $path;
  // posting on facebook and tagging friend with it
// try {
//   // Returns a `Facebook\FacebookResponse` object
  
// } catch(Facebook\Exceptions\FacebookResponseException $e) {
//   echo 'Graph returned an error: ' . $e->getMessage();
//   exit;
// } catch(Facebook\Exceptions\FacebookSDKException $e) {
//   echo 'Facebook SDK returned an error: ' . $e->getMessage();
//   exit;
// }


/*post link begin*/
// $imgg = $fb->fileToUpload($path);
// $params = array(
//     'caption' => 'Some caption',
//     'description' => 'This is the fine, fine description.',
//     'from' => array('id' => $profile['id'], 'name' => $profile['name']),
//     'link' => 'http://treeplant123.com/profile.php',
//     'name' => 'Link Name Here'
//     //,    'picture' => $path
//   );
/*post link ends*/
var_dump($_GET['tagged_friends']);
  try{
$response = $fb->post('/me/feed', $msg,$accessToken);
$postPhotoRequest = $fb->post('me/photos',$data,$accessToken);
   // $postPhotoRequest = $fb->post('me/feed',$params,$accessToken); 
$graphNode = $response->getGraphNode();
$graphNodePhotoResponse = $postPhotoRequest->getGraphNode()->asArray();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
echo "<img src='".$path."'/>";
echo 'Posted with id: ' . $graphNode['id'];
echo '<br>Photo posted with ID : '.$graphNodePhotoResponse['id'];
// echo '<a href="' . htmlspecialchars($logoutUrl) . '">Logout</a>';
?>
<script src="scripts/js/datalist.polyfill.min.js"></script>
<script src="scripts/js/datalist.js"></script>