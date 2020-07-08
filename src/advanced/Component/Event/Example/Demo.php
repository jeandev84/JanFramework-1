<?php

# User Entity
$user = new User();
$user->setId(1);
$user->setEmail('jeanyao@ymail.com');


# Dispatcher object and add listeners for specific event
$dispatcher = new Dispatcher();

$dispatcher->addListener('UserSignedIn', new SendSigninEmail());
$dispatcher->addListener('UserSignedIn', new UpdateLastSignInDate());


$event = new UserSignedIn($user);
$dispatcher->dispatch($event);