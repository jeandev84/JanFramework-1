<?php
use Jan\Foundation\Facades\Console;


Console::shedule('hello', function (Command $command) {
    $command->setDescription('Say hello world');
});