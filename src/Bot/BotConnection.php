<?php

namespace Bot;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

/**
 * BotConnection
 */
trait BotConnection
{
    var CurlHTTPClient $httpClient;
    var LINEBot $bot;

    private function initBotConnection($basedir) {
        $secrets = json_decode(file_get_contents($basedir.'/botsecrets.json'));
        $this->httpClient = new CurlHTTPClient($secrets->channelToken);
        $this->bot = new LINEBot($this->httpClient, ['channelSecret' => $secrets->channelSecret]);
    }
}