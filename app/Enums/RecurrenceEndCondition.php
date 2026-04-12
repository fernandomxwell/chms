<?php

namespace App\Enums;

enum RecurrenceEndCondition: string
{
    case Never = 'never';
    case OnDate = 'on_date';
    case AfterOccurrences = 'after_occurrences';
}
