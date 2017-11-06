<?php


namespace App\Logic;


class Chat
{
    /**
     * @var \mysqli
     */
    private $db;
    /**
     * @var int
     */
    private $chat_id;

    public function __construct(\mysqli $db, int $chat_id)
    {
        $this->db = $db;
        $this->chat_id = $chat_id;
    }

    public function getMessages()
    {
        return $this->db->query("select * from messages where chat_id=$this->chat_id order by dt desc")->fetch_all(MYSQLI_ASSOC);
    }

    public function putMessage($message)
    {
        $stmt = $this->db->prepare("insert into messages set message=?, chat_id=$this->chat_id");
        $stmt->bind_param("s", $message);
        $stmt->execute();
    }
}