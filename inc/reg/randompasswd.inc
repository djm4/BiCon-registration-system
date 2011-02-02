<?php

function Random_Password($length) { 
    srand(date("s")); 
    $possible_charactors = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
    $string = ""; 
    while(strlen($string)<$length) { 
        $string .= substr($possible_charactors, rand()%(strlen($possible_charactors)),1); 
    } 
    return($string); 
}

?>
