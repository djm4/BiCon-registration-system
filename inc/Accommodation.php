<?php 


class BiConAccommodation {
  
	public function __construct() {
  
    	$this->blocks = array();
    	$this->attendeelookup = array();
    	$this->blocknames = array('T' => 'Templars', 'S' => 'Shepherd');
    	$this->load();
    
    	return $this;
  	}
 
	public function load() {

    	$query = "SELECT * FROM Accommodation";

    	$result = mysql_query( $query ) or die( 'Query failed: ' . mysql_error() );

		if ( !$result ) {
			die( 'Query failed: ' . mysql_error() );
		}

		while ($row = mysql_fetch_assoc($result)) {
			$booking_id = $row['BookingID'];
			$block = $row['Block'];
			$flat = $row['Flat'];
			$room = $row['Room'];
			if (!array_key_exists($block, $this->blocks)) {
				$this->blocks[$block] = array();
			}
			if (!array_key_exists($flat, $this->blocks[$block])) {
				$this->blocks[$block][$flat] = array();
			}
			if (!array_key_exists($room, $this->blocks[$block][$flat])) {
				$this->blocks[$block][$flat][$room] = $booking_id;
			}
			$this->attendeelookup[$booking_id] = 
			  array('block' => $block, 'flat' => $flat, 'room' => $room);
		}
	}

    public function getRoom($booking_id) {
    	if (array_key_exists($booking_id, $this->attendeelookup)) {
    		return $this->attendeelookup[$booking_id];
    	} else {
    		return array();
    	}
    }


    public function getOccupant($block, $flat, $room) {
    	global $regtable;
    	if (array_key_exists($block, $this->blocks)
    	  && array_key_exists($flat, $this->blocks[$block])
    	  && array_key_exists($room, $this->blocks[$block][$flat])) {
    		$booking_id = $this->blocks[$block][$flat][$room];
		
			$query = "SELECT firstname, surname, day_arriving, day_leaving FROM $regtable where id='" . (int)$booking_id . "'";

			$result = mysql_query( $query ) or die( 'Query failed: ' . mysql_error() );

			if ( !$result ) {
				die( 'Query failed: ' . mysql_error() );
			}

			$row = mysql_fetch_assoc( $result );
			
			return array('name' => $row['firstname'] . ' ' . $row['surname'], 
			  'id' => $booking_id, 'day_arriving' => $row['day_arriving'],
			  'day_leaving' => $row['day_leaving']);
    	} else {
    		return array();
    	}
    }


    public function getRoomText($booking_id) {
    	if (array_key_exists($booking_id, $this->attendeelookup)) {
    		$room_details = $this->attendeelookup[$booking_id];
    		$text = '';
    		$block = $this->getBlockName($room_details['block']);
			$text .= $block;
			$text .= sprintf(', flat %02d, room %s', $room_details['flat'], $room_details['room']);
    		return $text;
    	} else {
    		return '';
    	}
    }

    public function getRoomShortText($booking_id) {
    	if (array_key_exists($booking_id, $this->attendeelookup)) {
    		$room_details = $this->attendeelookup[$booking_id];
			$text = sprintf('%s:%02d.%s', $room_details['block'], 
			  $room_details['flat'], $room_details['room']);
    		return $text;
    	} else {
    		return '';
    	}
    }

	public function divFlatDetails($block, $flat, $rooms) {
		$room_labels = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
		$days = array('Tue (24)', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun', 'Mon', 'Tue (31)');
		$div_html = '';
		$div_html .= '<div class="panel_small" id="' . $block . 't_' . $flat . '">' . "\n";
		$div_html .= '<div class="panel_heading">Flat ' . $flat . ':</div>' . "\n";
		$div_html .= '<div class="panel_body"><p>' . "\n";
		for ($i = 0; $i < $rooms; $i++) {
    		$room = $room_labels[$i];
		    $person = $this->getOccupant($block, $flat, $room);
		    if (array_key_exists('name', $person)) {
		    	$name = $person['name'];
		    	$arrival = $days[$person['day_arriving']];
		    	$departure = $days[$person['day_leaving']];
		    	$stay = "($arrival&nbsp;to&nbsp;$departure)";
		    } else {
		    	$name = ' - ';
		    	$stay = '';
		    }
		    $div_html .= "<p>$room: $name $stay</p>\n";
		}
		$div_html .= "</div>\n</div>\n";
		return $div_html;
	}
	
	protected function getBlockName($block) {
		if (array_key_exists($block, $this->blocknames)) {
			return $this->blocknames[$block];
		} else {
			return $block;
		}
	}
}  


?>