<?php

namespace app\modules\Qm\enums;

enum MeetingRole: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case USER_DO   = 'user_do';
    case ATTENDEE  = 'attendee';
    case RESPONSIBLE = 'responsible';
}