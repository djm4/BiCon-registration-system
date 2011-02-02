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

$block = $form['block'];
$flat = $form['flat'];
$room = $form['room'];

$query = "SELECT AccommodationID, BookingID FROM Accommodation "
  . "WHERE Block='" . mysql_escape_string($block) . "' AND Flat = '"
  . mysql_escape_string($flat) . "' AND Room = '" . mysql_escape_string($room) . "'";

$result = mysql_query( $query ) or die( 'Query failed: ' . mysql_error() );

if ( !$result ) {
	die( 'Query failed: ' . mysql_error() );
}
		
if (mysql_num_rows($result) > 0) {
	$row = mysql_fetch_assoc( $result );
	if ($row->BookingID != 0) {
		die('That room is already allocated.');
	} else{
		$accommodation_id = $row->AccommodationID;
		$query = "UPDATE Accommodation SET BookingID = '" 
		. mysql_escape_string($person_id) . "'"
		. " WHERE AccommodationID = '" . mysql_escape_string($accommodation_id) . "'";
	}
} else {
	$query = "INSERT INTO Accommodation (BookingID, Block, Flat, Room)\n"
	  . "VALUES('" . mysql_escape_string($person_id) 
	  . "', '" . mysql_escape_string($block) 
	  . "', '" . mysql_escape_string($flat) 
	  . "', '" . mysql_escape_string($room) 
	  . "')";
	mysql_query($query);
}

$views = array('edit' => 'edit.php', 'view' => 'booking.php');
$page_view = 'booking.php';
if (isset($form['page_view']) && array_key_exists($form['page_view'], $views)) {
	$page_view = $views[$form['page_view']];
}

header("Location: $http_host/admin/$page_view?id=$person_id");

?>