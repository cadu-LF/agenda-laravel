<?php

namespace App\Services\Responses;

class ApiResponse
{
    /**
     * @var bool
     */
    public $success;

    /**
     * @var int
     */
    public $status;

    /**
     * @var mixed
     */
    public $data;

    public function __construct(
        bool $success,
        int $status,
        $data
    ) {
        $this->success = $success;
        $this->status = $status;
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
            'status'        => $this->status,
            'data'           => $this->data
        ];
    }
}
