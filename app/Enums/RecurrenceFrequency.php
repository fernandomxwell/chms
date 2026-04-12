<?php

namespace App\Enums;

enum RecurrenceFrequency: string
{
    case None = 'NONE';
    case Secondly = 'SECONDLY';
    case Minutely = 'MINUTELY';
    case Hourly = 'HOURLY';
    case Daily = 'DAILY';
    case Weekly = 'WEEKLY';
    case Monthly = 'MONTHLY';
    case Yearly = 'YEARLY';
}
