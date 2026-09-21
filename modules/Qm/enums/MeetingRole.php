<?php

namespace app\modules\Qm\enums;

/**
 * Роли пользователя в контексте совещания.
 */
enum MeetingRole: string
{
    /** Администратор портала. */
    case ADMIN = 'admin';
    /** Руководитель совещания или модератор. */
    case MODERATOR = 'moderator';
    /** Сотрудник дочернего общества. */
    case USER_DO   = 'user_do';
    /** Участник совещания. */
    case ATTENDEE  = 'attendee';
    /** Ответственный в филиале. */
    case RESPONSIBLE = 'responsible';
}