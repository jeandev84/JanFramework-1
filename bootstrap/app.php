<?php
/*
|-------------------------------------------------------------------
|    Create new application
|-------------------------------------------------------------------
*/


$app = new \Jan\Foundation\Application(
    realpath(__DIR__.'/../')
);



/*
|-------------------------------------------------------------------
|    Binds importants interfaces of application
|-------------------------------------------------------------------
*/

$app->singleton(
Jan\Contracts\Http\Kernel::class,
App\Http\Kernel::class
);

$app->singleton(
Jan\Contracts\Console\Kernel::class,
App\Console\Kernel::class
);

$app->singleton(
Jan\Contracts\Debug\ExceptionHandler::class,
App\Exceptions\ErrorHandler::class
);


/*
|-------------------------------------------------------------------
|    Return instance of application
|-------------------------------------------------------------------
*/
return $app;

