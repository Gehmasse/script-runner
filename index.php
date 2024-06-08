<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new App\App($argv);

if($app->script() === null) {
    die($app->list() . PHP_EOL);
}

$app->run();

echo PHP_EOL;
