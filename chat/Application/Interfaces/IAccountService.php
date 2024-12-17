<?php
namespace application\interfaces;

require_once("Application/DTO/RegistrationRequest.php");
require_once("Application/DTO/LoginRequest.php");
require_once("Core/Entities/Account.php");

use application\dto\LoginRequest;
use application\dto\RegistrationRequest;
use core\entities\Account;

interface IAccountService {
    public function register(RegistrationRequest $registrationRequest) : bool;
    public function logIn(LoginRequest $loginRequest) : bool;
    public function getIdByUserName(string $username) : int;
    public function getUserById(int $userId) : Account;
    public function getEmailByUserName(string $username);
}
