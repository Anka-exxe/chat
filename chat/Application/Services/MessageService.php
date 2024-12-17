<?php
namespace application\services;

require_once("Core/Repositories/IAttachmentRepository.php");
require_once("Application/Interfaces/IMessageService.php");
require_once("Core/Repositories/IAccountRepository.php");
require_once("Core/Entities/Message.php");
require_once("Core/Entities/Attachment.php");
require_once("Application/DTO/AddMessageRequest.php");
require_once("Application/DTO/AddAttachmentRequest.php");
require_once("Core/Exceptions/QueryException.php");
require_once("Core/Entities/Account.php");
require_once("Application/Interfaces/IFileUpload");
require_once("Application/DTO/UploadFileRequest.php");

use core\repositories\IAttachmentRepository;
use application\interfaces\IMessageService;
use application\dto\AddMessageRequest;
use application\dto\AddAttachmentRequest;
use application\dto\MessageResponce;
use data\repositories\MessageRepository;
use core\entities\Message;
use core\exceptions\QueryException;
use core\repositories\IAccountRepository;
use core\repositories\IMessageRepository;
use application\interfaces\IFileUploadService;
use application\dto\UploadFileRequest;
use core\entities\Attachment;
use Exception;

class MessageService implements IMessageService {
    private $messageRepository;
    private $accountRepository;
    private $attachmentRepository;
    private $fileUploadService;

    public function __construct(
        IMessageRepository $messageRepository, 
        IAccountRepository $accountRepository,
        IAttachmentRepository $attachmentRepository,
        IFileUploadService $fileUploadService
    ) {
        $this->messageRepository = $messageRepository;
        $this->accountRepository = $accountRepository;
        $this->attachmentRepository = $attachmentRepository;
        $this->fileUploadService = $fileUploadService;
    }

    public function addMessage(AddMessageRequest $messageRequest, AddAttachmentRequest $attachment = null) {
        $fileToUpload = new UploadFileRequest(
            $attachment->path
        );
        
        try {
            $this->fileUploadService->uploadFile($fileToUpload);
        } catch(Exception $e) {
            throw $e;
        }

        $message = new Message(
            0,
            $this->getUserIdByUsername($messageRequest->username),
            $messageRequest->text,
            $messageRequest->ipAddress,
            $messageRequest->userAgent,
            date('Y-m-d H:i:s')
        );

        try {
            $this->messageRepository->add($message);

            if ($attachment) {
                $newAttachment = new Attachment(
                    $message->getId(), 
                    0,
                    $attachment->$fileToUpload->getFilePath,
                    $attachment->type
                );
            }
        } catch (QueryException $e) {
            throw new QueryException("Error adding message: " . $e->getMessage());
        }
    }

    public function getMessages(): array {
        $messageArray = $this->messageRepository->getAll();
        $fullMessageInfo = [];

        foreach($messageArray as $message) {
            $user = $this->accountRepository->findById($message->getUserId());
            $attachment = $this->attachmentRepository->findByMessageId($message->getId());

            $fullMessageInfo[] = new MessageResponce(
                $user->getUsername(),
                $user->getEmail(),
                $message->getText(),
                $attachment->getFilePath(),
                $message->getCreatedAt()
            );
        }

        return $fullMessageInfo();
    }

    private function getUserIdByUsername(string $username) {
        $user = $this->accountRepository->getByUsername($username);
        return $user->getId();
    }
}