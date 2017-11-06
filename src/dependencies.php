<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Database
$container['db'] = function ($c) {
    $dbConf = $c->get('settings')["db"];
    $db = new mysqli("localhost", $dbConf["user"], $dbConf["password"], $dbConf["db"]);
    $db->set_charset("utf8");
    return $db;
};

$container["centrifuge"] = function ($c) {
    $client = new \phpcent\Client("http://localhost:8000");
    $client->setSecret("e9da31f6-608f-436a-8398-bda324d202ad");
    return $client;
};