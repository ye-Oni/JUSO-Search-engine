<?php

$conn = oci_connect('juso', 'jo!324', '//green.mk.co.kr/green');
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
