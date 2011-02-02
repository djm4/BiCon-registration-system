<?php

require_once('../../../inc/config.inc');

header("Content-Type: text/csv; charset=UTF-8");

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

$with_cancelled = $_GET['with_cancelled'];
$blocks = array('T' =>'Templars', 'S' => 'Shepherd');

?>
"ID","First name","Last name","Parking space","E-mail","Accommodation","Block","Flat","Room"
<?php

include( 'reg/charges.inc' );
include( 'reg/payment.inc' );

$sql = "SELECT id, firstname, surname, parkingspace, email, accommodation, a.Block, a.Flat, a.Room "
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
?>
<?= $person_id ?>,"<?= $firstname ?>","<?= $lastname ?>","<?= 
 $parkingspace ?>","<?= $email ?>","<?= $accommodation ?>","<?= $block ?>","<?= 
 $flat ?>","<?= $room ?>"
<?php

}

?>