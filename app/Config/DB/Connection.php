<?php

namespace App\Config\DB;

use mysqli;

/**
 * Trait Connection
 * @package App\Config\DB
 */
trait Connection {
    /**
     * @return mysqli
     */
    public function connection(): mysqli
    {
        return new mysqli(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'), env('DB_PORT'));
    }
}