# Minimal line notification bot

## Commands

- **sub**: subscribe to system messages
- **unsub**: unsubscribe
- **uptime**: system uptime

## Installation

Set public as webroot, responds on /webhook.php.


Create a botsecrets.json file in the root directory with bot channel secrets.
Create a subscribers.json file in the same directory, writable by php, initial content: `[]`


```json
{
  "channelToken": "xxxx",
  "channelSecret": "xxxx"
}

```

## System message

Use sysmsg.php:

`php sysmsg.php -v "hello"`

This will send the message to all subscribers.

## Unlicense

Unlicense. Use as you wish.

## Disclamer

This is an internal project with very limited functionality.