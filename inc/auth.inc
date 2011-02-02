<?php
// check authentication status
session_start();
if (!isset($_SESSION['OPENID_AUTH']) || $_SESSION['OPENID_AUTH'] != true) {
  $_SESSION['RETURN_AFTER_OPENID'] = $_SERVER['REQUEST_URI'];
  header( 'Location: /login/' );
#  die ("You are not permitted to access this page. <a href='/login/'>Please log in</a>.");
}

$name = $_SESSION['OPENID_NAME'];

// Note: you're going to want to change this, unless you really do want only me to access your admin system. 

if ( ( $name != "http://djm4.livejournal.com/" ) ) {
  die ("User " . $name . " is not allowed to access this page");
}
?>