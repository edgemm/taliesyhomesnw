<?php

// This script allows IE to execute Javascript .htc files by serving up 
// the file with the correct MIME type (missing on some servers).


header('Content-type: text/x-component');
include('csshover3.htc');

?>