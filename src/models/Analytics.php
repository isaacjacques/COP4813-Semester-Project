<?php
namespace Src\Models;

use DateTime;
use DateInterval;
use DatePeriod;

class Analytics extends BaseModel {

    public function getTotalUsers(string $role = ''): int
    {
        $sql    = "SELECT COUNT(*) AS cnt FROM users";
        $params = [];
        if ($role === 'admin') {
            $sql .= " WHERE is_admin = 1";
        } elseif ($role === 'nonadmin') {
            $sql .= " WHERE is_admin = 0";
        }
        $row = $this->fetchOne($sql, $params);
        return $row ? (int)$row['cnt'] : 0;
    }

    public function getRegistrationTrends(string $interval, DateTime $from, DateTime $to, string $role = ''): array
    {
        $sql = "
            SELECT DATE(created_at) AS period, COUNT(*) AS cnt
            FROM users
            WHERE created_at BETWEEN :from AND :to
        ";
        $params = [
            ':from' => $from->format('Y-m-d 00:00:00'),
            ':to'   => $to->format('Y-m-d 23:59:59')
        ];
        if ($role === 'admin') {
            $sql .= " AND is_admin = 1";
        } elseif ($role === 'nonadmin') {
            $sql .= " AND is_admin = 0";
        }
        $sql .= " GROUP BY period ORDER BY period ASC";

        $rows = $this->fetchAll($sql, $params);
        $labels = array_column($rows, 'period');
        $data   = array_column($rows, 'cnt');

        return ['labels' => $labels, 'data' => $data];
    }

    public function getActiveInactiveCounts(string $role = ''): array
    {
        $sql = "
            SELECT
              SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) AS active,
              SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) AS inactive
            FROM users
        ";
        if ($role === 'admin') {
            $sql .= " WHERE is_admin = 1";
        } elseif ($role === 'nonadmin') {
            $sql .= " WHERE is_admin = 0";
        }
        $row = $this->fetchOne($sql);

        return [
            'labels' => ['Active', 'Inactive'],
            'data'   => [(int)$row['active'], (int)$row['inactive']]
        ];
    }

    public function getProjectCount(DateTime $from, DateTime $to): int
    {
        $sql = "
            SELECT COUNT(*) AS cnt
            FROM projects
            WHERE created_at BETWEEN :from AND :to
        ";
        $params = [
            ':from' => $from->format('Y-m-d 00:00:00'),
            ':to'   => $to->format('Y-m-d 23:59:59')
        ];
        $row = $this->fetchOne($sql, $params);
        return $row ? (int)$row['cnt'] : 0;
    }

    public function getStageCount(DateTime $from, DateTime $to): int
    {
        $sql = "
            SELECT COUNT(*) AS cnt
            FROM stages
            WHERE created_at BETWEEN :from AND :to
        ";
        $params = [
            ':from' => $from->format('Y-m-d 00:00:00'),
            ':to'   => $to->format('Y-m-d 23:59:59')
        ];
        $row = $this->fetchOne($sql, $params);
        return $row ? (int)$row['cnt'] : 0;
    }
    
    public function getInvoiceCount(DateTime $from, DateTime $to): int
    {
        $sql = "
            SELECT COUNT(*) AS cnt
            FROM invoices
            WHERE date_issued BETWEEN :from AND :to
        ";
        $params = [
            ':from' => $from->format('Y-m-d'),
            ':to'   => $to->format('Y-m-d')
        ];
        $row = $this->fetchOne($sql, $params);
        return $row ? (int)$row['cnt'] : 0;
    }

    public function getPageUsage(DateTime $from, DateTime $to, int $limit = 10, string $role = ''): array
    {
        $sql = "
            SELECT pv.page, COUNT(*) AS cnt
            FROM page_visits pv
            LEFT JOIN users u ON pv.user_id = u.user_id
            WHERE pv.visited_at BETWEEN :from AND :to"
        ;
        $params = [
            ':from'  => $from->format('Y-m-d H:i:s'),
            ':to'    => $to->format('Y-m-d H:i:s')
        ];

        if ($role === 'admin') {
            $sql .= " AND u.is_admin = 1";
        } elseif ($role === 'nonadmin') {
            $sql .= " AND (u.is_admin = 0 OR u.is_admin IS NULL)";
        }

        $sql .= "
            GROUP BY pv.page
            ORDER BY cnt DESC
        ";

        $rows = $this->fetchAll($sql, $params);

        return [
            'labels' => array_column($rows, 'page'),
            'data'   => array_column($rows, 'cnt'),
        ];
    }
}