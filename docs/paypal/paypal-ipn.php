<?php


require_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

$logfilename = "$logfilepath/ipn.log";
$paymentlogfilename = "$logfilepath/pay.log";

if ( !$logfile = fopen( $logfilename, "a" ) ) {
    header( "HTTP/1.0 500 Server error" );
    echo( "Server error, can't open logfile" );
    exit;
}

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

$timenow = date( "Y-m-d/H:i:s/O" );

fwrite( $logfile , "$timenow\r\nPreparing IPN request $req\r\n" );

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$custom = $_POST['custom'];

$transauth = 2;         # gets set to 0 if unauthorised, 1 if authorised
$noauthreason = "none";

if (!$fp) {
    // HTTP ERROR
    header( "HTTP/1.0 500 Server error" );
    echo( "Server error, can't check success" );
    fwrite( $logfile , "HTTP ERROR, can't check success\r\n" );
    $transauth = 0;
    $noauthreason = "Can't check success";
} else {
    fputs ($fp, $header . $req);
    while (!feof($fp)) {
        $res = fgets ($fp, 1024);

        if (strcmp ($res, "VERIFIED") == 0) {

	    fwrite( $logfile , "Response VERIFIED\r\n" );

            // check the payment_status is Completed

	    if ( strcmp( $payment_status, "Completed" ) != 0 ) {
	        $transauth = 0;
		$noauthreason = "Payment status not Completed: " . $payment_stats;
	    }

            // check that txn_id has not been previously processed

	    $versql = "SELECT count(*) from $paidtable where paymentmethod='paypal' AND receipt='$txn_id';";

	    $verresult = mysql_query( $versql );

	    if ( !$verresult ) {
		header( "HTTP/1.0 500 Server error" );
    		echo( "Server error, database problem" );
    		fwrite( $logfile , "HTTP ERROR, mysql error" . mysql_error() . "\r\n" );
    		$transauth = 0;
    		$noauthreason = "Database problem" . mysql_error() . " .";
	    }

	    $verrow = mysql_fetch_row( $verresult );

	    if ( $verrow[0] != 0 ) {
	        $transauth = 0;
		$noauthreason = "txn_id $txn_id previously encountered $verrow[0] times";
	    }

            // check that receiver_email is your Primary PayPal email

	    if ( strcmp( $receiver_email , "paypal@bicon2010.org.uk" ) != 0 and strcmp( $receiver_email , "seller@paypalsandbox.com" ) != 0 ) {
	        $transauth = 0;
		$noauthreason = "receiver_email wrong: " . $receiver_email;
	    }

            // check that payment_amount/payment_currency are correct

	    if ( strcmp( $payment_currency , "GBP" ) != 0 and strcmp( $payment_currency , "USD" ) != 0 and strcmp( $payment_currency , "EUR" ) != 0 ) {
	        $transauth = 0;
		$noauthreason = "payment_currency wrong: " . $payment_currency;
	    }

            // process payment

	    if ( $transauth != 0 ) {
	        $transauth = 1;
	    }

	    #$sql = "UPDATE $regtable SET totalpaid=$payment_amount WHERE id='$custom';";
	    #fwrite( $logfile , 'SQL: $sql\r\n' );

	    #$result = mysql_query( $sql );

	    #if ( !$result ) {
	    #    fwrite( $logfile , 'Query failed: ' . mysql_error() );
            #    die( 'Query failed: ' . mysql_error() );
	    #}

        }
        else if (strcmp ($res, "INVALID") == 0) {

	    fwrite( $logfile , "Response INVALID\r\n" );
	    $transauth = 0;
	    $noauthreason = "Response INVALID";

            // log for manual investigation

        } 

        // fwrite( $logfile , "Error Response $res\r\n" );

    }
    fclose ($fp);
}

fwrite( $logfile , "Payment status $payment_status\r\n" );
fwrite( $logfile , "Txn id $txn_id\r\n" );
fwrite( $logfile , "Receiver $receiver_email\r\n" );
fwrite( $logfile , "Payment $payment_currency $payment_amount\r\n" );
fwrite( $logfile , "Payer $payer_email\r\n" );
fwrite( $logfile , "Item $item_name Number $item_number\r\n" );
fwrite( $logfile , "Custom $custom\r\n" );
fwrite( $logfile , "transauth $transauth\r\n" );

if ( $transauth == 0 ) {
    fwrite( $logfile , "NOT AUTHORISED Reason $noauthreason\r\n" );
    die( 'Transaction not authorised' );
}

if ( $transauth == 2 ) {
    fwrite( $logfile , "NOT AUTHORISED never got set\r\n" );
    die( 'Transaction not authorised' );
}

fwrite( $logfile , "Attempting to update database\r\n" );

$surcharge = 0;
$amount = $payment_amount - $surcharge;

$bookingid = $custom;
$processedby = "IPN";
$paymentmethod = "paypal";
$paymentdesc = "$item_name $item_number";
$paidby = $payer_email;
$receipt = $txn_id;

$sql = "INSERT INTO $paidtable ( bookingnum , processedby , amount , paymentmethod , paymentdesc , paidby , receipt , paypalemail , paypalid , paymentcurrency ) VALUES ( '$bookingid' , '$processedby' , '$amount' , '$paymentmethod' , '$paymentdesc' , '$paidby' , '$receipt' , '$receiver_email' , '$txn_id' , '$payment_currency' );";

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

$today = getdate();
$today_day = $today['mday'];
$today_month = $today['mon'];
$today_year = $today['year'];

$sqldate = sprintf('%04d-%02d-%02d 00:00:00', $today_year, $today_month, $today_day);
$sql = "UPDATE $paidtable SET paymentdate = '$sqldate' WHERE id = '$id'";

$result = mysql_query( $sql );


?>
