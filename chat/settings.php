<?php
require_once("Data/MessageRepository.php");
require_once("Data/AttachmentRepository.php");
require_once("Data/AccountRepository.php");
require_once("Application/Services/MessageService.php");
require_once("Application/Services/AccountService.php");
require_once("Infrastructure/FileUpload.php");
require_once("Constants/ConnectionStrings.php");

use data\repositories\MessageRepository;
use data\repositories\AttachmentRepository;
use data\repositories\AccountRepository;
use application\services\MessageService;
use infrastructure\FileUpload;
use application\services\AccountService;
use constants\ConnectionStrings;

$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);

$messageRepository = new MessageRepository($connection);
$attachmentRepository = new AttachmentRepository($connection);
$accountRepository = new AccountRepository($connection);

$fileUploader = new FileUpload("./Uploads/");

$accountService = new AccountService($accountRepository);
$messageService = new MessageService(
    $messageRepository, 
    $accountRepository, 
    $attachmentRepository, 
    $fileUploader
);