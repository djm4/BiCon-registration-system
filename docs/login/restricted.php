<?php
// check authentication status
session_start();
if (!isset($_SESSION['openidauthed']) || $_SESSION['openidauthed'] != true) {
  die ('You are not permitted to access this page! Please log in again.' . $_SESSION['barbaz'] . ":" . $_SESSION['openidauthed'] . ":" );
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
   "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title></title>
  </head>
  <body>
    <h2>Restricted Page</h2>
    <p>You will only see this page if your OpenID has been successfully authenticated.</p>
  </body>
</html>

