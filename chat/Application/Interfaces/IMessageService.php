<?php
namespace application\interfaces;

require_once("Application/DTO/AddMessageRequest.php");
require_once("Application/DTO/AddAttachmentRequest.php");

use application\dto\AddMessageRequest;
use application\dto\AddAttachmentRequest;

interface IMessageService {
    public function addMessage(
        AddMessageRequest $message, 
        AddAttachmentRequest $attachment = null
    );
    public function getMessages() : array;
}
