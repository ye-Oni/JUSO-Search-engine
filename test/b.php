<?php

$conn = oci_connect('vote', 'vote1324', '203.238.58.195/orcl');
if(!$conn) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
}
else {
   print "Connected to Oracle!";
}
// Close the Oracle connection
oci_close($conn);

?>
