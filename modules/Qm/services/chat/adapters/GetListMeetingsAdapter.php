<?php

namespace app\modules\Qm\services\chat\adapters;

use app\modules\Qm\dto\ActionResultDTO;
use app\modules\Qm\services\MeetingService;
use Yii;

class GetListMeetingsAdapter implements AdapterInterface
{
    public function __construct(
        private MeetingService $service
    ) {}

    // Проверить и преобразовать параметры ИИ
    // в формат, который ожидает сервис.
    // Вызвать $this->service.
    // Преобразовать результат в ActionResultDTO.
    public function execute(array $params): ActionResultDTO
    {
       // $listMeetings = Yii::$app->getModule('Qm')->get('meetingService')->getList();
       $listMeetings = $this->service->getList();

        return new ActionResultDTO(
            true,
            'Запрос выполнен успешно',
            $listMeetings
        );
    }
}
