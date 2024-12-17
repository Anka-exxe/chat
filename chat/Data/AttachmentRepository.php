<?php
namespace data\repositories;

require_once("Core/Entities/Attachment.php");
require_once("Core/Repositories/IAttachmentRepository.php");
require_once("Core/Exceptions/QueryException.php");

use mysqli;
use core\entities\Attachment;
use core\repositories\IAttachmentRepository;
use core\exceptions\QueryException;

class AttachmentRepository implements IAttachmentRepository {
    private $connection;

    public function __construct(mysqli $connection) {
        $this->connection = $connection;
    }

    public function findById(int $id) {
        $sql = "SELECT id, message_id, file_path, file_type FROM attachment WHERE id = $id";
        $result = mysqli_query($this->connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            return new Attachment(
                $data['id'], 
                $data['message_id'], 
                $data['file_path'], 
                $data['file_type']
            );
        }

        return null;
    }

    public function getAll(): array {
        $sql = "SELECT id, message_id, file_path, file_type FROM attachment";
        $result = mysqli_query($this->connection, $sql);
        $attachments = [];

        if ($result) {
            while ($data = mysqli_fetch_assoc($result)) {
                $attachments[] = new Attachment(
                    $data['id'], 
                    $data['message_id'], 
                    $data['file_path'], 
                    $data['file_type']
                );
            }
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }

        return $attachments;
    }

    public function add($entity) {
        $message_id = $entity->getMessageId();
        $file_path = mysqli_real_escape_string(
            $this->connection, 
            $entity->getFilePath()
        );
        $file_type = mysqli_real_escape_string(
            $this->connection, 
            $entity->getFileType()
        );

        $sql = "INSERT INTO attachment (message_id, file_path, file_type) 
        VALUES ($message_id, '$file_path', '$file_type')";
        
        if (mysqli_query($this->connection, $sql)) {
            $entity->setId(mysqli_insert_id($this->connection));
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }
    }

    public function findByMessageId(int $messageId) {
        $messageId = mysqli_real_escape_string(
            $this->connection,
            $messageId
        );

        $sql = "SELECT FROM attachment WHERE message_id = $messageId";

        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            $attachmentInfo = mysqli_fetch_assoc($result);

            return new Attachment(
                $attachmentInfo['id'], 
                $attachmentInfo['message_id'], 
                $attachmentInfo['file_path'], 
                $attachmentInfo['file_type']
            );
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }

    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM attachment WHERE id = $id";
        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " 
                . mysqli_error($this->connection)
            );
        }
    }
}
