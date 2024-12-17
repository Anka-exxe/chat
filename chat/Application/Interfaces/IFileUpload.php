<?php
namespace application\interfaces;

require_once("Application/DTO/UploadFileRequest.php");

use application\dto\UploadFileRequest;

interface IFileUploadService{
    public function uploadFile(UploadFileRequest $file) : bool;
    public function getFilePath() : string;
}
