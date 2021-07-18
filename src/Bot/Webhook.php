<?php

namespace Bot;

use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

/**
 * Webhook
 */
class Webhook
{
    use BotConnection;
    use UserDb;

    public function __construct(string $bbasedir)
    {
        $this->initBotConnection($bbasedir);
        $this->initUserDb($bbasedir);
    }

    public function exec(): void {
        $headers = getallheaders();
        $signature = $headers['X-Line-Signature'];
        if (empty($signature)) {
            http_response_code(401);
            die('Bad Request');
        }

        try {
            $requestBody = file_get_contents('php://input');
            $events = $this->bot->parseEventRequest($requestBody, $signature);
        }
        catch (InvalidSignatureException $e) {
            http_response_code(400);
            die('Invalid Signature');
        }
        catch (InvalidEventRequestException $e) {
            http_response_code(400);
            die('Invalid Event Request');
        }

        foreach ($events as $event) {
            if (!($event instanceof MessageEvent)) {
                continue;
            }
            if (!($event instanceof MessageEvent\TextMessage)) {
                continue;
            }

            $text = $event->getText();
            switch (strtolower($text)) {
                case 'sub':
                    $reply = $this->sub($event);
                    break;
                case 'unsub':
                    $reply = $this->unsub($event);
                    break;
                case 'uptime':
                    $reply = shell_exec('uptime');
                    break;
                default:
                    $reply = "This bot is dump, sorry. ($text)";
            }
            $this->bot->replyText($event->getReplyToken(), $reply);
        }
    }

    private function sub(MessageEvent $event): string {
        $userid = $event->getUserId();
        if (!in_array($userid, $this->userDb)) {
            $this->userDb[] = $userid;
            $this->persistUserDb();
            return "Successfully subscribed [#$userid]";
        }
        else {
            return "Already subscribed [$userid]";
        }
    }

    private function unsub(MessageEvent $event): string {
        $userid = $event->getUserId();
        $key = array_search($userid, $this->userDb);
        if ($key !== false) {
            unset($this->userDb[$key]);
            $this->persistUserDb();
            return "Successfully unsubscribed [$userid]";
        }
        else {
            return "Not subscribed [$userid]";
        }
    }

}