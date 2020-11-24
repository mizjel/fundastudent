<?php

namespace App\Services;

trait ToastrServiceTrait
{
    private $message;
    private $message_type;

    public function toastInfo($message){
        $this->message_type = 'info';
        $this->message = $message;

        return $this->getToastr();
    }

    public function toastWarning($message){
        $this->message_type = 'warning';
        $this->message = $message;

        return $this->getToastr();
    }

    public function toastSuccess($message){
        $this->message_type = 'success';
        $this->message = $message;

        return $this->getToastr();
    }

    public function toastError($message){
        $this->message_type = 'error';
        $this->message = $message;

        return $this->getToastr();
    }

    //Return message, that is being processed in app.blade in javascript
    private function getToastr(){
        return [
            'message' => $this->message,
            'type' => $this->message_type
        ];
    }
}