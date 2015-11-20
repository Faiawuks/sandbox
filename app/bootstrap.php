<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Knp\Provider\ConsoleServiceProvider;

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new ConsoleServiceProvider(), array(
    'console.name'              => 'Sandbox',
    'console.version'           => '0.0.1',
    'console.project_directory' => __DIR__ . '/..'
));

return $app;
