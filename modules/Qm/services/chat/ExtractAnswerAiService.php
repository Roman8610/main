<?php

namespace app\modules\Qm\services\chat;

use app\modules\Qm\dto\AnswerAiDTO;

class ExtractAnswerAiService
{
    public function run($answer):AnswerAiDTO {
        return new AnswerAiDTO('Ответ ассистента');
    }
}
