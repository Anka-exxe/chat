<?php
namespace application\dto;

class UploadFileRequest {
    public $path;

    public function __construct(string $path) {
        $this->path = $path;
    }
}
