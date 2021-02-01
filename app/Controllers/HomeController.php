<?php

namespace App\Controllers;

use App\Config\DB\DB;

/**
 * Class HomeController
 * @package App\Controllers
 */
class HomeController
{
    /**
     * @var
     */
    private static $instance;

    /**
     * @return HomeController
     */
    static public function Router(): HomeController
    {
        if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     *
     */
    public function index()
    {
        view('index.php');
    }

    /**
     *
     */
    public function dynamic()
    {
        echo "<h1 style='text-align: center'>This Is Dynamic Page</h1>";
    }
}