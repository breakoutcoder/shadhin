<?php

namespace App\Config\DB;

use mysqli_result;

/**
 * Class DB
 * @package App\Config
 */
class DB
{
    use Connection;

    /**
     * @var
     */
    private $whereQuery = ' where';

    /**
     * @var
     */
    private static $table;

    /**
     * @var
     */
    private $limit;

    /**
     * @var string
     */
    private $sort;

    /**
     * @var
     */
    private static $instance;

    /**
     * @param $table
     * @return DB
     */
    public static function table($table): DB
    {
        self::$table = $table;
        self::$instance = new self();
        return self::$instance;
    }

    /**
     * @param $data
     * @return bool|mysqli_result
     */
    public function insert($data)
    {
        $dataLength = count($data);
        if ($dataLength >= 1) {
            $table = self::$table;
            $columns = null;
            $values = null;
            $i = 1;
            foreach ($data as $key => $value) {
                $key = input($key);
                $value = input($value);
                if ($dataLength != $i) {
                    $columns .= $key . ',';
                    $values .= "'$value'" . ',';
                } else {
                    $columns .= $key;
                    $values .= "'$value'";
                }
                $i++;
            }
            $query = "INSERT INTO $table ($columns) VALUES ($values)";
            return $this->connection()->query($query);
        }
        return false;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function where($key, $value)
    {
        if (strlen($this->whereQuery) > 6) {
            $this->whereQuery .= "and $key = '$value'";
        } else {
            $this->whereQuery .= " $key = '$value'";
        }
        return self::$instance;

    }

    /**
     * @return object
     */
    public function get()
    {
        $table = self::$table;
        $query = "SELECT * FROM $table";

        strlen($this->whereQuery) > 6 ? $query .= $this->whereQuery : null;
        $this->limit ? $query .= $this->limit : null;
        $this->sort ? $query .= $this->sort : null;

        $result = $this->connection()->query($query);
        $arr = array();
        if ($result && $result->num_rows > 1) {
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        } elseif ($result) {
            $arr = $result->fetch_assoc();
        }
        $arr = json_decode(json_encode($arr));
        return (object)$arr;
    }

    /**
     * @param $data
     * @return bool|mysqli_result
     */
    public function update($data)
    {
        $table = self::$table;
        $query = "UPDATE $table SET";
        $dataLength = count($data);
        $i = 1;
        foreach ($data as $key => $value) {
            $dataLength != $i ? $query .= " $key = '$value'," : $query .= " $key = '$value'";
            $i++;
        }

        if (strlen($this->whereQuery) > 6) {
            $query .= $this->whereQuery;
        }
        return $this->connection()->query($query);
    }

    /**
     * @return bool|mysqli_result
     */
    public function delete()
    {
        $table = self::$table;
        $query = "DELETE FROM $table";
        strlen($this->whereQuery) > 6 ? $query .= $this->whereQuery : null;
        return $this->connection()->query($query);

    }

    /**
     *
     */
    public function limit($limit)
    {
        $this->limit = " LIMIT $limit";
        return self::$instance;
    }

    /**
     * @param $key
     * @param null $type
     * @return mixed
     */
    public function sort($key, $type = null)
    {
        $type ? ($this->sort = " ORDER BY $key $type") : ($this->sort = " ORDER BY $key");
        return self::$instance;
    }
}