<?php

namespace App\Services;

use App\Models\Boost;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BoostAvailabilityService
{
    const MAX_CONCURRENT_SLOTS = 5;

    /**
     * Check if a specific date range is available (no day exceeds MAX_CONCURRENT_SLOTS).
     */
    public function isRangeAvailable(Carbon $startDate, Carbon $endDate): bool
    {
        $dailyCounts = $this->getDailyCounts($startDate, $endDate);
        
        foreach ($dailyCounts as $count) {
            if ($count >= self::MAX_CONCURRENT_SLOTS) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get the max concurrent slot number for a start date (cosmetic slot number).
     */
    public function getNextSlotNumber(Carbon $startDate): int
    {
        $count = Boost::whereIn('status', ['scheduled', 'active'])
            ->where('start_date', '<=', $startDate)
            ->where('end_date', '>=', $startDate)
            ->count();
            
        return min($count + 1, self::MAX_CONCURRENT_SLOTS);
    }

    /**
     * Get concurrent boost counts per day for a date range.
     */
    public function getDailyCounts(Carbon $startDate, Carbon $endDate): array
    {
        // Get all boosts overlapping this range
        $overlappingBoosts = Boost::whereIn('status', ['scheduled', 'active'])
            ->where('start_date', '<=', $endDate->toDateString())
            ->where('end_date', '>=', $startDate->toDateString())
            ->get();

        $dailyCounts = [];
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $dateString = $date->toDateString();
            $dailyCounts[$dateString] = 0;

            foreach ($overlappingBoosts as $boost) {
                if ($boost->start_date->toDateString() <= $dateString && $boost->end_date->toDateString() >= $dateString) {
                    $dailyCounts[$dateString]++;
                }
            }
        }

        return $dailyCounts;
    }
    
    /**
     * Generate calendar availability data for UI.
     */
    public function generateCalendar(Carbon $startDate, int $daysToLookAhead = 60, int $durationDays = 3): array
    {
        $endDate = $startDate->copy()->addDays($daysToLookAhead);
        
        // We get daily counts for a slightly extended range to properly check duration availability
        $extendedEndDate = $endDate->copy()->addDays($durationDays);
        $dailyCounts = $this->getDailyCounts($startDate, $extendedEndDate);
        
        $calendar = [];
        $period = CarbonPeriod::create($startDate, $endDate);
        
        foreach ($period as $date) {
            $dateString = $date->toDateString();
            
            // A start date is available if ALL days in its resulting duration range are available
            $rangeEnd = $date->copy()->addDays($durationDays - 1);
            $rangePeriod = CarbonPeriod::create($date, $rangeEnd);
            
            $isAvailable = true;
            foreach ($rangePeriod as $d) {
                $dString = $d->toDateString();
                if (($dailyCounts[$dString] ?? 0) >= self::MAX_CONCURRENT_SLOTS) {
                    $isAvailable = false;
                    break;
                }
            }
            
            $calendar[] = [
                'date' => $dateString,
                'available' => $isAvailable,
                'slots_taken' => $dailyCounts[$dateString] ?? 0,
            ];
        }
        
        return $calendar;
    }
}
