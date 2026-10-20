<?php

namespace app\modules\Qm\services\chat\actions\agent;

use app\modules\Qm\dto\ActionResultDTO;
use app\modules\Qm\dto\AnswerAiDTO;
use InvalidArgumentException;

class ActionExecutor
{
    public function __construct(
        private ActionRegistry $actionRegistry
    ) {
    }

    public function run(AnswerAiDTO $plan): ActionResultDTO
    {
        if ($plan->service === '' || $plan->action === '') {
            throw new InvalidArgumentException(
                'Для выполнения действия нужны service и action.'
            );
        }

        $action = $this->actionRegistry->get(
            $plan->service,
            $plan->action
        );

        return $action->execute($plan->param);
    }
}