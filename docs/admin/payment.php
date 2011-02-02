<?php

require_once('../../inc/config.inc');

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

$logfilename = "$logfilepath/ipn.log";
$paymentlogfilename = "$logfilepath/pay.log";

if ( !$logfile = fopen( $logfilename, "a" ) ) {
    header( "HTTP/1.0 500 Server error" );
    echo( "Server error, can't open logfile" );
    exit;
}

$timenow = date( "Y-m-d/H:i:s/O" );

$booking_id = $_POST['bookingid'];
$processed_by = $_POST['processedby'];
$amount = $_POST['amount'];
$payment_method = $_POST['paymentmethod'];
$payment_desc = $_POST['paymentdesc'];
$paid_by = $_POST['paidby'];
$receipt = $_POST['receipt'];
$currency = $_POST['currency'];
$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];

$sqldate = "$year-$month-$day 00:00:00";

$sql = "INSERT INTO $paidtable ( bookingnum , processedby , amount , paymentmethod"
 . " , paymentdesc , paidby , receipt , paypalemail , paypalid , paymentcurrency, paymentdate ) "
 . " VALUES ( '$booking_id' , '$processed_by' , '$amount' , '$payment_method'"
 . " , '$payment_desc' , '$paid_by' , '$receipt' , '' , '' , '$currency', '$sqldate' );";

if ( !$paymentlogfile = fopen( $paymentlogfilename, "a" ) ) {
    die( 'Update failed - could not open logfile.' );
}

fwrite( $paymentlogfile , "$timenow\r\nBeginning payment\r\n" );

$result = mysql_query( $sql );

if ( !$result ) {
    fwrite( $paymentlogfile , "Database insert failed: " . mysql_error() . "\r\n" );
    die( 'Query failed: ' . mysql_error() );
}

$id = mysql_insert_id();

fwrite( $paymentlogfile , "id " . $id . " sql " . $sql . "\n\r" );

header("Location: $http_host/admin/booking.php?id=$booking_id");

?>
