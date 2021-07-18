<?php

use Bot\Webhook;

require_once(__DIR__.'/../vendor/autoload.php');

$webhook = new Webhook(__DIR__.'/../');
$webhook->exec();