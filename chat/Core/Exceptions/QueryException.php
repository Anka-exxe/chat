<?php
namespace core\exceptions;
use Exception;

class QueryException extends Exception {
    public function __construct($message) {
        parent::__construct($message);
    }
}