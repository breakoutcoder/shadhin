<?php

namespace App\Controllers;
/**
 * Class HomeController
 * @package App\Controllers
 */
class HomeController
{
    /**
     * @return HomeController
     */
    static public function Router(): HomeController
    {
        return new self();
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