<?php

namespace app\modules\meetings\enums;

enum MeetingRole: string
{
    case MODERATOR = 'moderator';
    case USER_DO   = 'user_do';
    case ATTENDEE  = 'attendee';
    case RESPONSIBLE = 'responsible';
}