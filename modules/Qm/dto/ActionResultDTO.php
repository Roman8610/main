<?php

namespace app\modules\Qm\dto;

final class ActionResultDTO
{
    public function __construct(
        public readonly bool $success,
        public readonly string $message,
        public readonly array $data = [],
        public readonly ?string $errorCode = null,
    ) {}

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'errorCode' => $this->errorCode,
        ];
    }
}
