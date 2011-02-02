<?php

require_once('../../inc/config.inc');

#header( 'Content-type: text/plain' );

include( 'auth.inc' );
include( 'mysql.inc' );

$user = $_SERVER['PHP_AUTH_USER'];

$paidsql = "SELECT * from $paidtable order by id;";

$result = mysql_query( $paidsql ) or die( 'Query failed: ' . mysql_error() . $paidsql );

if ( !$result ) {
    die( 'Query failed: ' . mysql_error()  );
}

$j = 0;

echo( "<p>Hello " . $_SESSION['OPENID_NAME'] . "</p>\n" );

echo( '<table><tr><td>id</td><td>booking</td><td>by</td><td>amount</td><td>method</td><td>desc</td><td>from</td><td>receipt</td><td>to</td><td>paypalid</td><td>currency</td><td>date</td></tr>' . "\n" );

while( $row = mysql_fetch_row( $result ) ) {

    $when = FncChangeTimestamp( $row[6] , "YYYY-MM-DD hh:mm:ss" );

    echo( "<tr><td $bg>$row[0]</td><td $bg>$row[1]</td><td $bg>$row[2]</td><td $bg>$row[3]</td><td $bg>$row[4]</td><td $bg>$row[5]</td><td $bg>$row[6]</td><td $bg>$row[7]</td><td $bg>$row[8]</td><td $bg>$row[9]</td><td $bg>$row[10]</td><td $bg>$row[11]</td></tr>" );
#    $enclose = '"';
#    $line = givecsv( $row , "," , $enclose );

#    echo $line;

    $j++;
}

echo( '</table>' );

?>
