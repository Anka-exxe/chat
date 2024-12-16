<?php
namespace core\entities;

use core\exceptions;
use core\exceptions\IncorrectValueFieldException;

class Account {
    private $id;
    private $username;
    private $email;
    private $password;

    public function __construct(int $id, string $username, string $email, string $password) {
        $this->id = $id;
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setUsername(string $username) {
        if (empty($username) || strlen($username) < 4) {
            throw new IncorrectValueFieldException(
                "Имя пользователя должно состоять минимум из 4 символов"
            );
        }
        
        $this->username = $username;
    }

    public function setEmail(string $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new IncorrectValueFieldException(
                "Неверный формат email"
            );
        }

        $this->email = $email;
    }

    public function setPassword(string $password) {
        if (strlen($password) < 6) {
            throw new IncorrectValueFieldException(
                "Длина пароля должна составлять минимум 6 символов"
            );
        }

        $this->password = $password; 
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password; 
    }
}
