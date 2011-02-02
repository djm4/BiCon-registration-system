<?php 

// Work out which event they're registering for. Default to BiCon.

$event = 'BiCon';
$event_longer = 'BiCon/ICB';

if ($logged_in && $logged_in_person->event != '') {
  $event = $logged_in_person->event;
}

if (isset($_GET['event']) && $_GET['event'] != '') {
  $event = $_GET['event'];
}

if ($event == 'BiReCon') {
  $event_longer = 'BiReCon';
} elseif ($event == 'BiReCon and BiCon') {
  $event_longer = 'BiReCon and BiCon/ICB';
}

?>