<?php
require_once("Application/Interfaces/IFileUpload.php");
require_once("Application/DTO/UploadFileRequest.php");

use application\interfaces\IFileUploadService;
use application\dto\UploadFileRequest;

class FileUpload implements IFileUploadService {
    private $newFilePath;

    public function __construct() {
        $this->newFilePath = "";
    }

    public function uploadFile(UploadFileRequest $file) : bool {
        $uploadDir = './Uploads/';
        $imageDestPath = $uploadDir . basename($file->fileName);

        if(move_uploaded_file($file->path, $imageDestPath)) {
            $this->newFilePath = $imageDestPath;
            return true;
        }
        else {
            return false;
        }
    }

    public function getFilePath() : string {
        return $this->newFilePath;
    }
}
