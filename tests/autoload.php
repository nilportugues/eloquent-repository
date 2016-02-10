<?php

use Illuminate\Database\Capsule\Manager as Capsule;

include __DIR__.'/../vendor/autoload.php';

file_put_contents(__DIR__.'/database.db', '');
$capsule = new Capsule();
$capsule->addConnection(['driver' => 'sqlite', 'database' => __DIR__.'/database.db', 'prefix' => ''], 'default');
$capsule->bootEloquent();
$capsule->setAsGlobal();
