<?php
namespace core\exceptions;
use Exception;

class IncorrectValueFieldException extends Exception {
    public function __construct($message) {
        parent::__construct($message);
    }
}
