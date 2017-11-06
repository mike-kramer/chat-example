<?php


namespace App\Controllers;


use App\Logic\Chat;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;

class ChatController
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /* @var \phpcent\Client */
    private $centrifuge;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->centrifuge = $this->container->centrifuge;
    }

    public function messages($request, $response, $args)
    {
        $chat = new Chat($this->container->get("db"), $args["chat_id"]);
        $messages = $chat->getMessages();
        return $this->container->renderer->render($response, "messages.phtml", ["messages" => $messages]);
    }

    public function putMessage(Request $request, $response, $args)
    {
        $chat = new Chat($this->container->get("db"), $args["chat_id"]);
        $chat->putMessage($request->getParsedBodyParam("message"));
        $this->centrifuge->publish("chat#$args[chat_id]", ["action" => "updated"]);
    }

    public function chat($request, $response, $args)
    {
        return $this->container->renderer->render($response, "chat.phtml", [
            "chat_id" => $args["chat_id"],
            "centrifugeToken" => $this->centrifuge->generateClientToken($args["chat_id"], $t = time()),
            "timestamp" => $t,
        ]);
    }
}