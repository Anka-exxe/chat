<?php
namespace core\exceptions;
use Exception;

class EntityNotFoundException extends Exception {
    public function __construct($message) {
        parent::__construct($message);
    }
}
