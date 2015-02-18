<?php
$Contact = $_REQUEST['request'];

$file = 'contacts.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= "$Contact\n";
// Write the contents back to the file
file_put_contents($file, $current);

echo "Contact Added to retry file Successfully";

?>