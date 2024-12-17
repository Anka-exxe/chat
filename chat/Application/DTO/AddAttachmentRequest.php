<?php
namespace application\dto;

class AddAttachmentRequest {
    public $name;
    public $path;
    public $type;

    public function __construct(string $name, string $path, string $type) {
        $this->name = $name;
        $this->path = $path;
        $this->type = $type;
    }
}
