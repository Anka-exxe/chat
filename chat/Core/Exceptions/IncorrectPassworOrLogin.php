<?php
namespace core\exceptions;
use Exception;

class IncorrectPassworOrLogin extends Exception {
    public function __construct($message) {
        parent::__construct($message);
    }
}
