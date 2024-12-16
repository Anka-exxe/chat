<?php
namespace core\entities;

class Message {
    private $id;
    private $userId;
    private $text;
    private $ipAddress;
    private $userAgent;
    private $createdAt;

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

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getText() {
        return $this->text;
    }

    public function getIpAddress() {
        return $this->ipAddress;
    }

    public function getUserAgent() {
        return $this->userAgent;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setId($id) {
        $this->id = $id;
    }
}
