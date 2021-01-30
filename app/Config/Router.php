<?php

namespace App\Config;

/**
 * Class Router
 * @package App\Config
 */
class Router
{

    /**
     * @var bool
     */
    public static $nomatch = true;

    /**
     * @return mixed
     */
    private static function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @param $uri
     * @return false
     */
    private static function getMatches($uri)
    {
        $url = self::getUrl();
        if (preg_match($uri, $url, $matches)) {
            return $matches;
        }
        return false;
    }

    /**
     * @param $uri
     * @param $callback
     * @param $method
     */
    private static function process($uri, $callback, $method)
    {
        if ($_SERVER['REQUEST_METHOD'] != $method) {
            return;
        }
        $uri = "~^{$uri}/?$~";
        $params = self::getMatches($uri);

        if ($params) {
            $functionArguments = array_slice($params, 1);
            self::$nomatch = false;
            if (is_callable($callback)) {
                if (is_array($callback)) {
                    $className = $callback[0];
                    $methodName = $callback[1];
                    $instance = $className::Router();
                    $instance->$methodName(...$functionArguments);
                } else {
                    $callback(...$functionArguments);
                }
            } else {
                $parts = explode('@', $callback);
                $className = "\App\Controllers\\".$parts[0];
                $methodName = $parts[1];
                $instance = $className::Router();
                $instance->$methodName(...$functionArguments);
            }
        }
    }

    /**
     * @param $uri
     * @param $callback
     */
    static function get($uri, $callback)
    {
        self::process($uri, $callback, 'GET');
    }

    /**
     * @param $uri
     * @param $callback
     */
    static function post($uri, $callback)
    {
        self::process($uri, $callback, 'POST');
    }

    /**
     *
     */
    static function cleanup()
    {
        if (self::$nomatch) {
            echo "404";
        }
    }
}