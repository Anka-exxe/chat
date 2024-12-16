<?php
namespace core\entities;

class Message {
    public $id;
    public $userId;
    public $text;
    public $ipAddress;
    public $userAgent;
    public $createdAt;

    public function __construct(
        int $id, 
        int $userId, 
        string $text, 
        string $ipAddress,
        string $userAgent, 
        $createdAt 
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->text = $text;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
        $this->createdAt = $createdAt;
    }
}
