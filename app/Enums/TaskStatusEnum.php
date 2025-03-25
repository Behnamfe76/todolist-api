<?php

namespace App\Enums;

enum TaskStatusEnum: string{
    case TODO = 'todo';
    case ON_PROGRESS = 'on_progress';
    case DONE = 'done';
    case EXPIRED = 'expired';
}
