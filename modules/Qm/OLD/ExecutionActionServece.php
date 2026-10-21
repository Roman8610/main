<?php

namespace app\modules\Qm\services\chat;

use app\modules\Qm\dto\AnswerAiDTO;
use Yii;

/**
 * Сервис запускает выполнение API экшена
 * Если сервис и экшен существуют, запускаем их выполнение и вззвращем результат их работы
 */

class ExecutionActionServece
{
    public function run(AnswerAiDTO $dataDto): bool | string
    {
        if (!$dataDto->service && !$dataDto->action) {
            return false;
        }

        $service = Yii::$app->getModule('Qm')->get('executionActionServece');
        if(!$service){
            return false;
        }
        $result = $service->action($dataDto->param);
        if(!$result){
            return false;
        }

        return $result;
    }
}
