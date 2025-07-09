<?php
namespace Src\Models;

use DateTime;
use DateInterval;
use DatePeriod;

class Analytics extends BaseModel {
    public function getTotalUsers(): int {
        return rand(100, 500);
    }

    public function getRegistrationTrends(string $interval, DateTime $from, DateTime $to): array {
        $labels = [];
        $data   = [];
        $period = new DatePeriod($from, new DateInterval('P1D'), $to);
        foreach ($period as $dt) {
            $labels[] = $dt->format('Y-m-d');
            $data[]   = rand(0, 20);
        }
        return ['labels' => $labels, 'data' => $data];
    }

    public function getActiveInactiveCounts(DateTime $from, DateTime $to): array {
        $active   = rand(50, 200);
        $inactive = rand(0, 50);
        return ['labels' => ['Active', 'Inactive'], 'data' => [$active, $inactive]];
    }

    public function getProjectCount(): int {
        return rand(20, 100);
    }

    public function getStageCount(): int {
        return rand(50, 200);
    }

    public function getPageUsage(DateTime $from, DateTime $to, int $limit = 10): array {
        $pages = ['Home', 'Dashboard', 'Profile', 'Settings', 'Reports'];
        $counts = array_map(fn() => rand(10, 100), $pages);
        return ['labels' => $pages, 'data' => $counts];
    }
}