<?php 


class BiConAttendee {
  
 	private $bools = array( 'futurebicons', 'otherbiorgs', 'receiveupdates',
		'standingorder', 'extranight', 'helpinghand', 'refund', 'mobilityimp',
		'hearingimp', 'sightimp', 'mhimp', 'accessflat', 'nostairs', 'carerspace',
		'signer', 'roomloop', 'whitestick', 'largeprint', 'creche', 'accomlist',
		'parkingspace', 'volunteer', 'volcounselling', 'volsigner', 'volfirstaid',
		'volrecep', 'volgopher', 'volsound', 'vollight', 'volchildcare', 'voldj',
		'hhdonate', 'runworkshop', 'runbefore', 'firstbicon' , 'assistanimal' , 'reservelist',
		'newcomerslist', 'conduct_agreed', 'cancelled', 'specialneeds' );

	private $texts = array( 'firstname', 'surname', 'addr1', 'addr2', 'addr3', 'town',
		'county', 'country', 'postcode', 'email', 'homephone', 'mobilephone',
		'contactmethod', 'otherdisinfo', 'needtoshare', 'flatpref', 'shareloc',
		'sharelocwhich', 'sharegroup', 'sharegroupwhich', 'shareage', 'shareagewhich',
		'sharenoise', 'sharenoisewhich', 'sharediet', 'sharedietwhich',
		'sharewith1', 'sharewith1name', 'sharewith2', 'sharewith2name',
		'sharewith3', 'sharewith3name', 'othershareinfo', 'volother', 'volqualified',
		'hhreason', 'otherhhinfo', 'suggestworkshop', 'proposeworkshop',
		'otherwsinfo', 'heardfromwhat', 'othernotes' , 'paymentlevel' , 'bireconpaymentlevel', 'lookingfor', 
		'accommodation', 'passwd', 'event', 'currency' );

	private $ints = array( 'age', 'tickettype', 'numkids', 'kidsunderfive',
		'kidsfivetoseven', 'kidseighttoeleven', 'kidstwelvetofifteen',
		'kidssixteen', 'kidsseventeen', 'hhrequest', 'hhdonateamount',
		'howmanybicons', 'firstheard', 'day_arriving', 'day_leaving' );
		
	public $active_fields = array('id', 'firstname', 'surname', 
		'addr1', 'addr2', 'addr3', 'town', 'county', 'postcode', 'country', 
		'email', 'homephone', 'contactmethod', 
		'currency', 'paymentlevel', 'bireconpaymentlevel', 
		'accommodation', 'day_arriving', 'day_leaving', 'flatpref', 'sharenoise', 'sharenoisewhich', 
		'sharediet', 'shardietwhich', 'sharewith1name', 'othershareinfo',
		'othernotes', 'lookingfor', 'cancelled',
		'numkids', 'firstheard', 'heardfromwhat', 'conductagreed',
		'futurebicons', 'helpinghand', 'parkingspace', 'volunteer', 'newcomerslist');
		
	private $db;
	public $passwd;
	public $id;

  public function __construct() {
  
    $this->firstname = '';
    $this->surname = '';
    $this->email = '';
    $this->addr1 = '';
    $this->addr2 = '';
    $this->addr3 = '';
    $this->town = '';
    $this->postcode = '';
    $this->county = '';
    $this->country = 'GB';
    $this->homephone = '';
    $this->mobilephone = '';
	$this->event = '';
    $this->id = 0;
    $this->currency = '£';
    
    return $this;
  }
 
  public function load($id) {

    global $regtable;
		
		$query = "SELECT * FROM $regtable where id='" . (int)$id . "'";

    $result = mysql_query( $query ) or die( 'Query failed: ' . mysql_error() );

		if ( !$result ) {
				die( 'Query failed: ' . mysql_error() );
		}

		$row = mysql_fetch_assoc( $result );
		
		foreach ($row as $field => $value) {
			$this->$field = $value;
		}
		
	}

	public function save() {		

    global $regtable;
		global $logfilepath;
		$logfilename = $logfilepath . '/reg.log';

    if ( !$logfile = fopen( $logfilename, "a" ) ) {
        die( 'Booking failed - could not open logfile.' );
    }

    fwrite( $logfile , "Beginning booking\r\n" );
		
    $query = '';
    if ($this->id > 0) {
      $set_clauses = array();
      $query = "UPDATE $regtable SET ";
      for ($iLoop = 0; $iLoop < count($this->bools); $iLoop++) {
			  $field = $this->bools[$iLoop];
				if (isset($this->$field)) {
        	$set_clauses[] =  mysql_real_escape_string($field) . " = '" . mysql_real_escape_string($this->$field) . "'";
				}
      }
      for ($iLoop = 0; $iLoop < count($this->texts); $iLoop++) {
			  $field = $this->texts[$iLoop];
				if (isset($this->$field)) {
        	$set_clauses[] =  mysql_real_escape_string($field) . " = '" . mysql_real_escape_string($this->$field) . "'";
				}
      }
      for ($iLoop = 0; $iLoop < count($this->ints); $iLoop++) {
			  $field = $this->ints[$iLoop];
				if (isset($this->$field)) {
        	$set_clauses[] =  mysql_real_escape_string($field) . " = '" . mysql_real_escape_string($this->$field) . "'";
				}
      }
      $query .= join(', ', $set_clauses);
      $query .= ' WHERE id = ' . mysql_real_escape_string($this->id);
			$result = mysql_query( $query );
	
			if ( !$result ) {
        fwrite( $logfile , "Database insert failed: " . mysql_error() . "\r\n" );
				die( 'Query failed: ' . mysql_error() );
			}
	    fwrite( $logfile , "id " . $this->id . " sql " . $query . "\n\r" );

    } else {
		
		  $fields = array();
			$values = array();
			
      for ($iLoop = 0, $limit =  count($this->bools); $iLoop < $limit; $iLoop++) {
			  $field = $this->bools[$iLoop];
				if (isset($this->$field)) {
        	$fields[] = mysql_real_escape_string($field);
					$values[] = "'" . mysql_real_escape_string($this->$field) . "'";
				}
      }
      for ($iLoop = 0, $limit =  count($this->texts); $iLoop < $limit; $iLoop++) {
			  $field = $this->texts[$iLoop];
				if (isset($this->$field)) {
        	$fields[] = mysql_real_escape_string($field);
					$values[] = "'" . mysql_real_escape_string($this->$field) . "'";
				}
      }
      for ($iLoop = 0, $limit =  count($this->ints); $iLoop < $limit; $iLoop++) {
			  $field = $this->ints[$iLoop];
				if (isset($this->$field)) {
        	$fields[] = mysql_real_escape_string($field);
					$values[] = "'" . mysql_real_escape_string($this->$field) . "'";
				}
      }
      $query = "INSERT INTO $regtable (" . join(', ', $fields) . ') VALUES(' . join(', ', $values) .')';
      $result = mysql_query($query);
			if ( !$result ) {
			  fwrite( $logfile , "Database insert failed: " . mysql_error() . "\r\n" );
				die( 'Query failed: ' . mysql_error() );
			}
      $this->id = mysql_insert_id();
	    fwrite( $logfile , "id " . $this->id . " sql " . $query . "\n\r" );
    }
	}
	
	public function readForm($form) {
      
    foreach ($this->bools as $field) {
      if (isset($form[$field])){
			  // Booleans are stored as integers, but some forms submit them as 'yes'/'no'.
			  if ($form[$field] == 'yes') {	$form[$field] = 1; }
			  if ($form[$field] == 'no') {	$form[$field] = 0; }
        $this->$field = $form[$field];
      }
    }

    foreach ($this->texts as $field) {
      if (isset($form[$field])){
        $this->$field = $form[$field];
      }
    }
    foreach ($this->ints as $field) {
      if (isset($form[$field])){
        $this->$field = $form[$field];
      }
    }		

	}
	
	public function generatePassword() {
	
	  srand(date("s")); 
    $possible_charactors = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
    $string = ""; 
    while(strlen($string)<8) { 
        $string .= substr($possible_charactors, rand()%(strlen($possible_charactors)),1); 
    } 
	  $this->passwd = $string;
	  return;
	}
	
	public function getRegion() {
	  if ($this->country == 'GB') {
		  return 'GB';
		} elseif ($this->country == 'US' || $this->country == 'CA') {
		  return 'US';
		} elseif (in_array($this->country, 
		    array('AT', 'BE', 'CY', 'FI', 'FR', 'DE', 'GR', 'IE', 'IT', 'LU', 'MT', 'NL', 'PT', 'SK', 'SL', 'ES'))) {
		  return 'EU';
		} else {
		  return 'ROW'; # 'Rest Of World'
		}
	}
 
	public function getCurrency() {
	  return $this->currency;
	}

	public function getCurrencyCode() {
	  $currency = $this->currency;
	  if ($currency == '£') {
		  return 'GBP';
		} elseif ($currency == 'US $') {
		  return 'USD';
		} elseif ($currency == '€') {
		  return 'EUR';
		} else {
		  return 'USD'; # 'Rest Of World'
		}
	}
	
	public function calculateDetailedCharge($biconcharges, $bireconcharges) {
		$accommodation = $this->accommodation;
		$day_arriving = $this->day_arriving;
		$day_leaving = $this->day_leaving;
		$nights = $day_leaving - $day_arriving;
		if ($this->paymentlevel && $this->bireconpaymentlevel) {
		  # This person is attending both events.
			$biconband = $biconcharges->getBand($this);
			$bireconband = $bireconcharges->getBand($this);
			$currency = $this->getCurrency();
			$breakdown = "BiReCon at $currency$bireconband->full_rate &amp; BiCon at $currency$biconband->full_rate, ";
			if ($accommodation == 'on-site' && $nights > 0) {
			  # Wednesday and Thursday are charged at BiReCon rates. All other days are charged at BiCon rates.
				if ($day_arriving <= 2) {
					if ($day_leaving > 3) {
						$birecon_nights = 3 - $day_arriving;
						$bicon_nights = $day_leaving - 3;
					} else {
					  $birecon_nights = $nights;
						$bicon_nights = 0;
					}
					$accommodation_cost = ($birecon_nights * $bireconband->room_rate) + ($bicon_nights * $biconband->room_rate);
					$breakdown .= "plus $birecon_nights nights BiReCon accommodation at $currency$bireconband->room_rate "
					  . " &amp; $bicon_nights nights BiCon accommodation at $currency$biconband->room_rate totalling $currency$accommodation_cost, ";
				} else {
					$accommodation_cost = ($nights * $biconband->room_rate);
					$breakdown .= "plus $nights nights accommodation at $currency$biconband->room_rate totalling $currency$accommodation_cost, ";
				}
			} else {
				$breakdown .= "with no accomodation charge because you aren't staying on-site, ";
			}
			$breakdown .= " making a <strong>total cost of $currency" . $this->calculateCharge($biconcharges, $bireconcharges) . '</strong>';			
		} else {
		  if ($this->paymentlevel) {
				$band = $biconcharges->getBand($this);
				$event = 'BiCon/ICB';			
		  } elseif ($this->bireconpaymentlevel) {
				$band = $bireconcharges->getBand($this);
				$event = 'BiReCon';			
			}
			$currency = $this->getCurrency();
			
			$breakdown = "$event at $currency$band->full_rate, ";
			if ($accommodation == 'on-site' && $nights > 0) {
				$accommodation_cost = ($nights * $band->room_rate);
				$breakdown .= "plus $nights nights accommodation at $currency$band->room_rate totalling $currency$accommodation_cost, ";
			} else {
				$breakdown .= "with no accomodation charge because you aren't staying on-site, ";
			}
			$breakdown .= " making a <strong>total cost of $currency" . $this->calculateCharge($biconcharges, $bireconcharges) . '</strong>';
		}
		return $breakdown;
	}
	
	public function calculateCharge($biconcharges, $bireconcharges) {
	
	  # Note - this needs a *lot* more sanity checking of the inputs.
	
		$accommodation = $this->accommodation;
		$day_arriving = $this->day_arriving;
		$day_leaving = $this->day_leaving;
	  $nights = $day_leaving - $day_arriving;

		if ($this->paymentlevel && $this->bireconpaymentlevel) {
		  # This person is attending both events.
			$biconband = $biconcharges->getBand($this);
			$bireconband = $bireconcharges->getBand($this);
			$charge = $bireconband->full_rate + 	$biconband->full_rate;
			if ($accommodation == 'on-site' && $nights > 0) {
			  # Wednesday and Thursday are charged at BiReCon rates. All other days are charged at BiCon rates.
				if ($day_arriving <= 2) {
					if ($day_leaving > 3) {
						$birecon_nights = 3 - $day_arriving;
						$bicon_nights = $day_leaving - 3;
					} else {
					  $birecon_nights = $nights;
						$bicon_nights = 0;
					}
					$charge += ($birecon_nights * $bireconband->room_rate) + ($bicon_nights * $biconband->room_rate);
				} else {
					$charge += ($nights * $biconband->room_rate);
  			}
			}
		} else {
		  if ($this->paymentlevel) {
				$band = $biconcharges->getBand($this);	
		  } elseif ($this->bireconpaymentlevel) {
				$band = $bireconcharges->getBand($this);		
			}
			
			$charge = $band->full_rate;
			if ($accommodation == 'on-site' && $nights > 0) {
				$charge += ($nights * $band->room_rate);
			}
		}
	  
		return $charge;
	} 
	
	public function divPanel($title, $body, $id) {
		
		$div_html = '<div class="panel" id="' . $id . '">' . "\n";
		$div_html .= '<div class="panel_heading">' . $title . '</div>' . "\n";
		$div_html .= '<div class="panel_body">' . $body . '</div>' . "\n";
		$div_html .= '</div>' . "\n";
		return $div_html;
	}
	
	public function divNameAndAddress() {
		
		$name = htmlspecialchars($this->firstname) . ' ' 
		  . htmlspecialchars($this->surname);
		$address = array();
		$body = '';
		if ($this->addr1) {
			array_push($address, htmlspecialchars($this->addr1));
		}
		if ($this->addr2) {
			array_push($address, htmlspecialchars($this->addr2));
		}
		if ($this->addr3) {
			array_push($address, htmlspecialchars($this->addr3));
		}
		if ($this->town) {
			array_push($address, htmlspecialchars($this->town));
		}
		if ($this->county) {
			array_push($address, htmlspecialchars($this->county));
		}
		if ($this->postcode) {
			array_push($address, htmlspecialchars($this->postcode));
		}
		if ($this->country) {
			array_push($address, htmlspecialchars($this->country));
		}
		$body .= '<p>' . $name . '<br />'
		  . join(',<br />', $address) 
		  . "</p>\n";
		if ($this->homephone) {
			$body .= '<p><strong>Tel:</strong> ' . $this->homephone . '</p>';
		}
		$body .= '<p><strong>E-mail:</strong> ' . $this->email . '</p>';
		$body .= '<p><strong>Contact method:</strong> ' . $this->contactmethod . '</p>';
		
		return $this->divPanel('Name and address', $body, 'name_and_address');
	}
	
	public function divRegistrationDetails($biconcharges, $bireconcharges) {
		
		$body = '';
		$totalcharge = $biconcharges->calculateCharge($this) + $bireconcharges->calculateCharge($this);
		$currency = $this->getCurrency();
		$days = array('Wed', 'Thur', 'Fri', 'Sat', 'Sun', 'Mon');

		$body .= '<p>Staying ' . $this->accommodation . ': ' 
		  . $days[$this->day_arriving -1] . ' to ' 
		  . $days[$this->day_leaving - 1] . " inclusive.</p>\n";

		if ($this->paymentlevel) {
	  		# This person is coming to BiCon.
  			$biconpaymentlevel = $biconcharges->getBand($this)->label;
			$totalbiconcharge = $biconcharges->calculateDetailedCharge($this);
 
	  		$body .= "<p>Registered for BiCon at payment level <strong>$biconpaymentlevel.</strong></p>\n";
            $body .= "<p>Charge: $totalbiconcharge.</li>\n";
		}
		if ($this->bireconpaymentlevel) {
	  		# This person is coming to BiReCon.
  			$bireconpaymentlevel = $bireconcharges->getBand($this)->label;
			$totalbireconcharge = $bireconcharges->calculateDetailedCharge($this);

	  		$body .= "<p>Registered for BiReCon at payment level <strong>$bireconpaymentlevel.</strong></p>\n";
    		$body .= "<p>Charge: $totalbireconcharge.</p>\n";
		}
		$body .= "<p>Total charge: <strong>$currency$totalcharge.</strong></p>";		
		return $this->divPanel('Registration details', $body, 'registration_details');
	}
	
	public function divOtherInfo() {
		$body = '';
		$body .= '<p>OK to pass info to future BiCons: ' 
		  . ($this->futurebicons ? 'yes' : 'no') . "</p>\n";
		$body .= '<p>Join BiCon newcomers list: ' 
		  . ($this->newcomerslist ? 'yes' : 'no') . "</p>\n";
		$body .= '<p>Code of conduct agreed: ' 
		  . ($this->conduct_agreed ? 'yes' : 'no') . "</p>\n";
		$body .= '<p>Parking space needed: ' 
		  . ($this->parkingspace ? 'yes' : 'no') . "</p>\n";
		$body .= '<p>Has been to ' . $this->howmanybicons . ' BiCon(s) before.</p>';
		if ($this->firstheard) {
			$body .= "<p>First heard about the event from $this->firstheard</p>\n";
		}
		if ($this->heardfromwhat) {
			$body .= "<p>Heard about it from newpaper/event: $this->heardfromwhat</p>\n";
		}
		if ($this->othernotes) {
			$body .= "<p>Other notes: $this->othernotes</p>\n";
		}
		if ($this->lookingfor) {
			$body .= "<p>Looking for: $this->lookingfor</p>\n";
		}
		if ($this->passwd) {
			$body .= "<p>Password: $this->passwd</p>\n";
		}
		return $this->divPanel('Other information', $body, 'other_info');		
	}
	
	public function divAccommodation() {
		$body = '<p>Staying on-site.</p>';
		if ($this->flatpref) {
			$body .= '<p>Floor preference: ' . $this->flatpref . "</p>\n";
		}
		if ($this->sharenoisewhich) {
			$sharing = '';
			if (!$this->sharenoise) {
				$sharing .= '(no preference)';
			} elseif ($this->sharenoise == 'share') {
				$sharing .= 'Would like to share with ';
			} elseif ($this->sharenoise == 'notshare') {
				$sharing .= 'Would not like to share with ';
			}
			if (!$this->sharenoisewhich) {
				$sharing .= '(no preference)';
			} elseif ($this->sharenoisewhich == 'party') {
				$sharing .= 'a party flat.';
			} elseif ($this->sharenoisewhich == 'noisy') {
				$sharing .= 'a noisy (but not party) flat.';
			} elseif ($this->sharenoisewhich == 'quiet') {
				$sharing .= 'a quiet flat.';
			}
			$body .= '<p>' . $sharing . "</p>\n";
		}
		if ($this->sharedietwhich) {
			$sharing = '';
			if (!$this->sharediet) {
				$sharing .= '(no preference)';
			} elseif ($this->sharediet == 'share') {
				$sharing .= 'Would like to share with ';
			} elseif ($this->sharediet == 'notshare') {
				$sharing .= 'Would not like to share with ';
			}
			if (!$this->sharedietwhich) {
				$sharing .= '(no preference)';
			} elseif ($this->sharedietwhich == 'vegan') {
				$sharing .= 'vegans.';
			} elseif ($this->sharedietwhich == 'vegetarian') {
				$sharing .= 'vegetarians.';
			} elseif ($this->sharedietwhich == 'noalcohol') {
				$sharing .= 'non-alcohol drinkers.';
			}
			$body .= '<p>' . $sharing . "</p>\n";
		}
		if ($this->sharewith1name) {
			$body .= '<p>Share with: ' . $this->sharewith1name . "</p>\n";
		}
		if ($this->othershareinfo) {
			$body .= '<p>Other info: ' . $this->othershareinfo . "</p>\n";
		}
		
		$query = "SELECT * FROM Accommodation WHERE BookingID = '" . mysql_escape_string($this->id) . "'";

		$result = mysql_query( $query ) or die( 'Query failed: ' . mysql_error() );

		if ( !$result ) {
				die( 'Query failed: ' . mysql_error() );
		}
		
		if (mysql_num_rows($result) > 0) {
			$row = mysql_fetch_assoc( $result );
			$blocks = array('T' => 'Templars', 'S' => 'Shepherd');
			if (array_key_exists($row['Block'], $blocks)) {
				$block = $blocks[$row['Block']];
			} else {
				$block = $row['Block'];
			}
			$body .= "<p><strong>";
			$body .= $block;
			$body .= sprintf(', flat %02d, room %s', $row['Flat'], $row['Room']);
			$body .= "</strong></p>\n";
		} else {
          $body .= '<form action="store_accommodation.php" method="POST">' 
            . '<input type="hidden" name="id" value="' . $this->id . '" /> '
            . '<p>Block: <select name="block">'
            . '  <option value="">Please choose...</option>'
            . '  <option value="T">Templars</option>'
            . '  <option value="S">Shepherd</option>'
            . '</select> <br />'
            . 'Flat: <input type="text" name="flat" value="" size="4" /> '
            . 'Room: <input type="text" name="room" value="" size="4" />'
            . ' <input type="submit" name="submit" value="Go!" />'
            . '</form>';			
		}

		
	    return $this->divPanel('Accommodation', $body, 'accommodation');
	}
	
	public function divAccessibility() {
		$body = '<p>Has indicated access needs.</p>';
		$body .= "<ul>\n";
		if ($this->mobilityimp) {
			$body .= "<li>Has a mobility impairment</li>\n";
		}
		if ($this->hearingimp) {
			$body .= "<li>Has a hearing impairment</li>\n";
		}
		if ($this->sightimp) {
			$body .= "<li>Has a sight impairment</li>\n";
		}
		if ($this->mhimp) {
			$body .= "<li>Would like us to be aware of a mental health issue</li>\n";
		}
		if ($this->accessflat) {
			$body .= "<li>Requires a fully accessible flat</li>\n";
		}
		if ($this->nostairs) {
			$body .= "<li>Requires access with no stairs</li>\n";
		}
		if ($this->carerspace) {
			$body .= "<li>Requires space for a carer</li>\n";
		}
		if ($this->signer) {
			$body .= "<li>Requires a signer or lip speaker</li>\n";
		}
		if ($this->roomloop) {
			$body .= "<li>Requires a room loop</li>\n";
		}
		if ($this->whitestick) {
			$body .= "<li>Requires a white stick</li>\n";
		}
		if ($this->assistanimal) {
			$body .= "<li>Needs to bring an assistance animal</li>\n";
		}
		if ($this->largeprint) {
			$body .= "<li>Requires materials in large print</li>\n";
		}
		$body .= "</ul>\n";
		if ($this->otherdisinfo) {
			$body .= "<p>Other info: $this->otherdisinfo</p>\n";
		}
		if ($this->needtoshare) {
			$body .= "<p>Needs to share with: $this->needtoshare</p>\n";
		}
	    return $this->divPanel('Accessibility', $body, 'accessibility');		
	}
	
	public function divKids() {
		$body = "<p>Bringing the following children:</p>\n";
		$body .= "<ul>\n";
		if ($this->kidsunderfive) {
			$body .= "<li>$this->kidsunderfive under five old</li>\n";
		}
		if ($this->kidsfivetoseven) {
			$body .= "<li>$this->kidsfivetoseven five to seven years old</li>\n";
		}
		if ($this->kidseighttoeleven) {
			$body .= "<li>$this->kidseighttoeleven eight to eleven years old</li>\n";
		}
		if ($this->kidstwelvetofifteen) {
			$body .= "<li>$this->kidstwelvetofifteen twelve to fifteen years old</li>\n";
		}
		if ($this->kidssixteen) {
			$body .= "<li>$this->kidssixteen sixteen years old</li>\n";
		}
		if ($this->kidsseventeen) {
			$body .= "<li>$this->kidsseventeen seventeen years old</li>\n";
		}
		$body .= "</ul>\n";
		if ($this->creche) {
			$body .= "<p>Interested in an off-site creche.</p>\n";
		}
		if ($this->accomlist) {
			$body .= "<p>Would like a list of nearby accommodation.</p>\n";
		}
	    return $this->divPanel('Children', $body, 'kids');
	}

	public function divVolunteer() {
		$body = "<p>Has offered to volunteer.</p>\n";
		$body .= "<ul>\n";
		if ($this->runworkshop) {
			$body .= "<li>Would like to run a session: $this->otherwsinfo</li>\n";
		}
		if ($this->volcounselling) {
			$body .= "<li>Would like to volunteer as a counsellor</li>\n";
		}
		if ($this->volsigner) {
			$body .= "<li>Would like to volunteer as a signer</li>\n";
		}
		if ($this->volfirstaid) {
			$body .= "<li>Would like to volunteer as a first aider</li>\n";
		}
		if ($this->volrecep) {
			$body .= "<li>Would like to help on reception</li>\n";
		}
		if ($this->volgopher) {
			$body .= "<li>Would like to volunteer as a gopher</li>\n";
		}
		if ($this->volsound) {
			$body .= "<li>Would like to help with sound</li>\n";
		}
		if ($this->vollight) {
			$body .= "<li>Would like to help with lighting</li>\n";
		}
		if ($this->volchildcare) {
			$body .= "<li>Would like to help with childcare</li>\n";
		}
		$body .= "</ul>\n";
		if ($this->volother) {
			$body .= "<p>Would like to volunteer for: $this->volother</p>\n";
		}
		if ($this->volqualified) {
			$body .= "<p>Has the following qualifications: $this->volqualified</p>\n";
		}
	    return $this->divPanel('Voulnteering', $body, 'volunteer');
	}

	public function divHelpingHand() {
		$body = "<p>Has requested help from the Helping Hand Fund:</p>\n";
		if ($this->hhrequest) {
			$body .= "<p>Assistance required: $this->hhrequest </p>\n";
		}
		if ($this->hhreason) {
			$body .= "<p>Reason: $this->hhreason </p>\n";
		}
		if ($this->otherhhinfo) {
			$body .= "<p>Other info: $this->otherhhinfo </p>\n";
		}
	    return $this->divPanel('Helping Hand', $body, 'helping hand');
	}
	
	public function checkBoxChecked($field) {
		$checkbox_array = array('', '');
		if ($this->$field) {
			$checkbox_array[1] = ' checked="checked"';
		} else {
			$checkbox_array[0] = ' checked="checked"';
		}
		return $checkbox_array;
	}
	
	public function selectArray($field, $array) {

		if ($this->$field) {
  			$array[$this->$field] = ' selected="selected"';
		} 
		return $array;
		
	}

}  

class BiConAttendeeSession {

  private $sessionid = 0;
  private $session = '';
  public $contactid = 0;
  
  public function __construct() {
    // Do nothing
  }

  /** Creates a session for a UserID, regardless of if there are any other 
      active sessions for this user. If there's an existing SessionID,
      expire it, but *don't* expire other sessions for this user even if
      they use the same IP address (could be different browsers). */

  public function create(&$person) {
    		
		error_log('Person ID: ' . $person->id);
		
		if (!$person || !$person->id) { return null; }

		$existing_session_id = $this->getCurrentID();
		
		error_log('Session ID ' . $existing_session_id);
		
		if ($existing_session_id) {
			$query = "UPDATE Session SET (Expired = 1) WHERE SessionID='" . mysql_real_escape_string($existing_session_id) . "'";
			mysql_query($query);
		}
	
		$ipaddress = $GLOBALS['_SERVER']['REMOTE_ADDR'];
		$session = '';
    for ($iLoop = 0; $iLoop < 16; $iLoop++) {
      $session .= substr('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 
        mt_rand(0, 61), 1);
    }
	
		$this->session = $session;
		$this->contactid = $person->id;
		$this->ipaddress= $ipaddress;
		$this->sessiondate = strftime('%Y-%m-%d %T');
		$this->expired = 0;
		$this->tietoip = 0;
		$this->permanent = 0;
		$this->created = strftime('%Y-%m-%d %T', time());
    $this->save();
		return true;

  }

  private function load($session_id) {
		$this->clear();
		$query = 'SELECT * FROM Session WHERE SessionID = \'' . mysql_real_escape_string($session_id). "'";
    $result = mysql_query( $query ) or die( 'Query failed: ' . mysql_error() );

		if ( !$result ) {
			die( 'Query failed: ' . mysql_error() );
		}

		if (mysql_num_rows($result) > 0) {
			$row = mysql_fetch_assoc( $result );
			foreach ($row as $field => $value) {
				$fieldname = strtolower($field);
				if (isset($value)) {
					$this->$fieldname = $value;
				} else {
					$this->$fieldname = '';
				}
			}
		}
  }

  private function clear() {
    $this->sessionid = 0;
		$this->session = '';
		$this->contactid = 0;
  }

  private function save() {
  
    $fields = array('Session', 'ContactID', 'IPAddress', 'Date', 'Expired', 'TieToIP', 'Permanent', 'Created');
    $values = array($this->session, $this->contactid, $this->ipaddress, $this->sessiondate, 
	  	$this->expired, $this->tietoip, $this->permanent, $this->created);
		for ($iLoop = 0, $limit = count($values); $iLoop < $limit; $iLoop++) {
		  $values[$iLoop] = "'" . mysql_real_escape_string($values[$iLoop]) . "'";
		}
    $query = '';
    if (isset($this->sessionid) && $this->sessionid > 0) {
      $set_clauses = array();
      $query = 'UPDATE Session SET ';
      for ($iLoop = 0, $limit = count($values); $iLoop < $limit; $iLoop++) {
        $set_clauses[] = $fields[$iLoop] . ' = ' . $values[$iLoop];
      }
      $query .= join(', ', $set_clauses);
      $query .= ' WHERE SessionID = \'' . mysql_real_escape_string($this->sessionid) . "'";
      mysql_query($query);
    } else {
      $query = 'INSERT INTO Session (' . join(', ', $fields) . ') VALUES(' . join(', ', $values) .')';
      mysql_query($query);
      $this->sessionid = mysql_insert_id();
    }
		error_log($query);
  }


  public function validate() {

    /* Check that we have something that looks like a valid SessionID and hash */
  
    $session_id = 0;
		$session_hash = '';
	
    if (isset($GLOBALS["_COOKIE"]["sessionid"])) { 
  	  $cookie_array = explode('|', $GLOBALS["_COOKIE"]["sessionid"]);
			if ($cookie_array[0]) {
				$session_id = $cookie_array[0];
				$session_hash = $cookie_array[1];
			} else {
				return false;
			}
		} else {
			return false;
		}
	
    if (!($session_id && $session_hash)) { return false; }

    /* Pull the information for the SessionID out of the database. */

    $this->load($session_id);
		if ($this->sessionid == 0 || $this->expired == 1) {
			return false;
		}

    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $session_string = $this->session;

    if ($session_hash == md5($session_string . $ipaddress . 'scfgshatfk')) {
      return true;
    } elseif ($session_hash == md5($session_string . 'scfgshatfk')) {
      return true;  
    } else {
			$this->clear();
			return false;
		}
  }

  public function isCurrent() {
    $session_id = $this->getCurrentID();
		$query = "SELECT SessionID FROM Session WHERE SessionID = '" . mysql_real_escape_string($session_id) 
			. "' AND Expired = 0 AND (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(Date) < 1800)";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0) {
				return true;
		}
		return false;
  }

  public function refresh() {
    $session_id = $this->getCurrentID();
		$this->load($session_id);
		if ($this->sessionid > 0 && $this->expired == 0) {
			$query = "UPDATE Session SET Date = NOW() WHERE SessionID=" . mysql_real_escape_string($session_id);
			mysql_query($query);
			return true;
		} else {
			$this->clear();
			return false;
		}
  } 
  
  public function delete($all_sessions_this_user = 0, $domain = '') {
		$session_id = $this->getCurrentID();
    if (!$domain) {
      $domain = isset($GLOBALS['_SERVER']['HTTP_HOST']) ? $GLOBALS['_SERVER']['HTTP_HOST'] : '';
      if (preg_match('/\.secure\.10icb\.org$/i', $domain)) { $domain = 'secure.10icb.org'; } 
    }
	
		if ($all_sessions_this_user) {
			$this->load($session_id);
			if ($this->sessionid && $this->contactid) {
				$query = "UPDATE Session SET Expired = 1 WHERE ContactID='" . mysql_real_escape_string($this->contactid) . "'";
			} else {
				$query = "UPDATE Session SET Expired = 1 WHERE SessionID='" . mysql_real_escape_string($session_id) . "'";
			}
		} else {
			$query = "UPDATE Session SET Expired = 1 WHERE SessionID='" . mysql_real_escape_string($session_id) . "'";
		}
    mysql_query($query);
		$this->clear();
		setcookie("sessionid", '', 0, '/', '.' . $domain, false);
		return;
  }
  
  
  public function createCookie($tie_to_ip_address = true, $is_permanent = false, $domain = '') {
    $session_id = $this->getCurrentID();
    if (!$domain) {
      $domain = isset($GLOBALS['_SERVER']['HTTP_HOST']) ? $GLOBALS['_SERVER']['HTTP_HOST'] : '';
      if (preg_match('/\.secure\.10icb\.org$/i', $domain)) { $domain = 'secure.10icb.org'; }
	  	$domain = preg_replace('/:\d+$/', '', $domain);
    }
		if ($this->sessionid == 0) {
			$this->load($session_id);
		}
		if ($this->sessionid == 0 || $this->expired) { return false; }
		if (!isset($tie_to_ip_address)) {
			$tie_to_ipaddress = isset($this->tietoip) ? $this->tietoip : 0;
		}
		if (!isset($is_permanent)) {
			$is_permanent = isset($this->permanent) ? $this->permanent : '';
		}
    $this->tietoip = $tie_to_ip_address;
		$this->permanent = $is_permanent;
		$this->save();

    $ipaddress = $tie_to_ip_address ? $this->ipaddress : '';
		$hash = md5($this->session . $ipaddress . 'scfgshatfk');
  
    if ($is_permanent) {
      setcookie('sessionid', "$session_id|$hash", time()+60*60*24*180, '/', $domain, false);
    } else {
      setcookie('sessionid', "$session_id|$hash", 0, '/', $domain, false);
    }
    return;
  }
  
  /* Gets the personID associated with the session */

  public function getPersonID() {
		$session_id = $this->getCurrentID();
		$this->load($session_id);
		return $this->contactid;
  }

  /** Gets the current session, if there is one */
  
  private function getCurrentID() {
    if ($this->sessionid > 0) {
			return $this->sessionid;
		}
    $cookie_id = 0;
		if (isset($GLOBALS["_COOKIE"]["sessionid"])) {
			$cookie_array = explode('|', $GLOBALS["_COOKIE"]["sessionid"]);
			if ($cookie_array[0]) {
				$cookie_id = $cookie_array[0];
			}
		}
		return $cookie_id;
  }
}

class BiConCharges {

  public $regions = array();
	public $attendeefield = '';
	public $event = '';
	 
	public function __construct() {
		$this->regions['GB'] = array(
			'A' => new BiConBand('Unwaged or under £13,000', 30, 15, 30),
			'B' => new BiConBand('£13,000 - £17,000', 38, 18, 35),
			'C' => new BiConBand('£17,000 - £25,000', 44, 22, 40),
			'D' => new BiConBand('£25,000 - £32,000', 55, 28, 46),
			'E' => new BiConBand('£32,000 - £50,000', 70, 35, 52),
			'F' => new BiConBand('£50,000 or more', 90, 45, 60),
			'G' => new BiConBand('Organisations', 90, 45, 60),
		);
	 
		$this->regions['US'] = array(
			'A' => new BiConBand('Unwaged or under £13,000', 30, 15, 30),
			'B' => new BiConBand('£13,000 - £17,000', 38, 18, 35),
			'C' => new BiConBand('£17,000 - £25,000', 44, 22, 40),
			'D' => new BiConBand('£25,000 - £32,000', 55, 28, 46),
			'E' => new BiConBand('£32,000 - £50,000', 70, 35, 52),
			'F' => new BiConBand('£50,000 or more', 90, 45, 60),
			'G' => new BiConBand('Organisations', 90, 45, 60),
		);
		$this->regions['EU'] = array(
			'A' => new BiConBand('Unwaged or under £13,000', 30, 15, 30),
			'B' => new BiConBand('£13,000 - £17,000', 38, 18, 35),
			'C' => new BiConBand('£17,000 - £25,000', 44, 22, 40),
			'D' => new BiConBand('£25,000 - £32,000', 55, 28, 46),
			'E' => new BiConBand('£32,000 - £50,000', 70, 35, 52),
			'F' => new BiConBand('£50,000 or more', 90, 45, 60),
			'G' => new BiConBand('Organisations', 90, 45, 60),
		);
		$this->regions['ROW'] = array(
			'A' => new BiConBand('Flat rate', 30, 15, 30),
		);
		$this->attendeefield = 'paymentlevel';
		$this->event = 'BiCon/ICB';
		return $this;
	}
	
	public function showBands($region = 'GB', $current = '')  {
	  $dropdown = '<option value="">--Please choose--</option>' . "\n";
	  foreach ($this->regions[$region] as $band => $band_details) {
		  $band_selected = '';
			if ($band == $current) {
			  $band_selected = ' selected="selected"';
			}
		  $dropdown .= '<option value="' . htmlspecialchars($band) . '"' . $band_selected .'>' . 
			  htmlspecialchars($band . ': ' . $band_details->label) . '</option>' . "\n";
		}
		return $dropdown;
	}

	public function showBandTable($region = 'GB', $currency = '£')  {
	  $table = '<thead><tr valign=\"top\"><td valign=\"top\">Band</td><td valign=\"top\">Registration</td><td valign=\"top\">Accommodation<br />(per night)</td></tr></thead>' . "\n";
		$table .= "<tbody>\n";
	  foreach ($this->regions[$region] as $band => $band_details) {
		  $table .= "<tr><td align=\"right\">" 
				. htmlspecialchars($band_details->label) . ": </td>\n"
				. "<td>$currency$band_details->full_rate</td>\n"
				. "<td>$currency$band_details->room_rate</td></tr>\n";
		}
		$table .= "</tbody>\n";
		return $table;
	}

	
	public function getBand($attendee) {
	  
		$paymentlevel = $attendee->{$this->attendeefield};
		if ($paymentlevel == '') {
			return NULL;
		}
		$region = $attendee->getRegion();
		$bands = $this->regions[$region];
		$band = $bands[$paymentlevel];
		return $band;
	}
	
	public function calculateDetailedCharge($attendee) {
		$accommodation = $attendee->accommodation;
		$day_arriving = $attendee->day_arriving;
		$day_leaving = $attendee->day_leaving;
		$band = $this->getBand($attendee);
		if (is_null($band)) { return ''; }
		$currency = $attendee->getCurrency();
		
		if ($attendee->paymentlevel && $attendee->bireconpaymentlevel) {
		  # The attendee is attending both events. Tread carefully around the issue of room charges.
			if ($this->attendeefield == 'paymentlevel') {
			  if ($day_arriving < 3) {
				  $day_arriving = 3;
				}
			} else {
			  if ($day_leaving > 3) {
				  $day_leaving = 3;
				}	
			}
		}
		$nights = $day_leaving - $day_arriving;
	
		$breakdown = "$this->event registration at $currency$band->full_rate, ";
		if ($accommodation == 'on-site' && $nights > 0) {
			$accommodation_cost = ($nights * $band->room_rate);
		  $breakdown .= "plus $nights nights accommodation at $currency$band->room_rate totalling $currency$accommodation_cost, ";
		} else {
		  $breakdown .= "with no accomodation charge because you aren't staying on-site, ";
		}
		$breakdown .= " making a <strong>total cost of $currency" . $this->calculateCharge($attendee) . '</strong>';
		return $breakdown;
	}
	
	public function calculateCharge($attendee) {
	
	  # Note - this needs a *lot* more sanity checking of the inputs.
	
		$accommodation = $attendee->accommodation;
		$day_arriving = $attendee->day_arriving;
		$day_leaving = $attendee->day_leaving;
		$band = $this->getBand($attendee);
		if (is_null($band)) {	return 0;	}

		if ($attendee->paymentlevel && $attendee->bireconpaymentlevel) {
		  # The attendee is attending both events. Tread carefully around the issue of room charges.
			if ($this->attendeefield == 'paymentlevel') {
			  if ($day_arriving < 3) {
				  $day_arriving = 3;
				}
			} else {
			  if ($day_leaving > 3) {
				  $day_leaving = 3;
				}	
			}
		}
		
		$charge = $band->full_rate;
		if ($accommodation == 'on-site') {
		  $nights = $day_leaving - $day_arriving;
			$charge += ($nights * $band->room_rate);
		}
	  
		return $charge;
	}
}

class BiReConCharges extends BiConCharges {

	public function __construct() {
		$this->regions['GB'] = array(
			'A' => new BiConBand('Student', 50, 50, 30),
			'B' => new BiConBand('Full rate', 100, 100, 60),
			'C' => new BiConBand('Conference Speaker', 0, 0, 60),
		);
	 
		$this->regions['US'] = array(
			'A' => new BiConBand('Student', 50, 50, 30),
			'B' => new BiConBand('Full rate', 100, 100, 60),
			'C' => new BiConBand('Conference Speaker', 0, 0, 60),
		);
		$this->regions['EU'] = array(
			'A' => new BiConBand('Student', 50, 50, 30),
			'B' => new BiConBand('Full rate', 100, 100, 60),
			'C' => new BiConBand('Conference Speaker', 0, 0, 60),
		);
		$this->regions['ROW'] = array(
			'A' => new BiConBand('Flat rate', 50, 50, 30),
		);
		$this->attendeefield = 'bireconpaymentlevel';
		$this->event = 'BiReCon';
		return $this;
	}

}

class BiConBand {

  public $label;
	public $full_rate;
	public $day_rate;
	public $room_rate;

  public function __construct($label, $full_rate, $day_rate, $room_rate) {
	
	  $this->label = $label;
		$this->full_rate = $full_rate;
		$this->day_rate = $day_rate;
		$this->room_rate = $room_rate;
		
		return $this;
	}

}

?>