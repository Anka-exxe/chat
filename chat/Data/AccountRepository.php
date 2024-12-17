<?php
namespace data\repositories;

require_once("Core/Entities/Account.php");
require_once("Core/Repositories/IAccountRepository.php");
require_once("Core/Exceptions/QueryException.php");

use mysqli;
use core\entities\Account;
use core\repositories\IAccountRepository;
use core\exceptions\QueryException;

class AccountRepository implements IAccountRepository {
    private $connection;

    public function __construct(mysqli $connection) {
        $this->connection = $connection;
    }

    public function findById(int $id) {
        $sql = "SELECT id, username, email, password FROM account WHERE id = $id";
        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);
                return new Account(
                    $data['id'], 
                    $data['username'], 
                    $data['email'], 
                    $data['password']
                );
            }
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }

        return null;
    }

    public function getAll(): array {
        $sql = "SELECT id, username, email, password FROM account";
        $result = mysqli_query($this->connection, $sql);
        $accounts = [];

        if ($result) {
            while ($data = mysqli_fetch_assoc($result)) {
                $accounts[] = new Account(
                    $data['id'], 
                    $data['username'], 
                    $data['email'], 
                    $data['password']
                );
            }
        } else {
            throw new QueryException("Ошибка выполнения запроса: " . mysqli_error($this->connection));
        }

        return $accounts;
    }

    public function add($entity) {
        $username = mysqli_real_escape_string(
            $this->connection,
             $entity->getUsername()
        );
        $email = mysqli_real_escape_string(
            $this->connection, 
            $entity->getEmail()
        );
        $password = mysqli_real_escape_string(
            $this->connection, 
            $entity->getPassword()
        );
    
        $sql = "INSERT INTO account (`username`, `email`, `password`) VALUES ('$username', '$email', '$password')";
        
        if (mysqli_query($this->connection, $sql)) {
            $entity->setId(mysqli_insert_id($this->connection));
        } else {
            throw new QueryException("Ошибка выполнения запроса: " . mysqli_error($this->connection));
        }
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM account WHERE id = $id";
        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }
    }

    public function getByUsername(string $username) {
        $username = mysqli_real_escape_string($this->connection, $username);
        $sql = "SELECT * FROM account WHERE username = '$username'";
    
        $result = mysqli_query($this->connection, $sql);
    
        if (!$result) {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }
    
        $data = mysqli_fetch_assoc($result);
        if ($data) {
            return new Account(
                $data['id'], 
                $data['username'], 
                $data['email'], 
                $data['password']
            );
        } else {
            return null;
        }
    }

    public function checkUser(string $username, string $password): bool {
        $username = mysqli_real_escape_string(
            $this->connection,
             $username
            );
        $sql = "SELECT password FROM account WHERE username = '$username'";
        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);
                return $password == $data['password'];
            }
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }

        return false;
    }

    public function getEmailByUserName(string $username) {
        $user = $this->getByUsername($username);

        return $user->getEmail();
    }
}
