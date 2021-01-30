<?php

namespace App\Config;

/**
 * Class Request
 * @package App\Config
 */
class Request
{

    /**
     * @var array|object
     */
    private static $data = array();

    /**
     * Request constructor.
     */
    public function __construct()
    {
        self::PostData();
        self::FileData();
        self::$data = (object)self::$data;

    }

    /**
     * @param string $key
     * @return bool
     */
    public function __get(string $key): bool
    {
        if (property_exists(self::$data, $key)) {
            return self::$data->$key;
        }
        return false;

    }

    /**
     * @return array
     */
    public function all(): array
    {
        return self::$data;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        if (property_exists(self::$data, $key)) {
            return true;
        }
        return false;

    }

    /**
     *
     */
    private static function PostData()
    {
        if (($_SERVER['REQUEST_METHOD']) == 'POST') {
            if ($_POST) {
                foreach ($_POST as $key => $value) {
                    self::$data[input($key)] = input($value);
                }
            }
        }
    }

    /**
     *
     */
    private static function FileData()
    {
        if (($_SERVER['REQUEST_METHOD']) == 'POST') {
            if ($_FILES) {
                foreach ($_FILES as $key => $value) {
                    if ($value['name']) {
                        self::$data[$key] = $value;
                    }
                }
            }
        }
    }
}