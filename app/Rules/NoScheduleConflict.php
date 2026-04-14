<?php

namespace App\Rules;

use App\Models\Activity;
use App\Services\ActivityService;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoScheduleConflict implements ValidationRule
{
    protected string $startTime;

    protected array $recurrenceInput;

    protected ?int $excludeId;

    protected ActivityService $service;

    public function __construct(
        string $startTime,
        array $recurrenceInput,
        ?int $excludeId = null
    ) {
        $this->startTime = $startTime;
        $this->recurrenceInput = $recurrenceInput;
        $this->excludeId = $excludeId;
        $this->service = app(ActivityService::class);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rrule = constructRrule(
            $this->recurrenceInput['frequency'],
            (int) $this->recurrenceInput['interval'],
            $this->recurrenceInput['byday'] ?? null,
            $this->recurrenceInput['end_condition'] ?? null,
            $this->recurrenceInput['until'] ?? null,
            $this->recurrenceInput['count'] ?? null,
        );

        $newOccurrences = generateOccurrences(Carbon::parse($this->startTime), $rrule);

        $existingActivities = Activity::query()
            ->when($this->excludeId, fn($query) => $query->where('id', '!=', $this->excludeId))
            ->get([
                'start_time',
                'rrule',
            ]);

        foreach ($existingActivities as $activity) {
            $existingStart = Carbon::parse($activity->start_time);
            $existingRrule = $activity->rrule;

            $existingOccurrences = generateOccurrences($existingStart, $existingRrule);

            foreach ($newOccurrences as $newOcc) {
                foreach ($existingOccurrences as $existingOcc) {
                    if ($newOcc->equalTo($existingOcc)) {
                        $fail(__('validation.schedule_conflict'));

                        return;
                    }
                }
            }
        }
    }
}
