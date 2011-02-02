<?php
require_once('../../inc/config.inc');

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');

$accommodation_matrix = new BiConAccommodation();
$room_labels = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
$days = array('Tue (24)', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun', 'Mon', 'Tue (31)');
?>
<html>
<head>
<title>Bicon 2010 accommodation list</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="/static/admin.css">
</head>

<body>

<p>
<a href="vol.php">Volunteers</a> | <a href="ws.php">Run workshop</a> | <a href="hh.php">Helping Hand</a> | <a href="accom.php">Accommodation</a> | <a href="counselling.php">Counselling</a> | <a href="firstaid.php">First aid</a>
| <a href="recep.php">Reception &amp; Gopher</a> | <a href="kids.php">Kids</a> | <a href="access.php">Access needs</a> | 
<a href="index.php">All entries</a></p>

<h1>Templars</h1>

<h2>Ground floor</h2>
<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('T', 1, 7) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 2, 1) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 3, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 4, 6) ?> 
</div>

<br clear="both">

<h2>First floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('T', 6, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 7, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 8, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 9, 6) ?> 
</div>

<br clear="both">

<h2>Second floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('T', 11, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 12, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 13, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 14, 6) ?> 
</div>

<br clear="both">

<h2>Third floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('T', 16, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 17, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 18, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 19, 6) ?> 
</div>

<br clear="both">

<h2>Fourth floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('T', 20, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 21, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 22, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 23, 6) ?> 
</div>

<br clear="both">

<h2>Fifth floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('T', 24, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 25, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 26, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 27, 6) ?> 
</div>

<br clear="both">

<h2>Sixth floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('T', 28, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 29, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 30, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('T', 31, 6) ?> 
</div>

<br clear="both">


<h1>Shepherd</h1>

<h2>Ground floor</h2>
<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('S', 1, 7) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 2, 1) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 3, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 4, 6) ?> 
</div>

<br clear="both">

<h2>First floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('S', 6, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 7, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 8, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 9, 6) ?> 
</div>

<br clear="both">

<h2>Second floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('S', 11, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 12, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 13, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 14, 6) ?> 
</div>

<br clear="both">

<h2>Third floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('S', 16, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 17, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 18, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 19, 6) ?> 
</div>

<br clear="both">

<h2>Fourth floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('S', 20, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 21, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 22, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 23, 6) ?> 
</div>

<br clear="both">

<h2>Fifth floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('S', 24, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 25, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 26, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 27, 6) ?> 
</div>

<br clear="both">

<h2>Sixth floor</h2>

<div class="panel_board">
<?= $accommodation_matrix->divFlatDetails('S', 28, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 29, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 30, 6) ?> 
<?= $accommodation_matrix->divFlatDetails('S', 31, 6) ?> 
</div>

<br clear="both">

</body>
</html>