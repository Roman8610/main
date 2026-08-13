<?php
namespace app\modules\meetings\forms;

use yii\base\Model;

/**
 * Принимает ID постановочного вопроса который необходимо отправить на модерацию
 * Валедирует данные
 */
class SubmitMeetingQuestionModerationForm extends Model
{
    public $scenario;
    public $question_id;

    public function rules(){
        return [
            [['scenario'], 'required'],
        ];
    }
}
