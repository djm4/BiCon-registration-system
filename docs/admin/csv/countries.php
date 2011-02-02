<?php

require_once('../../../inc/config.inc');

header("Content-Type: text/csv; charset=UTF-8");

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

$with_cancelled = $_GET['with_cancelled'];
$days = array('Tue (24)', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun', 'Mon', 'Tue (31)');

?>
"ID","First name","Last name","E-mail","Arriving","Country"
<?php

include( 'reg/charges.inc' );
include( 'reg/payment.inc' );

$sql = "SELECT id, firstname, surname, email, day_arriving, country "
 . " FROM $regtable r "
 . ' WHERE (cancelled = 0 OR cancelled IS NULL) AND (LENGTH(passwd) > 0) AND country != \'gb\'';

$sql .= ' ORDER BY id';

$result = mysql_query( $sql ) or die( 'Query failed: ' . mysql_error() );

if ( !result ) {
    die( 'Query failed: ' . mysql_error() );
}

while( $row = mysql_fetch_assoc( $result ) ) {
  $person_id = $row['id'];
  $firstname = $row['firstname'];
  $lastname = $row['surname'];
  $email = $row['email'];
  $day_arriving = $days[$row['day_arriving']];
  $country = $row['country'];
?>
<?= $person_id ?>,"<?= $firstname ?>","<?= $lastname ?>","<?= 
 $email ?>","<?= $day_arriving ?>","<?= $country ?>"
<?php

}

?>