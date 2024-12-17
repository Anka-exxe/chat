<?php
namespace application\dto;

class LoginRequest {
    public $username;
    public $password;

    public function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;
    }
}
