<?php

namespace App\Config;

use mysqli;

/**
 * Class DB
 * @package App\Config
 */
class DB
{
    /**
     * @var
     */
    public $whereQuery = ' where';
    /**
     * @var
     */
    public $table;

    /**
     * DB constructor.
     * @param $table
     */
    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * @return mysqli
     */
    private function connection()
    {
        return new mysqli(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'), env('DB_PORT'));
    }


    /**
     * @param $key
     * @param $value
     */
    public function where($key, $value)
    {
        if (strlen($this->whereQuery) > 6) {
            $this->whereQuery .= ", $key = $value";
        }else{
            $this->whereQuery .= " $key = $value";
        }

    }

    /**
     * @return object
     */
    public function get()
    {
        $table = $this->table;
        $query = "SELECT * FROM $table";
        if (strlen($this->whereQuery) > 6) {
            $query .= $this->whereQuery;
        }
        $result = $this->connection()->query($query);
        $arr = array();
        if ($result && $result->num_rows > 1) {
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }elseif ($result){
            $arr = $result->fetch_assoc();
        }
        $arr = json_decode(json_encode($arr));
        return (object)$arr;
    }
}