<?php
// include files
require_once "Auth/OpenID/Consumer.php";
require_once "Auth/OpenID/FileStore.php";

// start session (needed for YADIS)
session_start();

// create file storage area for OpenID data
$store = new Auth_OpenID_FileStore('/usr/local/web/secure.10icb.org/run/openid');

// create OpenID consumer
// read response from OpenID provider
$consumer = new Auth_OpenID_Consumer($store);
$response = $consumer->complete('https://secure.10icb.org/login/return.php');

// set session variable depending on authentication result
if ($response->status == Auth_OpenID_SUCCESS) {
  $_SESSION['OPENID_AUTH'] = true;
  $openid = $response->getDisplayIdentifier();
  $_SESSION['OPENID_NAME'] = htmlspecialchars( $openid, ENT_QUOTES);

  if ( isset( $_SESSION['RETURN_AFTER_OPENID'] ) ) {
    $whereto = $_SESSION['RETURN_AFTER_OPENID'];
    unset( $_SESSSION['RETURN_AFTER_OPENID'] );
    header('Location: ' . $whereto);  
  } else {
    echo( "You are logged in " . $_SESSION['OPENID_NAME'] );
  }
} else {
  $_SESSION['OPENID_AUTH'] = false;    
  unset( $_SESSION['OPENID_NAME'] );
  echo( "You are not logged in." );
}


// redirect to restricted application page
?>
