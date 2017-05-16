<?php
session_start();?>
<html>
<head>
  <title>Treeplant</title>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
<?php
//$state = $_SESSION['state'] = md5(uniqid(rand(), TRUE));
require_once __DIR__ . '/vendor/autoload.php';
include('assets/config/fbCredentials.php');

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (!isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}
else{
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;
  $_SESSION['logoutUrl'] = $helper->getLogoutUrl($accessToken,'http://treeplant123.com/index.php'); 
  header('location:http://treeplant123.com/profile.php');
  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
}

?>
</body>
</html>
