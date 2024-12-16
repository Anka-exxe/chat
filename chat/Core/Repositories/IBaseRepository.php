<?php
namespace core\repositories;

interface IBaseRepository {
    public function findById(int $id);
    public function getAll(): array;
    public function add($entity);
    public function delete(int $id): bool;
}
