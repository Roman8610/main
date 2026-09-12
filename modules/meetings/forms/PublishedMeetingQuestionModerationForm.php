<?php
namespace app\modules\meetings\forms;
use Override;
/**
 * Принимает ID постановочного вопроса который необходимо опубликовать
 * Валедирует данные
 */
class PublishedMeetingQuestionModerationForm extends \yii\base\Model{

    public $departments = [];
    public $directions;
    public $question_id;
   
    #[Override]
    public function rules()
    {
        return [
            [['departments', 'directions', 'question_id'], 'required'],
            ['directions', 'string'],
            ['departments', 'each', 'rule' => ['integer']],
            ['question_id', 'integer'],
        ];
    }

    #[Override]
    public function attributeLabels()
    {
        return [
            'departments' => 'Отдел',
            'directions' => 'Направление',
        ];
    }

}