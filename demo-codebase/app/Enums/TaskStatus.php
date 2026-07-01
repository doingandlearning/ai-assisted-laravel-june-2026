<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Todo = 'Todo';
    case InProgress = 'InProgress';
    case Done = 'Done';
}
