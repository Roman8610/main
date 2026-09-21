<?php

namespace app\modules\Qm\forms;

use Override;
use yii\base\Model;

/**
 * Данные формы удаления комментария.
 */
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