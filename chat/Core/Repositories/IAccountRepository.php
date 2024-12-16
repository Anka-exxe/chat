<?php
namespace core\repositories;

require_once("Core/Repositories/IBaseRepository.php");

interface IAccountRepository extends IBaseRepository {
    public function checkUser(string $username, string $password) : bool;
}
