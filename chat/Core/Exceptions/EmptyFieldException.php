<?php
namespace core\exceptions;
use Exception;

class EmptyFieldException extends Exception {
    public function __construct($message) {
        parent::__construct($message);
    }
}
