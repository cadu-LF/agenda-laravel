<?php

namespace App\Services\Responses;

class ServiceResponse
{
    /**
     * @var bool
     */
    public $success;

    /**
     * @var string
     */
    public $message;

    /**
     * @var mixed
     */
    public $data;

    public function __construct(
        bool $success,
        string $message,
        $data
    ) {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Retorna as propriedades dessa classe em array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'success'        => $this->success,
            'message'        => $this->message,
            'data'           => $this->data
        ];
    }
}
