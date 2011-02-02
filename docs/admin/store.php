<?php

require_once('../../inc/config.inc');

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$person_id = $_POST['id'];
	$form = $_POST;
} else {
	$person_id = $_GET['id'];
	$form = $_GET;	
}
$attendee = new BiConAttendee();
if ($person_id) {
	$attendee->load($person_id);
}

$attendee->readForm($form);
$attendee->save();
$person_id = $attendee->id;
$views = array('edit' => 'edit.php', 'view' => 'booking.php');
$page_view = 'edit.php';
if (isset($form['page_view']) && array_key_exists($form['page_view'], $views)) {
	$page_view = $views[$form['page_view']];
}

header("Location: $http_host/admin/$page_view?id=$person_id");

?>