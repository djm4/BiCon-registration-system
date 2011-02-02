<?php

require_once('../../inc/config.inc');

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

?>

<html>
<head>
<title>Bicon 2010 helping hand fund requests</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="/static/admin.css">
</head>

<body>
<p> <a href="vol.php">Volunteers</a> | <a href="ws.php">Run workshop</a> | <strong>Helping Hand</strong> | <a href="accom.php">Accommodation</a> | <a href="counselling.php">Counselling</a> | <a href="firstaid.php">First aid</a> | <a href="recep.php">Reception &amp; Gopher</a> | <a href="kids.php">Kids</a> | <a href="access.php">Access needs</a> | <a href="index.php">Full list</a></p>

<?php 

$hhpayments = array();

$sql = "SELECT p.id, p.amount, p.processedby, DATE(p.paymentdate) AS paymentdate, " .
		"p.paymentcurrency, r.firstname, r.surname FROM $paidtable p " .
		"INNER JOIN $regtable r ON r.id = p.bookingnum " .
		"WHERE p.paymentmethod = 'helpinghand'";

$result = mysql_query( $sql ) or die( 'Query failed: ' . mysql_error() );

if ( !$result ) {
    die( 'Query failed: ' . mysql_error() );
}

while( $row = mysql_fetch_assoc( $result ) ) {
  $hhpayments[] = $row;
}

?>
<h2>Payments</h2>
<table border=0 cellspacing=0 cellpadding=2>
<tr>
<th>ID</th>
<th>Name</th>
<th>Amount</th>
<th>Date made</th>
<th>Processed by</th>
</tr>

<?php 
$i = 0;
foreach ($hhpayments as $hhpayment) {
	if ( ($i % 2) == 0 ) {
			$bg = "bgcolor=#bbbbff";
	} else {
			$bg = "bgcolor=#eeeeff";
	}
	echo( "<tr>" .
			"<td $bg>" . $hhpayment['id'] . "</td>" .
			"<td $bg>" . $hhpayment['firstname'] . ' ' . $hhpayment['surname'] . "</td>" .
			"<td $bg>" . $hhpayment['paymentcurrency'] . $hhpayment['amount'] . "</td>" .
			"<td $bg>" . $hhpayment['paymentdate'] . "</td>" .
			"<td $bg>" . $hhpayment['processedby'] . "</td>" .
			"</tr>");
   $i++;
}

?>

</table>
<?php 

$hhpayments = array();

$sql = "SELECT p.id, p.amount, p.paidby, DATE(p.paymentdate) AS paymentdate, " .
		"p.paymentcurrency FROM $paidtable p " .
		"WHERE p.paymentdesc LIKE '%Helping Hand Fund%' AND p.bookingnum = 0";

$result = mysql_query( $sql ) or die( 'Query failed: ' . mysql_error() );

if ( !$result ) {
    die( 'Query failed: ' . mysql_error() );
}

while( $row = mysql_fetch_assoc( $result ) ) {
  $hhpayments[] = $row;
}

?>
<h2>Donations</h2>
<table border=0 cellspacing=0 cellpadding=2>
<tr>
<th>ID</th>
<th>Donor e-mail</th>
<th>Amount</th>
<th>Date made</th>
</tr>

<?php 
$i = 0;
foreach ($hhpayments as $hhpayment) {
	if ( ($i % 2) == 0 ) {
			$bg = "bgcolor=#bbbbff";
	} else {
			$bg = "bgcolor=#eeeeff";
	}
	echo( "<tr>" .
			"<td $bg>" . $hhpayment['id'] . "</td>" .
			"<td $bg>" . $hhpayment['paidby'] . "</td>" .
			"<td $bg>" . $hhpayment['paymentcurrency'] . $hhpayment['amount'] . "</td>" .
			"<td $bg>" . $hhpayment['paymentdate'] . "</td>" .
			"</tr>");
   $i++;
}

?>

</table>

<h2>Requests</h2>

<table border=0 cellspacing=0 cellpadding=2>
<tr>
<th>ID</th>
<th>First name</th>
<th>Last name</th>
<th>E-mail</th>
<th>Helping hand request details</th>
<th>Payment(s)</th>
</tr>

<?php

include( 'reg/charges.inc' );
include( 'reg/payment.inc' );

$biconcharges = new BiConCharges();
$bireconcharges = new BiReConCharges();

$attendees = array();

$sql = "SELECT id FROM $regtable WHERE helpinghand = 1 AND (cancelled = 0 OR cancelled IS NULL)";
$sql .= ' ORDER BY id';
$result = mysql_query( $sql ) or die( 'Query failed: ' . mysql_error() );

if ( !$result ) {
    die( 'Query failed: ' . mysql_error() );
}

while( $row = mysql_fetch_array( $result ) ) {
  $person_id = $row[0];
	$person = new BiConAttendee();
	$person->load($person_id);
	$attendees[] = $person;
}

$i = 0;

foreach ($attendees as $person) {

	$currency = $person->getCurrency();
	$cancelled = $person->cancelled;
	
	$firstname = htmlspecialchars($person->firstname);
	$surname = htmlspecialchars($person->surname);
	$otherwsinfo = htmlspecialchars($person->otherwsinfo);
	
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

    $hhdetails = $person->divHelpingHand();

	$hhpayment_details = '';

	$sql = "SELECT p.amount, DATE(p.paymentdate) AS paymentdate, " .
			"p.paymentcurrency FROM $paidtable p " .
			"WHERE p.bookingnum = " . mysql_escape_string($person->id) . " AND p.paymentmethod = 'helpinghand'";

	$result = mysql_query( $sql ) or die( 'Query failed: ' . mysql_error() );

	if ( !$result ) {
	    die( 'Query failed: ' . mysql_error() );
	}

	while( $row = mysql_fetch_assoc( $result ) ) {
	  $hhpayment_details .= $row['paymentdate'] . ': ' . $row['paymentcurrency'] . $row['amount'] . '<br />';
	}



	echo( "<tr>
<td $bg>$c1$link$c2</td>
<td $bg>$c1$firstname$c2</td>
<td $bg>$c1$surname$c2</td>
<td $bg>$c1$person->email$c2</td>
<td $bg>$c1$hhdetails$c2</td>
<td $bg>$c1$hhpayment_details$c2</td></tr>
");

	$i++;
}

?>

</table>

<p> <a href="vol.php">Volunteers</a> | <a href="ws.php">Run workshop</a> | <strong>Helping Hand</strong> | <a href="accom.php">Accommodation</a> | <a href="counselling.php">Counselling</a> | <a href="firstaid.php">First aid</a> | <a href="recep.php">Reception &amp; Gopher</a> | <a href="kids.php">Kids</a> | <a href="access.php">Access needs</a> | <a href="index.php">Full list</a></p>
</body>
</html>
