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

$app->singleton(Jan\Contracts\Http\Kernel::class, function ($app) {
    return new \App\Http\Kernel($app);
});


$app->singleton(Jan\Contracts\Console\Kernel::class, function ($app) {
    return new \App\Console\Kernel($app);
});


$app->singleton(Jan\Contracts\Debug\ExceptionHandler::class, function ($app) {
    return new \App\Exceptions\ErrorHandler(new \Exception());
});


/*
|-------------------------------------------------------------------
|    Return instance of application
|-------------------------------------------------------------------
*/
return $app;

