<?php
namespace application\services;

use core\entities\Account;

require_once("Core/Exceptions/EntityNotFoundException.php");
require_once("Application/Interfaces/IAccountService.php");
require_once("Core/Exceptions/QueryException.php");
require_once("Core/Repositories/IAccountRepository.php");
require_once("Application/DTO/RegistrationRequest.php");
require_once("Application/DTO/LoginRequest.php");

use application\interfaces\IAccountService;
use application\dto\RegistrationRequest;
use application\dto\LoginRequest;
use core\exceptions\EntityNotFoundException;
use core\repositories\IAccountRepository;
use Exception;

class AccountService implements IAccountService {
    private $accountRepository;

    public function __construct(IAccountRepository $accountRepository) {
        $this->accountRepository = $accountRepository;
    }

    public function register(RegistrationRequest $registrationRequest): bool {
        $newUser = new Account(
            0,
            $registrationRequest->username,
            $registrationRequest->email,
            $registrationRequest->password
        );

        try {
            $this->accountRepository->add($newUser);
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function logIn(LoginRequest $loginRequest): bool {
        try {
            return $this->accountRepository->checkUser(
                $loginRequest->username, 
                $loginRequest->password
            );
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getIdByUserName(string $username): int {
        $user = $this->accountRepository->getByUsername($username);
    
        if ($user === null) {
           throw new EntityNotFoundException("Пользователь не найден");
        }
    
        return $user->getId();
    }

    public function getUserById(int $userId) : Account {
        return $this->accountRepository->findById($userId);
    }
}
