<?php 

require_once 'Attendee.php';
require_once 'Accommodation.php';

// Check whether the person is logged-in.

$logged_in_person = null;
$logged_in = false;

$session = new BiConAttendeeSession();
$logged_in = $session->validate();
if ($logged_in) {
  $logged_in_person_id = $session->getPersonID();
  $logged_in_person = new BiConAttendee();
  $logged_in_person->load($logged_in_person_id);
  if ($session->isCurrent()) {
    $session->refresh();
  }
}


  ?>