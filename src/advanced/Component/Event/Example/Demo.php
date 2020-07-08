<?php

# User Entity
use App\Entity\User;
use App\Events\User\UserSignedIn;
use Jan\Component\Event\Dispatcher;

$user = new User();
$user->setId(1);
$user->setEmail('jeanyao@ymail.com');


# Dispatcher object and add listeners for specific event
$dispatcher = new Dispatcher();

$listeners = [
  'UserSignedIn' => [
      new \App\Listeners\User\SendSigninEmail(),
      new \App\Listeners\User\UpdateLastSignInDate()
  ]
];

foreach ($listeners as $key => $lists)
{
    foreach ($lists as $listener)
    {
        $dispatcher->addListener($key, $listener);
    }
}

/*
$dispatcher->addListener('UserSignedIn', new SendSigninEmail());
$dispatcher->addListener('UserSignedIn', new UpdateLastSignInDate());
*/

$event = new UserSignedIn($user);
$dispatcher->dispatch($event);