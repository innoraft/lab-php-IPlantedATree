<?php
#Steps : 
	# 1. Installation 
		#a. Start session
		session_start();
		#b. Include the autoload file
		require_once __DIR__ . '/vendor/autoload.php';
		#c. Facebook object with parameters\
		$fb = new Facebook\Facebook([
			'app_id' => '1867029653544963',
			'app_secret' => 'ab7e90234d0bb4fbb27d160fb93a4479',
			'default-graph_version' => 'v2.5'
		]);
		$redirect = 'http://www.treeplant123.com/callback.php';
	#2. Base Code
		$helper = $fb->getRedirectLoginHelper();
		try{
			$access_token = $helper->getAccessToken();	
		}catch(Facebook\Exceptions\FacebookREsponseException $e){
			//when graph returns an error
			echo 'Graph returned an error: '.$e->getMessage();
			exit;
		}catch(Facebook\Exceptions\FacebookSDKException $e){
			//When validation fails or other local issues
			echo 'Facebook SDK returned an error: '.$e->getMessage();
			exit;
		}
		#a. Print login url if no access code
		if(!isset($access_token)){
			$permission = ['email','publish_actions','user_about_me','user_friends','user_posts'];
			$loginurl = $helper->getLoginURL($redirect,$permission);
			echo "<a href='".$loginurl."'>Login with Facebook</a>";
		}
		#b. Else retrieve the data
		else{
			// $fb->setDefaultAccessToken($access_token);
			// $response = $fb->get('/me?fields=email,name');
			// $usernode = $response->getGraphUser();

			// echo "Name : ".$usernode->getName().'<br>';
			// echo "User ID: ".$usernode->getId().'<br>';
			// echo 'Email: ' . $usernode->getProperty('email').'<br><br>';

			// $image = 'https://graph.facebook.com/'.$usernode->getId().'/picture?width=200';
			// echo "Picture<br>";
			// echo "<img src='$image' /><br><br>";
			$fb->setDefaultAccessToken($access_token);
			$str = "/me/feed?message=Hi&access_token=".$access_token;
			$response = $fb->get($str);

			//	echo $response;
			//$usernode = $response->getGraphUser();

			// echo "Name : ".$usernode->getName().'<br>';
			// echo "User ID: ".$usernode->getId().'<br>';
			// echo 'Email: ' . $usernode->getProperty('email').'<br><br>';

			// $image = 'https://graph.facebook.com/'.$usernode->getId().'/picture?width=200';
			// echo "Picture<br>";
			// echo "<img src='$image' /><br><br>";
		}

?>