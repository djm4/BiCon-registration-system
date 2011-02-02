<?php

require_once('../../../inc/config.inc');

header("Content-Type: text/csv; charset=UTF-8");

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

$with_cancelled = $_GET['with_cancelled'];

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

?>
"ID","First name","Last name","E-mail","Desk","Gopher","First aid","Counselling","Session","Other"
<?php 

foreach ($attendees as $person) {

    if (!$person->volunteer) {
    	continue;
    }
	$currency = $person->getCurrency();
	$cancelled = $person->cancelled;
	$firstname = $person->firstname;
	$surname = $person->surname;
	$bookingnum = $person->id;
	$volother = '';
	if ($person->volsigner || $person->volsound || $person->vollight
	  || $person->volchildcare || $person->voldj ) {
	  	$volother = 1;
	}	

?>
<?= $bookingnum ?>,"<?= $firstname ?>","<?= $surname ?>","<?= $person->email ?>","<?= 
  $person->volrecep ?>","<?= $person->volgopher ?>","<?= $person->volfirstaid ?>","<?= 
  $person->volcounselling ?>","<?= $person->runworkshop ?>","<?= $volother ?>"
<?php

}

?>