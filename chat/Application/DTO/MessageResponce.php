<?php
namespace application\dto;

class MessageResponce {
    public $username;
    public $email;
    public $text;
    public $attachmentUrl;
    public $date;

    public function __construct(
        string $username, 
        string $email, 
        string $text,
        string $attachmentUrl,
        $date
    ) {
        $this->username = $username;
        $this->email =$email;
        $this->text = $text;
        $this->attachmentUrl = $attachmentUrl;
        $this->$date = $date;
    }
}
