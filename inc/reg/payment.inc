<?php

function paidsofar( $id , $paidtable )
{

    $psfpaidsql = "SELECT id,amount from $paidtable where bookingnum='" . $id . "';";

    $psfresult = mysql_query( $psfpaidsql ) or die( 'Query failed: ' . mysql_error() . $psfpaidsql );

    if ( !$psfresult ) {
        die( 'Query failed: ' . mysql_error()  );
    }

    $psfamount = 0;

    while( $psfrow = mysql_fetch_row( $psfresult ) ) {

    	$psfamount += (int)$psfrow[1];

    }

    return $psfamount;

}

?>
