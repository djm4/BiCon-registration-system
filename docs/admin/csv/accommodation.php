<?php

require_once('../../../inc/config.inc');

header("Content-Type: text/csv; charset=UTF-8");

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

$accommodation_matrix = new BiConAccommodation();
$room_labels = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
$days = array('Tue (24)', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun', 'Mon', 'Tue (31)');

?>
"Room","Name","Arriving","Departing"
<?php 

foreach (array('T', 'S') as $block) {
	for ($flat = 1; $flat < 32; $flat++) {
		foreach(array('A', 'B', 'C', 'D', 'E', 'F', 'G') as $room) {
			$person = $accommodation_matrix->getOccupant($block, $flat, $room);
		    if (array_key_exists('name', $person)) {
		    	$name = $person['name'];
		    	$arrival = $days[$person['day_arriving']];
		    	$departure = $days[$person['day_leaving']];
		    } else {
		    	$name = ' - ';
		    	$arrival = '';
		    	$departure = '';
		    }
		    $room_details = sprintf('%s:%02d.%s', $block, $flat, $room);
			?>
"<?= $room_details ?>","<?= $name ?>","<?= $arrival ?>","<?= $departure ?>"
<?php
		}
	}
}

?>