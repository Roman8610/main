<?php

namespace app\modules\Qm\widgets;

use yii\base\Widget;

class AIChatWidget extends Widget
{
    public function run() {
        return $this->render('chat');
    }
}
