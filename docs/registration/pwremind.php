<?php

require_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

include("reg/header.inc");

$emailaddr = mysql_real_escape_string( $_POST[ 'emailaddr' ] );

$sql = "SELECT firstname,surname,id,passwd from $regtable where email='$emailaddr';";

$result = mysql_query( $sql ) or die( 'Query failed: ' . mysql_error() );

$bookings = 0;
$info = "";

if ( !result ) {
    die( 'Query failed: ' . mysql_error() );
}

$i = 0;

while( $row = mysql_fetch_array( $result ) ) {
    $bookings++;
    $info .= "$row[0] $row[1]: Booking ID $row[2], password $row[3]\n\r";
}

if ( $bookings == 0 ) {

    echo( "Sorry - there are no bookings with the email address '$emailaddr'. Please send an email to <strong>bookings@bicon20010.org.uk</strong> and we will try to track down your booking." );

} else {

    $message = "Hello,

A user requested that you be sent a reminder of your BiCon 2010/10ICB
booking ID.

If you did not request this information, you may safely ignore this
message. If you are receiving it repeatedly without requesting it
and it is becoming a nuisance, please notify webmaster@bicon2010.org.uk
and we shall take action.

The booking(s) associated with your email address $emailaddr
are:

$info
You may review the status of these bookings at any time at
https://secure.10icb.org/registration/

Best regards,
The BiCon 2010/10 ICB robot
";

    $mailsubj = "BiCon 2010 booking - information reminder";
    $mailheaders = "From: BiCon 2010 Bookings Robot <booking-bounces@reg.bicon2010.org.uk>
    X-Mailer: BiCon 2010 Registration Reminder
    X-Bicon: BiCon 2010 booking reminder";

    $mailed = mail( $emailaddr , $mailsubj , $message , $mailheaders , '-f"booking-bounces@reg.bicon2010.org.uk"' );

    if ( $mailed == 1 ) {
        echo( "<p>Your booking information has been mailed to $emailaddr. If you don't receive it in short order, check your spam folder in case it was mistakenly blocked.</p><p><a href='/registration/'>Return to registration login</a></p>" );
    } else {
        echo( "<p>We're sorry - a technical fault prevented sending your details. Please email <strong>bookings@bicon2010.org.uk</strong> and we will sort it out swiftly.</p>" );
    }

}
include("reg/footer.inc");
?>
