<?php

namespace App\Core;

class RateControl
{
    private $limit;
    private $timeout;

    public function __construct($limit = 10, $timeout = 3600)
    {
        $this->limit = $limit;
        $this->timeout = $timeout;

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function attemptWithinLimits()
    {
        // Initialize or update request count and time
        if (!isset($_SESSION['requests'])) {
            $_SESSION['requests'] = 0;
            $_SESSION['reset_time'] = time() + $this->timeout;
        }

        // Reset count if time period has passed
        if (time() > $_SESSION['reset_time']) {
            $_SESSION['requests'] = 0;
            $_SESSION['reset_time'] = time() + $this->timeout;
        }

        // Increment request count
        $_SESSION['requests']++;

        // Check if limit is exceeded
        if ($_SESSION['requests'] > $this->limit) {
            return false;
        }

        return true;
    }
}
