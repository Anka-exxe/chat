<?php
namespace core\repositories;

require_once("Core/Repositories/IBaseRepository.php");

interface IBaseRepository {
    public function findById(int $id);
    public function getAll(): array;
    public function add($entity);
    public function delete(int $id): bool;
}
