<?php

include_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

$logfilename = "/usr/local/web/secure.10icb.org/run/reg.log";

$candidateid = mysql_real_escape_string( $_POST[ 'id' ] );
$candidatepass = mysql_real_escape_string( $_POST[ 'passwd' ] );

if ( strcmp( $candidateid , "" ) == 0 ) {

  # No login ID provided.
  header("Location: $http_host/registration/index.php");

} else {

	$sql = "SELECT firstname, surname, email FROM $regtable WHERE id = '$candidateid' and passwd = '$candidatepass'";
	
	$result = mysql_query( $sql ) or die( 'Query failed: ' . mysql_error() );
	
	if ( !$result ) {
			die( 'Query failed: ' . mysql_error() );
	}
	
	if ( mysql_num_rows($result) == 0 ) {

		#echo( "Wrong password" );
		
		include( "reg/header.inc" );
		
		echo( "<h2>Registration details</h2>
		
		<p><font color='#cc0000'>Sorry - that booking id or password
		was incorrect.</font></p>
		
		<p>To review your registration details, please provide
		the booking number and password you received in your
		registration email.</p>" );
		
		$displayid = $candidateid;
		
		include( "reg/login.inc" );
		
		echo( "<p>If you no longer have your booking number or password,
		<a href='lostpw.php'>click here for a reminder</a>.</p> <p>If you have yet to register, <a href='/registration/register_1.php'>visit our registration page first</a>." );
		
		include( "reg/footer.inc" );
		
	} else {
	
	  $person = new BiConAttendee();
		$person->load($candidateid);
		$session->create($person);
  	$session->createCookie(true, true);
		header("Location: $http_host/registration/index.php");
	
	}
}


?>

