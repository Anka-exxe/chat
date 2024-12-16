<?php
namespace core\entities;

class Attachment {
    private $id;
    private $messageId;
    private $filePath;
    private $fileType;

    public function __construct(int $id, int $messageId, string $filePath, string $fileType) {
        $this->id = $id;
        $this->messageId = $messageId;
        $this->filePath = $filePath;
        $this->fileType = $fileType;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getMessageId(): int {
        return $this->messageId;
    }

    public function getFilePath(): string {
        return $this->filePath;
    }

    public function getFileType(): string {
        return $this->fileType;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setMessageId(int $messageId): void {
        $this->messageId = $messageId;
    }

    public function setFilePath(string $filePath): void {
        $this->filePath = $filePath;
    }

    public function setFileType(string $fileType): void {
        $this->fileType = $fileType;
    }
}
