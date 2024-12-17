<?php
namespace data\repositories;

require_once("Core/Entities/Message.php");
require_once("Core/Repositories/IMessageRepository.php");
require_once("Core/Exceptions/QueryException.php");

use mysqli;
use core\entities\Message;
use core\repositories\IMessageRepository;
use core\exceptions\QueryException;

class MessageRepository implements IMessageRepository {
    private $connection;

    public function __construct(mysqli $connection) {
        $this->connection = $connection;
    }

    public function findById(int $id) {
        $sql = "SELECT * FROM message WHERE id = $id";

        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);
                return new Message(
                    $data['id'],
                    $data['user_id'],
                    $data['text'],
                    $data['ip_address'],
                    $data['user_agent'],
                    $data['created_at']
                );
            }
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }

        return null;
    }

    public function getAll(): array {
        $sql = "SELECT * FROM message";
        $result = mysqli_query($this->connection, $sql);
        $messages = [];

        if ($result) {
            while ($data = mysqli_fetch_assoc($result)) {
                $messages[] = new Message(
                    $data['id'],
                    $data['user_id'],
                    $data['text'],
                    $data['ip_address'],
                    $data['user_agent'],
                    $data['created_at']
                );
            }
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }

        return $messages;
    }

    public function add($entity) {
        $userId = $entity->getUserId();
        $text = mysqli_real_escape_string($this->connection, $entity->getText());
        $ipAddress = mysqli_real_escape_string($this->connection, $entity->getIpAddress());
        $userAgent = mysqli_real_escape_string($this->connection, $entity->getUserAgent());

        $sql = "INSERT INTO message 
        (user_id, text, ip_address, user_agent) 
        VALUES ($userId, '$text', '$ipAddress', '$userAgent')";
        
        if (mysqli_query($this->connection, $sql)) {
            $entity->setId(mysqli_insert_id($this->connection));
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM message WHERE id = $id";
        
        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            throw new QueryException(
                "Ошибка выполнения запроса: " . 
                mysqli_error($this->connection)
            );
        }
    }
}
