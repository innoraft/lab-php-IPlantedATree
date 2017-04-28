<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
$fb = new Facebook\Facebook([
    'app_id' => '1867029653544963',
  'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
  'default-graph_version' => 'v2.5'
  ]);
$helper = $fb->getRedirectLoginHelper();
$accessToken = $_SESSION['facebook_access_token'];
try {
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


  $totalFriends = count($friends);
//changes
  $count = 0;
  $friendIDs = '';
   $tags = array();
   $tagsFinal = array();
    $tagsFinal[0]['tag_text'] = 'Me';
    $tagsFinal[0]['tag_uid'] = '123';
    $tagsFinal[0]['tags'] = $tags;
    $tagsFinal[0]['x'] = 0;
    $tagsFinal[0]['y'] = 0;
  echo ' <input type="text" id="default" list="taggable_friends">';
  echo '<datalist id="taggable_friends">';
  echo ' <!--[if lte IE 9]><select data-datalist="taggable_friends"><![endif]-->';
  while($count < $totalFriends){
    // if($count == 0){
    // 	$tags[0] = {'x':0,'y':0,'tag_uid':$friends[$count]['id'],'tag_text':$friends[$count]['name']}
    // 	//$tags = '[{x:0,y:0,tag_uid:'.$friends[$count]['id'].',tag_text:'.$friends[$count]['name'].'},';
    //  // $friendIDs =  $friends[$count]['id'].',';
    // }
    // else if($count == $totalFriends-1){
    // 	$tags = '[{x:0,y:0,tag_uid:'.$friends[$count]['id'].',tag_text:'.$friends[$count]['name'].'}]';
    //   //$friendIDs =  $friendIDs.$friends[$count]['id'];
    // }
    // else{
    // 	$tags = '{x:0,y:0,tag_uid:'.$friends[$count]['id'].',tag_text:'.$friends[$count]['name'].'},';
    //   //$friendIDs =  $friendIDs.$friends[$count]['id'].',';
    // $tags[$count] = {'x':0,'y':0,'tag_uid':$friends[$count]['id'],'tag_text':$friends[$count]['name']};
    $tags[$count]['x'] = 0;
    $tags[$count]['y'] = 0;
    $tags[$count]['tag_uid'] = $friends[$count]['id'];
    $tags[$count]['tag_text'] = $friends[$count]['name'];
    $count++;
    

    echo '<option value="'.$friends[$count]['name'].'">'.$friends[$count]['name']."</option>";
    

    $count++;
  }
  echo ' <!--[if lte IE 9]></select><![endif]-->';
  echo '</datalist>';
 
var_dump($friendIDs);
	try {
		// message must come from the user-end
		$data = ['source' => $fb->fileToUpload('http://treeplant123.com/assets/uploads/110799672811141prof_pic.jpg'), 'caption' => 'my photo 2',
		
		];
		$request = $fb->post('/me/photos', $data,$accessToken);
		$response = $request->getGraphNode()->asArray();

		echo $response['id'];
		$request = $fb->post('/'.$response['id'].'/tags',$tagsFinal,$accessToken);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	// echo $response['id'];



  	// Now you can redirect to another page and use the
  	// access token from $_SESSION['facebook_access_token']
