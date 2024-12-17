<?php
namespace application\dto;

class AddMessageRequest {
    public $username;
    public $ipAddress;
    public $userAgent;
    public $text;

    public function __construct(
        string $username,
        string $ipAddress, 
        string $userAgent, 
        string $text
        ) {
        $this->username = $username;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
        $this->text = $text;
    }
}
