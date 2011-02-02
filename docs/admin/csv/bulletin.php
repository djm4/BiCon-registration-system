<?php

require_once('../../../inc/config.inc');

header("Content-Type: text/csv; charset=UTF-8");

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

$with_cancelled = $_GET['with_cancelled'];

?>
"ID","First name","Last name","Event(s)","Currency","E-mail","Charge","Paid","Owing"
<?php

include( 'reg/charges.inc' );
include( 'reg/payment.inc' );

$biconcharges = new BiConCharges();
$bireconcharges = new BiReConCharges();

$attendees = array();

$sql = "SELECT id FROM $regtable";

if (!$with_cancelled) {
  $sql .= ' WHERE cancelled = 0 OR cancelled IS NULL';
}

$sql .= ' ORDER BY id';

# $sql = "SELECT id,firstname,surname,email,tickettype,paymentlevel,totalpaid,othernotes,age,cancelled,numkids,passwd FROM $regtable ORDER BY id";


$result = mysql_query( $sql ) or die( 'Query failed: ' . mysql_error() );

if ( !result ) {
    die( 'Query failed: ' . mysql_error() );
}

while( $row = mysql_fetch_array( $result ) ) {
  $person_id = $row[0];
	$person = new BiConAttendee();
	$person->load($person_id);
	$attendees[] = $person;
}


$i = 0;

$numbookings = 0;
$sumcharge = 0;
$sumpaid = 0;

$numaccom = 0;
$numaccompaidinpart = 0;
$numaccompaidinfull = 0;

$days = array('Wed', 'Thur', 'Fri', 'Sat', 'Sun', 'Mon');

$accommodation_onsite = array(0, 0, 0, 0, 0, 0);
$accommodation_offsite = array(0, 0, 0, 0, 0, 0);

$charges = array('£' => 0, 'US $' => 0, '€' => 0);
$payments = array('£' => 0, 'US $' => 0, '€' => 0);

foreach ($attendees as $person) {

	$currency = $person->getCurrency();
	$cancelled = $person->cancelled;
	
	$firstname = $person->firstname;
	$surname = $person->surname;
	if ( $person->passwd == "" ) {
		$registration = '<i>Partial</i>';
		$paymentlevel = '';
	} else {
		if ($person->paymentlevel && $person->bireconpaymentlevel) {
			$registration = 'BiReCon &amp; BiCon';
			$paymentlevel = "$person->bireconpaymentlevel &amp; $person->paymentlevel";
		} elseif ($person->paymentlevel) {
			$registration = 'BiCon';
			$paymentlevel = "$person->paymentlevel";
		} elseif ($person->bireconpaymentlevel) {
			$registration = 'BiReCon';
			$paymentlevel = "$person->bireconpaymentlevel";
		} else {
			$paymentlevel = '';
			$registration = '<strong>unknown</strong>';
		}
	}
	
	if ($person->accommodation == 'off-site') {
		$accommodation = 'off-site';
		if (!$cancelled) {
			for ($index = $person->day_arriving - 1; $index < $person->day_leaving; ++$index) {
			  $accommodation_offsite[$index]++;
			}
		}		
	} else {
		$accommodation = $days[$person->day_arriving - 1] . ' - ' . $days[$person->day_leaving - 1];
		if (!$cancelled) {
			for ($index = $person->day_arriving - 1; $index < $person->day_leaving - 1; ++$index) {
			  $accommodation_onsite[$index]++;
			}
			$accommodation_offsite[$person->day_leaving - 1]++;
		}
	}

	$c1 = "";
	$c2 = "";

	if ( ($i % 2) == 0 ) {
			$bg = "bgcolor=#bbbbff";
	} else {
			$bg = "bgcolor=#eeeeff";
	}

	if ( $cancelled == 1 ) {
		$bg = "bgcolor=#cccccc";
		$c1 = "<strike>";
		$c2 = "</strike>";
	}

	$bookingnum = $person->id;

	$link = "<a href=\"booking.php?id=" . $bookingnum . "\">" . $bookingnum . "</a>";
	$link .= "(<a href=\"edit.php?id=" . $bookingnum . "\">edit</a>)";

	$biconlevel = $person->paymentlevel;
	$bireconlevel = $person->bireconpaymentlevel;

	$totalcharge = $biconcharges->calculateCharge($person) + $bireconcharges->calculateCharge($person);

	$numkids = $person->numkids;
	settype( $numkids , 'integer' );



	$othernotes = $person->othernotes;

	$psf = paidsofar( $bookingnum , $paidtable );
	
	$owing = $totalcharge - $psf;
	
	$color = '#99ff99';
	if ($psf == 0) {
		$color = '#ff9999';
	} elseif ($owing > 0) {
		$color = '#ffff99';
	}

?>
<?= $bookingnum ?>,"<?= $firstname ?>","<?= $surname ?>","<?= $person->email ?>","<?= $registration ?>","<?= $currency ?>","<?= $totalcharge ?>","<?= $psf ?>","<?= $owing ?>"
<?php

	if ( $cancelled != 1 && $paymentlevel) {
	  $charges[$currency] += $totalcharge;
		$payments[$currency] += $psf;
		$numbookings++;
	}
	$i++;
}

?>