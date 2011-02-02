<?php

require_once('../../inc/config.inc');

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

?>

<html>
<head>
<title>Bicon 2010 registrations</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="/static/admin.css">
</head>

<body>

<?php

include( 'reg/charges.inc' );
include( 'reg/payment.inc' );

$biconcharges = new BiConCharges();
$bireconcharges = new BiReConCharges();

$person_id = $_GET['id'];
$attendee = new BiConAttendee();
$attendee->load($person_id);

$name = '';
$user = $name;

$today = getdate();
$today_day = $today['mday'];
$today_month = $today['mon'];
$today_year = $today['year'];
$months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

?>

<p><a href="booking.php?id=<?= $person_id - 1 ?>">Previous</a> 
  | <a href="index.php">Booking index</a> 
  | <a href="booking.php?id=<?= $person_id + 1 ?>">Next</a></p>

<p><a href="edit.php?id=<?= $person_id ?>">Edit</a></p>
<form action="store.php" method="post">
<input type="hidden" name="id" value="<?= $person_id ?>" />
<?php 
if ($attendee->cancelled) {
	?>
<input type="hidden" name="cancelled" value="0" />
<input type="hidden" name="page_view" value="view" />
<input type="submit" name="submit" id="submit" value="Mark this booking as un-cancelled" />
<style type="text/css">
div.panel_heading {
  background-color: #cccccc;
}

div.panel_body {
  background-color: #eeeeee;
}
</style>	
	<?php 
} else{
	?>
<input type="hidden" name="cancelled" value="1" />
<input type="hidden" name="page_view" value="view" />
<input type="submit" name="submit" id="submit" value="Mark this booking as cancelled" />
	<?php 
}	
?>
</form>
<?php 

echo('<div class="panel_board">');

echo($attendee->divNameAndAddress());
echo($attendee->divRegistrationDetails($biconcharges, $bireconcharges));
echo($attendee->divOtherInfo());
if($attendee->accommodation == 'on-site') {
	echo($attendee->divAccommodation());
}
if($attendee->specialneeds) {
	echo($attendee->divAccessibility());
}
if ( $attendee->numkids > 0 ) {
    echo($attendee->divKids());
}
if ( $attendee->volunteer) {
    echo($attendee->divVolunteer());
}
if ($attendee->helpinghand) {
	echo($attendee->divHelpingHand());
}

echo('</div>');
?>
<br clear="both">

<h2>Record payment</h2>

<p>Use the form below to record an additional (helping hand, cheque,
bank transfer) payment for this person. Please fill in at least the 
Amount and Payment Method fields</p>

<form action="payment.php" method="post" class="cleared">
<table bgcolor="#eeeeee" cellpadding="2" cellspacing="2">
<tr>
<td>
<input type="hidden" name="bookingid" value="<?= $person_id ?>">
<strong>Booking id</strong>
</td>
<td><?= $person_id ?></td>
</tr>
<tr>
<td>
<input type="hidden" name="processedby" value="<?= $user ?>">
<strong>Processed by</strong>
</td>
<td><?= $user ?></td>
</tr>
<tr>
  <td>
    <strong>Processed on date:</strong>
  </td>
  <td>
	<select name="day">
	<?php
	for ($day = 1; $day <= 31; $day++) {
		if ($day == $today_day) {
			echo('<option value="' . sprintf('%02d', $day) . '" selected="selected">' . $day . '</option>');
		} else {
			echo('<option value="' . sprintf('%02d', $day) . '">' . $day . '</option>');
		}
	}
	?>
	</select>
	<select name="month">
	<?php
	for ($month = 1; $month <= 12; $month++) {
		if ($month == $today_month) {
			echo('<option value="' . sprintf('%02d', $month) . '" selected="selected">' . $months[$month - 1] . '</option>');
		} else {
			echo('<option value="' . sprintf('%02d', $month) . '">' . $months[$month - 1] . '</option>');
		}
	}
	?>
	</select>
	<select name="year">
	<?php
	for ($year = $today_year - 2; $year <= $today_year; $year++) {
		if ($year == $today_year) {
			echo('<option value="' . sprintf('%04d', $year) . '" selected="selected">' . $year . '</option>');
		} else {
			echo('<option value="' . sprintf('%04d', $year) . '">' . $year . '</option>');
		}
	}
	?>
	</select>
  </td>
</tr>
<tr>
<td><strong>Amount</strong></td><td><input type="text" name="amount"></td>
</tr>
<tr>
<td><strong>Payment method</strong></td>
<td><select name="paymentmethod">
<option value="cheque">Cheque
<option value="po">Postal Order
<option value="banktrans">Bank Transfer
<option value="ppm">Paypal (manual)
<option value="cash">Cash
<option value="helpinghand">Helping Hand subsidy
</select></td>
</tr>
<tr>
<td><strong>Currency</strong></td>
<td><input type="hidden" name="currency" value="<?= $attendee->getCurrencyCode(); ?>"> <?= $attendee->getCurrencyCode(); ?></td>
</tr>
<tr>
<td><strong>Payment info</strong></td><td><input type="text" name="paymentdesc"></td>
</tr>
<tr>
<td><strong>Paid by</strong></td><td><input type="text" name="paidby"></td>
</tr>
<tr>
<td><strong>Receipt number</strong></td><td><input type="text=" name="receipt"></td>
<tr>
<td></td><td><input type="submit"></td>
</tr>

</table>

</form>

<br>
<br>

<strong>Paid so far:</strong> &pound;<?= paidsofar( $person_id , $paidtable ) ?><br>

<p><a href="#payments">Payment breakdown below</a></p>

<a name="payments"></a>

<table border=0 cellspacing=0 cellpadding=2>
<tr>
<th>Pay id</th>
<th>Processed</th>
<th>Amount</th>
<th>Method</th>
<th>Paid by</th>
<th>Receipt</th>
<th>When</th>
</tr>

<?php

$paidsql = "SELECT id,processedby,amount,paymentmethod,paidby,receipt,paymentdate from $paidtable where bookingnum='" . mysql_real_escape_string($person_id) . "';";

$result = mysql_query( $paidsql ) or die( 'Query failed: ' . mysql_error() . $paidsql );

if ( !$result ) {
    die( 'Query failed: ' . mysql_error()  );
}

$j = 0;

while( $row = mysql_fetch_row( $result ) ) {

    if ( ($j % 2) == 0 ) {
        $bg = "bgcolor=#bbbbff";
    } else {
        $bg = "bgcolor=#eeeeff";
    }

    $when = $row[6];

    echo( "<tr><td $bg>$row[0]</td><td $bg>$row[1]</td><td $bg>$row[2]</td><td $bg>$row[3]</td><td $bg>$row[4]</td><td $bg>$row[5]</td><td $bg>$when</td></tr>" );

    $j++;
}

?>

</table>

</body>
</html>
