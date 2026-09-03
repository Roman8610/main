<?php

namespace app\modules\meetings\services;

use app\modules\meetings\models\Meeting;
use app\modules\meetings\models\MeetingQuestion;
use Yii;
use yii\web\NotFoundHttpException;
use app\modules\meetings\enums\MeetingRole;

class MeetingQuestionAccessService
{
    /**
     * Проверяет может ли пользователь создать вопрос в совещании
     * @param int $meetingId
     * @param int $userId
     * @return bool
     */
    public function canCreate(int $meetingId, int $userId): bool
    {
        $meeting = $this->getMeeting($meetingId);
        if ($this->isAdmin($userId, $meeting->id) || $this->isBoss($userId, $meeting->id) || $this->isDoWorker($userId) || $this->isResponsible($userId) || $this->isAttendee($userId)) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет может ли пользователь отправить вопрос на модерацию
     */
    public function canSubmitForModeration(int $questionId, int $userId): bool
    {
        $question = $this->getQuestion($questionId);
        if ($question->created_by == $userId) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет может ли пользователь выполнить модерацию
     */
    public function canMakeModeration(int $questionId, int $userId): bool
    {
        $question = $this->getQuestion($questionId);
        if ($this->isBoss($userId, $questionId) && $question->status == MeetingQuestion::STATUS_PENDING) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет может ли пользователь редактировать вопрос
     */
    public function canUpdate(int $questionId, int $userId): bool
    {
        $question = $this->getQuestion($questionId);
        if ($question->created_by == $userId && $question->status != MeetingQuestion::STATUS_PUBLISHED && $question->status != MeetingQuestion::STATUS_PENDING) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет может ли пользователь удалить вопрос
     */
    public function canDelete(int $questionId, int $userId): bool
    {
        $question = $this->getQuestion($questionId);
        if ($question->created_by == $userId && $question->status != MeetingQuestion::STATUS_PENDING) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет может ли пользователь просматривать вопрос
     * Администратор может просматривать все вопросы
     * Вопросы со статусом {@see MeetingQuestion::STATUS_DRAFT} может просматривать только собственник вопроса
     * Вопросы со статусом {@see MeetingQuestion::STATUS_PENDING} может просматривать собственник вопроса и модератор
     * Вопросы со статусом {@see MeetingQuestion::STATUS_PUBLISHED} может просматривать собственник вопроса, модератор, сотрудник дочернего общества, участник совещания
     * Вопросы со статусом {@see MeetingQuestion::STATUS_REJECTED} может просматривать собственник вопроса и модератор
     * Вопросы со статусом {@see MeetingQuestion::STATUS_REMOVED} может просматривать собственник вопроса и модератор
     * @param int $questionId идентификатор вопроса
     * @param int $userId идентификатор пользователя
     * @return bool
     */
    public function canView(int $questionId, int $userId): bool
    {
        $question = $this->getQuestion($questionId);
        $roles = $this->getRoles($question->meeting_id, $userId);

        if ($question->created_by == $userId) {
            return true;
        }
        if ($question->created_by != $userId && ($question->status == MeetingQuestion::STATUS_PENDING || $question->status == MeetingQuestion::STATUS_REJECTED || $question->status == MeetingQuestion::STATUS_REMOVED) && in_array('moderator', $roles)) {
            return true;
        }
        if ($question->created_by != $userId && $question->status == MeetingQuestion::STATUS_PUBLISHED && !empty($roles)) {
            return true;
        }
        return false;
    }

    /**
     * Возвращает массив ролей пользователя для конкретного совещания
     * @param int $userId идентификатор пользователя
     * @param int $meetingId идентификатор совещания
     * @return array
     */
    public function getRoles(int $meetingId, int $userId): array
    {
        $roles = [];
        if ($this->isAdmin($userId, $meetingId)) {
            $roles[] = MeetingRole::ADMIN->value;
        }
        if ($this->isBoss($userId, $meetingId)) {
            $roles[] = MeetingRole::MODERATOR->value;
        }
        if ($this->isDoWorker($userId)) {
            $roles[] = MeetingRole::USER_DO->value;
        }
        if ($this->isAttendee($userId)) {
            $roles[] = MeetingRole::ATTENDEE->value;
        }
        if ($this->isResponsible($userId)) {
            $roles[] = MeetingRole::RESPONSIBLE->value;
        }
        return $roles;
    }

    /**
     * Возвращает объект вопроса или выбрасывает исклюение если вопроса нет
     * @param int $questionId идентификатор вопроса
     * @return MeetingQuestion 
     */
    private function getQuestion(int $questionId): MeetingQuestion
    {
        $question = MeetingQuestion::findOne($questionId);
        if (!$question) {
            throw new NotFoundHttpException('Вопрос не найден');
        }
        return $question;
    }

    /**
     * Возвращает объект совещания или выбрасывает исклюение если совещания нет
     * @param int $meetingId идентификатор совещания
     * @return Meeting
     */
    private function getMeeting(int $meetingId): Meeting
    {
        $meeting = Meeting::findOne($meetingId);
        if (!$meeting) {
            throw new NotFoundHttpException('Совещание не найдено');
        }
        return $meeting;
    }

    /**
     * Проверяем является ли пользователь админостратором
     * @param int $userId Идентификатор пользователя
     * @param int $questionId Идентификатор вопроса
     * @return bool
     */
    private function isAdmin(int $userId, int $questionId): bool
    {
        $users = [666];
        if (!in_array($userId, $users)) {
            return false;
        }
        return true;
    }

    /**
     * Проверяем является ли пользователь руководителем совещания
     * @param int $userId Идентификатор пользователя
     * @param int $questionId Идентификатор вопроса
     * @return bool
     */
    private function isBoss(int $userId, int $questionId): bool
    {
        $users = [200];
        if (!in_array($userId, $users)) {
            return false;
        }
        return true;
    }

    /**
     * Проверяем является ли пользователь сотрудником дочернего общества
     * @param int $userId Идентификатор пользователя
     * @return bool
     */
    private function isDoWorker(int $userId): bool
    {
        $users = [300];
        if (!in_array($userId, $users)) {
            return false;
        }
        return true;
    }

    /**
     * Проверяем является ли пользователь ответственным в филиале
     * @param int $userId Идентификатор пользователя
     * @return bool
     */
    private function isResponsible(int $userId): bool
    {
        $users = [400];
        if (!in_array($userId, $users)) {
            return false;
        }
        return true;
    }

    /**
     * Проверяем является ли пользователь участником совещания
     * @param int $userId Идентификатор пользователя
     * @return bool
     */
    private function isAttendee(int $userId): bool
    {
        $users = [500];
        if (!in_array($userId, $users)) {
            return false;
        }
        return true;
    }
}
