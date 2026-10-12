<?php

namespace app\modules\Qm\dto;

final class ChatMessageResult{
        public function __construct(
        public readonly string $message,
        public readonly string|null $type = null,
        public readonly array $data = [],
    ) {}
}