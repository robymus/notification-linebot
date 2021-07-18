<?php
require_once(__DIR__.'/vendor/autoload.php');

$verbose = false;
$idx = 1;
if (count($argv) > $idx && $argv[$idx] == '-v') {
    $verbose = true;
    ++$idx;
}

if (count($argv) > $idx) {
    $message = implode(' ', array_slice($argv, $idx));
}
else {
    echo "Usage: sysmsg.php [-v] message\n";
    exit(1);
}

$notification = new \Bot\Notification(__DIR__);
$notification->sendText($message, $verbose);