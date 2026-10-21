<?php

namespace app\modules\Qm\services\chat\adapters;

use app\modules\Qm\dto\ActionResultDTO;

interface AdapterInterface
{
    /**
     * Проверить и преобразовать параметры ИИ в формат, который ожидает сервис. 
     * Вызвать $this->service.
     * Преобразовать результат в ActionResultDTO.
     */
    public function execute(array $params): ActionResultDTO;
}
