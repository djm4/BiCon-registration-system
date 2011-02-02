<?php

require_once('../../../inc/config.inc');

header("Content-Type: text/csv; charset=UTF-8");
header("Content-disposition: attachment; filename=desk.csv");

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

$with_cancelled = $_GET['with_cancelled'];
$blocks = array('T' =>'Templars', 'S' => 'Shepherd');
$days = array('Tue (24)', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun', 'Mon', 'Tue (31)');

?>
"ID","First name","Last name","Accommodation","Day arriving","Day leaving","BiCon","BiReCon","Currency","Owing","Block","Flat","Room","Code of Conduct"
<?php

include( 'reg/charges.inc' );
include( 'reg/payment.inc' );

$biconcharges = new BiConCharges();
$bireconcharges = new BiReConCharges();

$sql = "SELECT id, firstname, surname, parkingspace, email, accommodation, a.Block, a.Flat, a.Room, "
 . " day_arriving, day_leaving, conduct_agreed, paymentlevel, bireconpaymentlevel "
 . " FROM $regtable r LEFT JOIN Accommodation a ON a.BookingID = r.id "
 . ' WHERE (cancelled = 0 OR cancelled IS NULL) AND (LENGTH(passwd) > 0)';

$sql .= ' ORDER BY id';

$result = mysql_query( $sql ) or die( 'Query failed: ' . mysql_error() );

if ( !result ) {
    die( 'Query failed: ' . mysql_error() );
}

while( $row = mysql_fetch_assoc( $result ) ) {
  $person_id = $row['id'];
  $firstname = $row['firstname'];
  $lastname = $row['surname'];
  $parkingspace = $row['parkingspace'];
  $accommodation = $row['accommodation'];
  $email = $row['email'];
  $paymentlevel = ($row['paymentlevel'] ? 'yes' : 'no');
  $bireconpaymentlevel = ($row['bireconpaymentlevel'] ? 'yes' : 'no');
  if ($accommodation == 'on-site') {
	  $block = $row['Block'];
	  $flat = $row['Flat'];
	  $room = $row['Room'];
	  if ($block) {
	  	$block = $blocks[$block];
	  } else {
	  	$block = '';
	  	$flat = '';
	  	$room = '';
	  }
	$day_arriving = $days[$row['day_arriving']];
	$day_leaving = $days[$row['day_leaving']];
  } else {
  	$block = '';
  	$flat = '';
  	$room = '';
  	$day_arriving = '';
  	$day_leaving = '';
  }
  	$person = new BiConAttendee();
	$person->load($person_id);
	$currency = $person->getCurrency();

	$biconlevel = $person->paymentlevel;
	$bireconlevel = $person->bireconpaymentlevel;
	$totalcharge = $biconcharges->calculateCharge($person) + $bireconcharges->calculateCharge($person);

	$psf = paidsofar( $person_id , $paidtable );
	$owing = $totalcharge - $psf;
	
	if ($owing <= 0) {
		$owing = '';
		$currency = '';
	}
	
	$conduct_agreed = $row['conduct_agreed'];
 
?>
<?= $person_id ?>,"<?= $firstname ?>","<?= $lastname ?>","<?=
 $accommodation ?>","<?= $day_arriving ?>","<?= $day_leaving ?>","<?=
  $paymentlevel ?>","<?= $bireconpaymentlevel ?>","<?= $currency ?>","<?= $owing ?>","<?= 
  $block ?>","<?= $flat ?>","<?= $room ?>","<?= $conduct_agreed ?>"
<?php

}

?>