<?php

use App\Controllers\ChatController;
use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get("/messages/{chat_id}", ChatController::class . ":messages");
$app->post("/putMessage/{chat_id}", ChatController::class . ":putMessage");
$app->get("/chat/{chat_id}", ChatController::class . ":chat");
$app->get("/hren", function () {die("hren");});
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
