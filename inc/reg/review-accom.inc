<h2>Your accommodation details - <font color="#ff0000">PLEASE REVIEW</font></h2>

<p>
Please carefully review these details - your sharing preferences may
not have been correctly recorded, and we may not be able to make
changes at the event.
</p>

<p>
Who would you like to share with?
</p>

<form action="fixaccom.php" method="post">

<input type="hidden" name="formid" value="<?= $candidateid ?>">
<input type="hidden" name="formpass" value="<?= $candidatepass ?>">
<table>

<tr><th>Preference</th><th>Person's name</th></tr>

<?php

echo( "<tr><td><select name='sharewith1'>" );

if ( strcmp( $sharewith1 , "share" ) == 0 ) {

    echo ( "<option value=''>No preference</option><option value='share' SELECTED>I would like to share with</option><option value='notshare'>I would not like to share with</option>" );

} elseif ( strcmp( $sharewith1 , "notshare" ) == 0 ) {

    echo ( "<option value=''>No preference</option><option value='share'>I would like to share with</option><option value='notshare' SELECTED>I would not like to share with</option>" );

} else {

    echo ( "<option value='' SELECTED>No preference</option><option value='share'>I would like to share with</option><option value='notshare'>I would not like to share with</option>" );

}

echo ("</select></td><td><input type='text' name='sharewith1name' value='" . $sharewith1name . "'></td></tr>" );


echo( "<tr><td><select name='sharewith2'>" );

if ( strcmp( $sharewith2 , "share" ) == 0 ) {

    echo ( "<option value=''>No preference</option><option value='share' SELECTED>I would like to share with</option><option value='notshare'>I would not like to share with</option>" );

} elseif ( strcmp( $sharewith2 , "notshare" ) == 0 ) {

    echo ( "<option value=''>No preference</option><option value='share'>I would like to share with</option><option value='notshare' SELECTED>I would not like to share with</option>" );

} else {

    echo ( "<option value='' SELECTED>No preference</option><option value='share'>I would like to share with</option><option value='notshare'>I would not like to share with</option>" );

}

echo ("</select></td><td><input type='text' name='sharewith2name' value='" . $sharewith2name . "'></td></tr>" );


echo( "<tr><td><select name='sharewith3'>" );

if ( strcmp( $sharewith3 , "share" ) == 0 ) {

    echo ( "<option value=''>No preference</option><option value='share' SELECTED>I would like to share with</option><option value='notshare'>I would not like to share with</option>" );

} elseif ( strcmp( $sharewith3 , "notshare" ) == 0 ) {

    echo ( "<option value=''>No preference</option><option value='share'>I would like to share with</option><option value='notshare' SELECTED>I would not like to share with</option>" );

} else {

    echo ( "<option value='' SELECTED>No preference</option><option value='share'>I would like to share with</option><option value='notshare'>I would not like to share with</option>" );

}

echo ("</select></td><td><input type='text' name='sharewith3name' value='" . $sharewith3name . "'></td></tr>" );


?>

<th colspan=2><input type="submit" value="Update sharing details"></th>
</table>

</form>

<p>

<?php

if ( $parkingspace == 1 ) {
    echo( "Parking space requested.<br>" );
} else {
    echo( "No parking space requested.<br>" );
}

if ( strcmp( $flatpref , "ground" ) == 0 ) {
    echo( "Ground floor flat requested." );
} elseif ( strcmp( $flatpref , "higher" ) == 0 ) {
    echo( "First floor or higher flat requested." );
} else {
    echo( "No floor preference requested." );
}

?>

</P>

