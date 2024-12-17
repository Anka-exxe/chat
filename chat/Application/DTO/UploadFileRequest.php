<?php
namespace application\dto;

class UploadFileRequest {
    public $fileName;
    public $path;

    public function __construct(string $fileName, string $path) {
        $this->fileName = $fileName;
        $this->path = $path;
    }
}
