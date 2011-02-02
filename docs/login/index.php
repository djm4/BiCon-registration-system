<?php

require_once('../../inc/config.inc');

if (!isset($_POST['submit'])) {
  include( "login.inc" );
} else {
  // check for form input
  if (trim($_POST['id'] == '')) {
    die("ERROR: Please enter a valid OpenID.");    
  }
  
  // include files
  require_once "Auth/OpenID/Consumer.php";
  require_once "Auth/OpenID/FileStore.php";
  
  // start session (needed for YADIS)
  session_start();
  
  // create file storage area for OpenID data
  $store = new Auth_OpenID_FileStore($logfilepath . '/openid');
  
  // create OpenID consumer
  $consumer = new Auth_OpenID_Consumer($store);
  
  // begin sign-in process
  // create an authentication request to the OpenID provider
  $auth = $consumer->begin($_POST['id']);
  if (!$auth) {
    die("ERROR: Please enter a valid OpenID.");
  }
  
  // redirect to OpenID provider for authentication
  $url = $auth->redirectURL($http_host . '/', $http_host . '/login/return.php');
  header('Location: ' . $url);
}
?>    

