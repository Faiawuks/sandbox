<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Knp\Provider\ConsoleServiceProvider(), array(
    'console.name'              => 'Sandbox',
    'console.version'           => '0.0.1',
    'console.project_directory' => __DIR__ . '/..'
));

$app->register(new Auction\Container());

return $app;
