<?php

namespace app\modules\Qm\services\chat\actions;

use app\modules\Qm\dto\ActionResultDTO;

interface ActionInterface
{
    public function execute(array $params): ActionResultDTO;
}
