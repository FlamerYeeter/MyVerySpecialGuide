<?php
$s = stream_get_contents(STDIN);
file_put_contents(__DIR__ . '/stdin_dump.json', $s);
echo "WROTE\n";
?>