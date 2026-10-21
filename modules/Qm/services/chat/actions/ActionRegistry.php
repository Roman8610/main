<?php

namespace app\modules\Qm\services\chat\actions;

use app\modules\Qm\services\chat\adapters\AdapterInterface;
use InvalidArgumentException;
use UnexpectedValueException;
use Yii;
use yii\base\BaseObject;

class ActionRegistry extends BaseObject
{
    /**
     * Ключ — "service.action", значение — класс обработчика.
     */
    public array $actions = [];

    public function get(string $service, string $action): AdapterInterface
    {
        $key = $service . '.' . $action;

        if (!isset($this->actions[$key])) {
            throw new InvalidArgumentException(
                'Действие не зарегистрировано: ' . $key
            );
        }

        $actionClass = $this->actions[$key];
        $handler = Yii::createObject($actionClass);

        if (!$handler instanceof AdapterInterface) {
            throw new UnexpectedValueException(
                'Обработчик должен реализовывать AdapterInterface: ' . $actionClass
            );
        }

        return $handler;
    }
}
