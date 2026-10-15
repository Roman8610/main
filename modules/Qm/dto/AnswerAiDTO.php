<?php

namespace app\modules\Qm\dto;

final class AnswerAiDTO{
        public function __construct(
        public readonly string $message,
        public readonly string $action = '',
        public readonly array $param = [],
    ) {}
}