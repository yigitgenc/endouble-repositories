<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Config\Database;
use App\Repositories\ExampleRepository;

$capsule = new Capsule;
$capsule->addConnection(Database::getConfig('albert'), 'albert');
$capsule->addConnection(Database::getConfig('booking'), 'booking');
$capsule->bootEloquent();

$exampleRepository = new ExampleRepository();
$exampleRepository->addSource('test')
    ->addSource('albert')
    ->addSource('booking');

$exampleRepository->setSource('booking');

$data = [
    "title" => "Example",
    "content" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
    "description" => "This is a description."
];

$exampleRepository->insert($data);
