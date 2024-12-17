<?php
session_start();

if (empty($_SESSION["username"])) {
    echo "Необходимо войти или зарегистрироваться";
    echo "<br><a href = login.html>Вход</a>";
    exit();
}

require_once("settings.php");
require_once("Application/DTO/AddMessageRequest.php");
require_once("Application/DTO/AddAttachmentRequest.php");

use application\dto\AddMessageRequest;
use application\dto\AddAttachmentRequest;

$file = null;

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['file'];
    $name = $file['name'];
    $tmpPath = $file['tmp_name'];
    $type = $file['type'];
    $size = $file['size'];

    $allowedImageTypes = ['image/jpeg', 'image/gif', 'image/png'];
    $allowedTextType = 'text/plain';

    if (in_array($type, $allowedImageTypes)) {
        list($width, $height) = getimagesize($tmpPath);
        if ($width > 320 || $height > 240) {
            echo "Ошибка: изображение должно быть не более 320x240 пикселей.";
            echo "<br><a href = chat.php>Назад</a>";
            exit;
        }
    } elseif ($type == $allowedTextType) {
        if ($size > 100 * 1024) {
            echo "Ошибка: размер файла не должен превышать 100 Кб.";
            echo "<br><a href = chat.php>Назад</a>";
            exit;
        }
    } else {
        echo "Ошибка: допустимые форматы файлов - JPG, GIF, PNG и TXT.";
        echo "<br><a href = chat.php>Назад</a>";
        exit;
    }
}

$newMessage = new AddMessageRequest (
    $_POST["username"],
    $_SERVER['REMOTE_ADDR'],
    $_SERVER['HTTP_USER_AGENT'],
    htmlspecialchars($_POST["text"])
);

$newAttachment = null;

if (isset($file)) {
    $name = $file['name'];
    $path = $file['tmp_name'];
    $type = $file['type'];

    $newAttachment = new AddAttachmentRequest(
        $name, 
        $path, 
        $type
    );
}


$messageService->addMessage($newMessage, $newAttachment);

$_POST = [];
$_FILES = [];

header("Location: http://localhost:3000/chat/chat.php");
exit();
?>
