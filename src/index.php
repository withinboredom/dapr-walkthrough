<?php

require_once __DIR__.'/../vendor/autoload.php';

use Dapr\App;

$app = App::create(configure: fn(\DI\ContainerBuilder $builder) => $builder->addDefinitions(__DIR__.'/config.php'));


$app->start();
