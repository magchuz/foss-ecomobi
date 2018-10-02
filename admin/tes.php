<?php

// load the data and delete the line from the array
$lines = file('../sitemap.xml');
$last = sizeof($lines) - 1 ;
unset($lines[$last]);
?>