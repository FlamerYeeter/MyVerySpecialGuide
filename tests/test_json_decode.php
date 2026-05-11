<?php
$input = stream_get_contents(STDIN);
$decoded = json_decode($input, true);
file_put_contents(__DIR__ . '/json_decode_result.txt', var_export($decoded, true));
echo "DONE\n";
?>