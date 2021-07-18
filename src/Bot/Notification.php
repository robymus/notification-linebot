<?php

namespace Bot;

use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\Narrowcast\Recipient\AudienceRecipientBuilder;

/**
 * Notification
 */
class Notification
{
    use BotConnection;
    use UserDb;

    public function __construct(string $basedir)
    {
        $this->initBotConnection($basedir);
        $this->initUserDb($basedir);
    }

    public function sendText($text, $verbose = false)
    {
        if (count($this->userDb) == 0) {
            if ($verbose) echo "No subscribers\n";
            exit(1);
        }
        foreach ($this->userDb as $userid) {
            if ($verbose) echo "'$text' => $userid\n";
            $this->bot->pushMessage($userid, new TextMessageBuilder($text));
        }
    }
}