<?php
 function givecsv($dataArray,$delimiter,$enclosure)
  {
  // Write a line to a file
  // $filePointer = the file resource to write to
  // $dataArray = the data to write out
  // $delimeter = the field separator
 
  // Build the string
  $string = "";
 
  // No leading delimiter
  $writeDelimiter = FALSE;
  foreach($dataArray as $dataElement)
   {
    // Replaces a double quote with two double quotes
    $dataElement=str_replace("\"", "\"\"", $dataElement);
   
    // Adds a delimiter before each field (except the first)
    if($writeDelimiter) $string .= $delimiter;
   
    // Encloses each field with $enclosure and adds it to the string
    $string .= $enclosure . $dataElement . $enclosure;
   
    // Delimiters are used every time except the first.
    $writeDelimiter = TRUE;
   } // end foreach($dataArray as $dataElement)
 
  // Append new line
  $string .= "\n";
 
  // Write the string to the file
  #fwrite($filePointer,$string);

  return $string;
  }

?>
