<?php

require_once('../../inc/config.inc');

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

$with_cancelled = $_GET['with_cancelled'];
$only_cancelled = $_GET['only_cancelled'];
$event = $_GET['event'];
$accommodation = $_GET['accommodation'];

?>

<html>
<head>
<title>Bicon 2010 registrations</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="/static/admin.css">
</head>

<body>

<p>
<a href="vol.php">Volunteers</a> | <a href="ws.php">Run workshop</a> | <a href="hh.php">Helping Hand</a> | <a href="accom.php">Accommodation</a> | <a href="counselling.php">Counselling</a> | <a href="firstaid.php">First aid</a>
| <a href="recep.php">Reception &amp; Gopher</a> | <a href="kids.php">Kids</a> | <a href="access.php">Access needs</a> | 
<? if ($with_cancelled) {
  ?>
<a href="index.php?with_cancelled=0">Without cancelled entries</a>
  <?
} else {
  ?>
<a href="index.php?with_cancelled=1">With cancelled entries</a>
  <?
}
?>
</p>
<p><a href="index.php">All events</a>
 | <a href="index.php?event=bicon">BiCon/ICB</a>
 | <a href="index.php?event=birecon">BiReCon</a> 
 | <a href="index.php?only_cancelled=1">Only cancelled</a> 
 | <a href="index.php?accommodation=on-site">Staying on-site</a> 
 | <a href="index.php?accommodation=off-site">Staying off-site</a> 
 </p>
 
<p><a href="edit.php?id=0">New registration</a></p>
 
<table border=0 cellspacing=0 cellpadding=2>
<tr>
<th>ID</th>
<th>First name</th>
<th>Last name</th>
<th>Event(s)</th>
<th>Band(s)</th>
<th>Accommodation</th>
<th>E-mail</th>
<th>Kids</th>
<th>Charge</th>
<th>Paid</th>
<th>Owing</th>
</tr>

<?php

include( 'reg/charges.inc' );
include( 'reg/payment.inc' );

$biconcharges = new BiConCharges();
$bireconcharges = new BiReConCharges();
$accommodation_matrix = new BiConAccommodation();

$attendees = array();

$sql = "SELECT id FROM $regtable";

$whereclauses = array();

if (!($with_cancelled || $only_cancelled)) {
  $whereclauses[] = '(cancelled = 0 OR cancelled IS NULL)';
} 

if ($only_cancelled) {
	$whereclauses[] = '(cancelled = 1)';
}

if ($event == 'bicon') {
	$whereclauses[] = '(LENGTH(paymentlevel) > 0)';
} elseif ($event == 'birecon') {
	$whereclauses[] = '(LENGTH(bireconpaymentlevel) > 0)';
}

if ($accommodation == 'on-site') {
	$whereclauses[] = '(accommodation = \'on-site\')';
}

if ($accommodation == 'off-site') {
	$whereclauses[] = '(accommodation = \'off-site\')';
}

if (count($whereclauses)) {
	$sql .= ' WHERE ' . join(' AND ', $whereclauses);
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
	
	$firstname = htmlspecialchars($person->firstname);
	$surname = htmlspecialchars($person->surname);
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
		$accommodation = $days[$person->day_arriving - 1] . ' - ' . $days[$person->day_leaving - 1] 
		  . ' ('. $accommodation_matrix->getRoomShortText($person->id) . ')';
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
	
	$email = $person->email;
	if ($person->contactmethod != 'email') {
		$email = "(<i>$email</i>)"; 
	}


	echo( "<tr>
<td $bg>$c1$link$c2</td>
<td $bg>$c1$firstname$c2</td>
<td $bg>$c1$surname$c2</td>
<td $bg>$c1$registration$c2</td>
<td $bg>$c1$paymentlevel$c2</td>
<td $bg>$c1$accommodation$c2</td>
<td $bg>$c1$email$c2</td>
<td $bg>$c1$numkids$c2</td>
<td $bg>$c1$currency$totalcharge$c2</td>
");

	$othernotes = $person->othernotes;

	$psf = paidsofar( $bookingnum , $paidtable );

	echo( "<td $bg>$c1$currency$psf$c2</td>" );
	
	$owing = $totalcharge - $psf;
	
	$color = '#99ff99';
	if ($psf == 0 && $owing > 0) {
		$color = '#ff9999';
	} elseif ($owing > 0) {
		$color = '#ffff99';
	}
	
	echo("<td bgcolor=\"$color\">$c1$currency$owing$c2</td></tr>");

	if ( $othernotes != "" ) {
		echo("<tr>
		<td colspan=2 $bg>Other notes</td>
		<td colspan=10 $bg>$othernotes</td>
		</tr>
		");
	}

	if ( $cancelled != 1 && $paymentlevel) {
	  $charges[$currency] += $totalcharge;
		$payments[$currency] += $psf;
		$numbookings++;
	}
	$i++;
}

?>

</table>

<h3>Payments and charges</h3>
<p>
Total completed, uncancelled bookings: <?= $numbookings ?></p>

<table cellpadding=2>
  <tr><th>Currency</th><th>Charges</th><th>Paid</th><th>Owing</th></tr>
  <tr><td>£</td><td><?= $charges['£'] ?></td><td><?= $payments['£'] ?></td><td><?= $charges['£'] - $payments['£'] ?></td></tr>
  <tr><td>US $</td><td><?= $charges['US $'] ?></td><td><?= $payments['US $'] ?></td><td><?= $charges['US $'] - $payments['US $'] ?></td></tr>
  <tr><td>€</td><td><?= $charges['€'] ?></td><td><?= $payments['€'] ?></td><td><?= $charges['€'] - $payments['€'] ?></td></tr>
</table>

<h3>Accommodation</h3>

<table cellpadding=2>
  <tr><th>Day</th><th>Staying on-site</th><th>Staying off-site</th><th>Total</th></tr>
<?php
for($index = 0; $index <= 5; ++$index) {
  $day = $days[$index];
	$onsite = $accommodation_onsite[$index];
	$offsite = $accommodation_offsite[$index];
	$total = $onsite + $offsite;
  echo("<tr><td>$day</td><td>$onsite</td><td>$offsite</td><td>$total</td></tr>\n");
}
?>
</table>

<p> <a href="vol.php">Volunteers</a> | <a href="ws.php">Run workshop</a> | <a href="hh.php">Helping Hand</a> | <a href="accom.php">Accommodation</a> | <a href="counselling.php">Counselling</a> | <a href="firstaid.php">First aid</a> | <a href="recep.php">Reception &amp; Gopher</a> | <a href="kids.php">Kids</a> | <a href="access.php">Access needs</a> |
  <? if ($with_cancelled) {
  ?>
    <a href="index.php?with_cancelled=0">Without cancelled entries</a>
    <?
} else {
  ?>
    <a href="index.php?with_cancelled=1">With cancelled entries</a>
    <?
}
?>
</p>
</body>
</html>
