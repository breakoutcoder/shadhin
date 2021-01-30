<?php

/**
 * dynamic url (\w+)
 */


use App\Config\Router;
use App\Controllers\HomeController;

Router::get('/', [HomeController::class, 'index']);
Router::get('/(\w+)/dynamic', 'HomeController@dynamic');

Router::cleanup();