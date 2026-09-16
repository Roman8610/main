<?php

namespace app\modules\meetings\forms;

use Override;
use yii\base\Model;

class DeleteCommentForm extends Model{
    public $comment_id;

    #[Override]
    public function rules()
    {
        return [
            [['comment_id'], 'required'],
            [['comment_id'], 'integer'],
        ];
    }
}