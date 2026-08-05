<?php
namespace app\modules\meetings\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MeetingsAsset extends AssetBundle{
    public $baseUrl = '/modules/meetings/assets';
    public $js = [
        'js/meetings.js',
    ];
    public $depends = [
        JqueryAsset::class,
    ];
}