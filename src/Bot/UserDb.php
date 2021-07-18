<?php

namespace Bot;

/**
 * UserDb
 */
trait UserDb
{

    var string $userDbFn;
    var array $userDb;

    private function initUserDb(string $basedir):void {
        $this->userDbFn = $basedir.'/subscribers.json';
        if (file_exists($this->userDbFn)) {
            $this->userDb = json_decode(file_get_contents($this->userDbFn), true);
        }
        else {
            $this->userDb = [];
        }
    }

    private function persistUserDb(): void {
        file_put_contents($this->userDbFn, json_encode($this->userDb));
    }



}