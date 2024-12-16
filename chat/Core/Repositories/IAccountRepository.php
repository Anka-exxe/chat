<?php
namespace core\repositories;

interface IAccountRepository extends IBaseRepository {
    public function checkUser(string $username, string $password) : bool;
}