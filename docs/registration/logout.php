<?php

include_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');
$session->delete(true);

header("Location: $http_host/registration/index.php");

?>
