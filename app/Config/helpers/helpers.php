<?php

/**
 * @param $path
 */
function view($path)
{
    include basePath("/resource/view/$path");
}

/**
 * @param $key
 * @return string|null
 */
function env($key): ?string
{
    $filename = basepath("/.env");
    $fp = fopen($filename, 'r');
    $value = null;
    while ($line = fgets($fp)) {
        $entry = explode("=", $line, 2);
        if ($key == trim($entry[0])) {
            $value = trim($entry[1]);
            break;
        }
    }
    return $value;
}

/**
 * @param null $path
 * @return string
 */
function basePath($path = null): string
{
    $dir = dirname(__DIR__) . '/../..';
    if ($path) {
        if ($path[0] == '/') {
            $dir .= $path;
        } else {
            $dir .= '/' . $path;
        }
    }
    return $dir;
}

/**
 * @param $file
 * @param $location
 */
function removeFile($file, $location)
{
    if ($file != null) {
        $name = basePath("$location/$file");
        if (file_exists($name)) {
            unlink($name);
        }
    }
}


/**
 * @return object
 */
function requestURI()
{
    $data = array();
    $var = preg_split("#/#", ltrim($_SERVER['REQUEST_URI'], '/'));
    for ($i = 0; $i < count($var); $i++) {
        $data['name' . $i] = $var[$i];
    }
    return (object)$data;
}

/**
 * @param $data
 * @return string
 */
function input($data): string
{
    $data = trim($data);
    $data = stripcslashes($data);
    return htmlspecialchars($data);
}

/**
 * @param null $path
 */
function asset($path = null)
{
    if ($path) {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
    }
    echo $path;
}

/**
 * @param null $path
 * @return mixed|string|null
 */
function assetFile($path = null)
{
    $host = $_SERVER;
    if ($path) {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }
    }
    return $path;
}

/**
 *
 */
function back()
{
    $return = $_SERVER['HTTP_REFERER'];
    header("Location: $return");
}

/**
 * @param $key
 * @return false|mixed
 */
function getSession($key)
{
    if (session_status() == 2) {
        if (isset($_SESSION["$key"])) {
            return $_SESSION["$key"];
        } else {
            return false;
        }
    } else {
        session_start([
            'cookie_domain' => $_SERVER['SERVER_NAME'],
            'cookie_path' => '/'
        ]);
        if (isset($_SESSION["$key"])) {
            return $_SESSION["$key"];
        } else {
            return false;
        }
    }
}

/**
 * @param $key
 * @param $value
 * @param bool $dir
 */
function setSession($key, $value, $dir = false)
{
    if ($dir) {
        if (session_status() != 2) {
            session_start([
                'cookie_domain' => $_SERVER['SERVER_NAME'],
                'cookie_path' => '/'
            ]);
        }
    }
    $_SESSION["$key"] = $value;
}


/**
 * @param $key
 */
function unsetSession($key)
{
    if (session_status() == 2) {
        if (isset($_SESSION["$key"])) {
            unset($_SESSION["$key"]);
        }
    } else {
        session_start([
            'cookie_domain' => $_SERVER['SERVER_NAME'],
            'cookie_path' => '/'
        ]);
        if (isset($_SESSION["$key"])) {
            unset($_SESSION["$key"]);
        }
    }
}