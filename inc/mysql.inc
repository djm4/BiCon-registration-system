<?php

       function FncChangeTimestamp ($svDate, $svDateOutput)
        {
                $year = substr($svDate,0,4);
                $month = substr($svDate,4,2);
                $day = substr($svDate,6,2);
                $hour = substr($svDate,8,2);
                $minute= substr($svDate,10,2);
                $sec = substr($svDate,12,2);

                $svDateOutput = ereg_replace ("YYYY", $year, $svDateOutput);
                $svDateOutput = ereg_replace ("MM", $month, $svDateOutput);
                $svDateOutput = ereg_replace ("DD", $day, $svDateOutput);
                $svDateOutput = ereg_replace ("hh", $hour, $svDateOutput);
                $svDateOutput = ereg_replace ("mm", $minute, $svDateOutput);
                $svDateOutput = ereg_replace ("ss", $sec, $svDateOutput);
                
                return $svDateOutput;
        };


function quote_smart($value)
{
   // Stripslashes
   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }
   // Quote if not a number or a numeric string
   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value) . "'";
   }
   return $value;
}

$link = mysql_connect( $mysql_host , $mysql_user , $mysql_pass ) or die( 'Could not connect: ' . mysql_error() );
mysql_select_db( $mysql_db ) or die( 'Could not select database' );



?>
