<?php

namespace app\modules\Qm\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MeetingsAsset extends AssetBundle
{
    public $baseUrl = '/modules/Qm/assets';
    public $js = [
        'js/meetings.js',
    ];
    public $css = [
        'css/mq.css',
    ];
    public $depends = [
        JqueryAsset::class,
    ];
}
