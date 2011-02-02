<?php

require_once('../../inc/config.inc');

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

?>

<html>
<head>
<title>Bicon 2010 acessibility requests</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="/static/admin.css">
</head>

<body>
<p> <a href="vol.php">Volunteers</a> | <a href="ws.php">Run workshop</a> | <a href="hh.php">Helping Hand</a> | <a href="accom.php">Accommodation</a> | <a href="counselling.php">Counselling</a> | <a href="firstaid.php">First aid</a> | <a href="recep.php">Reception &amp; Gopher</a> | <a href="kids.php">Kids</a> | <strong>Access needs</strong> | <a href="index.php">Full list</a></p>
<table border=0 cellspacing=0 cellpadding=2>
<tr>
<th>ID</th>
<th>First name</th>
<th>Last name</th>
<th>E-mail</th>
<th>Accessibility request details</th>
</tr>

<?php

include( 'reg/charges.inc' );
include( 'reg/payment.inc' );

$biconcharges = new BiConCharges();
$bireconcharges = new BiReConCharges();

$attendees = array();

$sql = "SELECT id FROM $regtable WHERE specialneeds = 1 AND (cancelled = 0 OR cancelled IS NULL)";

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
	
	$firstname = htmlspecialchars($person->firstname);
	$surname = htmlspecialchars($person->surname);
	$otherwsinfo = htmlspecialchars($person->otherwsinfo);
	
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

	$biconlevel = $person->paymentlevel;
	$bireconlevel = $person->bireconpaymentlevel;

	$totalcharge = $biconcharges->calculateCharge($person) + $bireconcharges->calculateCharge($person);

	$numkids = $person->numkids;
	settype( $numkids , 'integer' );
	
	$access_request = $person->divAccessibility();


	echo( "<tr>
<td $bg>$c1$link$c2</td>
<td $bg>$c1$firstname$c2</td>
<td $bg>$c1$surname$c2</td>
<td $bg>$c1$person->email$c2</td>
<td $bg>$c1$access_request</td>
");

	$psf = paidsofar( $bookingnum , $paidtable );

	if ( $cancelled != 1 && $paymentlevel) {
	  $charges[$currency] += $totalcharge;
		$payments[$currency] += $psf;
		$numbookings++;
	}
	$i++;
}

?>

</table>

<p> <a href="vol.php">Volunteers</a> | <a href="ws.php">Run workshop</a> | <a href="hh.php">Helping Hand</a> | <a href="accom.php">Accommodation</a> | <a href="counselling.php">Counselling</a> | <a href="firstaid.php">First aid</a> | <a href="recep.php">Reception &amp; Gopher</a> | <a href="kids.php">Kids</a> | <strong>Access needs</strong> | <a href="index.php">Full list</a></p>
</body>
</html>
