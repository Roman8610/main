<?php

namespace app\modules\Qm\dto;

final class ActionResultDTO
{
    public function __construct(
        public readonly bool $success,
        public readonly string $message,
        public readonly ?string $errorCode = null,
        public readonly array $data = [],
    ) {
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'errorCode' => $this->errorCode,
            'data' => $this->data,
        ];
    }
}