<?php
namespace app\modules\Qm\forms;

use yii\base\Model;

/**
 * Данные формы отправки постановочного вопроса на модерацию.
 */
class SubmitMeetingQuestionModerationForm extends Model
{
    /** Сценарий операции отправки. */
    public $scenario;
    public $question_id;

    public function rules(){
        return [
            [['scenario', 'question_id'], 'required'],
        ];
    }
}
