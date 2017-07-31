<?php
use Cake\Routing\Router;
Router::scope('/', function ($routes) {
    $routes->connect('/game', ['controller' => 'Texts', 'action' => 'index']);
    $routes->connect('/texts/loadtext/*', ['controller' => 'Texts', 'action' => 'loadText']);
    $routes->connect('/texts/delete/*', ['controller' => 'Texts', 'action' => 'delete']);

    $routes->connect('/', ['controller' => 'Users', 'action' => 'index']);
    $routes->connect('/signup', ['controller' => 'Users', 'action' => 'signup']);
    $routes->connect('/loadInfo', ['controller' => 'Users', 'action' => 'loadInfo']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/login/verify', ['controller' => 'Users', 'action' => 'loginVerify']);
    $routes->connect('/success', ['controller' => 'Users', 'action' => 'success']);
    $routes->connect('/signup/newaccount', ['controller' => 'Users', 'action' => 'newaccount']);
    $routes->connect('/login/validate/*', ['controller' => 'Users', 'action' => 'validateAccount']);
    $routes->connect('/checkemail/*', ['controller' => 'Users', 'action' => 'checkemail']);
});
