<?php

use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use RRule\RRule;

if (!function_exists('highlightMatch')) {
    /**
     * Highlights a given term in a text.
     */
    function highlightMatch(string $textToSearch, string $termToHighlight): string
    {
        if (empty($termToHighlight)) {
            return $textToSearch;
        }

        return preg_replace('/' . preg_quote($termToHighlight, '/') . '/i', '<mark>$0</mark>', $textToSearch);
    }
}

if (!function_exists('collectRoutePatterns')) {
    /**
     * Recursively collect route patterns from menu and its children.
     *
     * @param  Menu  $menu
     */
    function collectRoutePatterns($menu): array
    {
        static $cache = [];

        $menuId = $menu->id ?? spl_object_hash($menu); // Use ID or object hash as cache key
        if (isset($cache[$menuId])) {
            return $cache[$menuId];
        }

        $patterns = [];

        if (!empty($menu->link) && is_string($menu->link)) {
            $patterns[] = preg_replace('/\.\w+$/', '.*', $menu->link);
        }

        if ($menu->children && $menu->children->isNotEmpty()) {
            foreach ($menu->children as $child) {
                $patterns = [...$patterns, ...collectRoutePatterns($child)];
            }
        }

        return $cache[$menuId] = $patterns;
    }
}

if (!function_exists('isMenuRouteActive')) {
    /**
     * Determine if any route pattern in the menu is active.
     *
     * @param  Menu  $menu
     */
    function isMenuRouteActive($menu): bool
    {
        $patterns = collectRoutePatterns($menu);

        return Request::routeIs(...$patterns);
    }
}

if (!function_exists('paginatedIndex')) {
    /**
     * Calculate the paginated index.
     */
    function paginatedIndex(int $loopIndex, int $currentPage, int $perPage): int
    {
        return ($currentPage - 1) * $perPage + $loopIndex;
    }
}

if (!function_exists('constructRrule')) {
    /**
     * Constructs an RRule string.
     */
    function constructRrule(
        string $frequency, // The frequency of the rule (e.g., DAILY, WEEKLY, MONTHLY, YEARLY)
        int $interval, // The interval of the rule (e.g., every weeks)
        ?array $byday = null, // The days of the week for the rule (e.g., ['MO', 'WE', 'FR'])
        ?string $endCondition = null, // The end condition of the rule (e.g., 'never', 'on_date', 'after_occurrences')
        ?string $until = null, // The end date of the rule (e.g., '2024-12-31')
        ?int $count = null // The number of occurrences of the rule (e.g., 10)
    ): string {
        if ($frequency === 'NONE') {
            return '';
        }

        $rrule = 'FREQ=' . strtoupper($frequency) . ';INTERVAL=' . max(1, $interval);

        if (strtoupper($frequency) === 'WEEKLY' && is_array($byday) && !empty($byday)) {
            $rrule .= ';BYDAY=' . implode(',', $byday);
        }

        if ($endCondition === 'on_date' && $until) {
            $rrule .= ';UNTIL=' . Carbon::parse($until)->format('Ymd\THis');
        } elseif ($endCondition === 'after_occurrences' && $count) {
            $rrule .= ';COUNT=' . $count;
        }

        return $rrule;
    }
}

if (!function_exists('parseRrule')) {
    /**
     * Parses an RRule string.
     */
    function parseRrule(string $rrule): array
    {
        $parts = explode(';', $rrule);
        $frequency = null;
        $interval = 1;
        $byday = [];
        $until = null;
        $count = null;
        $endCondition = 'never';

        foreach ($parts as $part) {
            if (strpos($part, 'FREQ=') === 0) {
                $frequency = str_replace('FREQ=', '', $part);
            } elseif (strpos($part, 'INTERVAL=') === 0) {
                $interval = (int) str_replace('INTERVAL=', '', $part);
            } elseif (strpos($part, 'BYDAY=') === 0) {
                $byday = explode(',', str_replace('BYDAY=', '', $part));
            } elseif (strpos($part, 'UNTIL=') === 0) {
                $until = str_replace('UNTIL=', '', $part);
                try {
                    $until = Carbon::createFromFormat('Ymd\THis', $until)->format('Y-m-d');
                } catch (\Exception $e) {
                    $until = null;
                }
            } elseif (strpos($part, 'COUNT=') === 0) {
                $count = (int) str_replace('COUNT=', '', $part);
            }
        }

        if ($until) {
            $endCondition = 'on_date';
        } elseif ($count) {
            $endCondition = 'after_occurrences';
        }

        return [
            'frequency' => $frequency,
            'interval' => $interval,
            'byday' => $byday,
            'until' => $until,
            'count' => $count,
            'end_condition' => $endCondition,
        ];
    }
}

if (!function_exists('generateOccurrences')) {
    /**
     * Generates occurrences based on an RRule.
     */
    function generateOccurrences(
        Carbon $start, // The start date of the event
        ?string $rrule, // The RRule string defining the recurrence pattern (optional)
        ?Carbon $end = null // The end date to limit the occurrences (optional)
    ): array {
        if (!$rrule) {
            return [$start];
        }

        $rule = new RRule(
            $rrule,
            $start->format('Y-m-d H:i:s')
        );

        return collect($rule->getOccurrencesBetween(
            $start,
            $end ?? now()->addYear()
        ))->map(fn($date) => Carbon::instance($date))->all();
    }
}
