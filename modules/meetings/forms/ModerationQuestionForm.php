<?php
namespace app\modules\meetings\forms;

use Override;

/**
 * Принимает ID вопроса и комментарий модератора
 * Валедирует данные
 * Используется для создания формы ActiveForm
 */

class ModerationQuestionForm extends \yii\base\Model
{
    public array $departments = [];
    public $directions;
    public string $comment_moderator;
   
    #[Override]
    public function rules()
    {
        return [
            [['departments', 'directions'], 'required'],
            [['recipients'], 'each', 'rule' => ['integer']],
            [['comment_moderator'], 'string'],
        ];
    }

    #[Override]
    public function attributeLabels()
    {
        return [
            'departments' => 'Отдел',
            'directions' => 'Направление',
            'comment_moderator' => 'Комментарий модератора',
        ];
    }

}