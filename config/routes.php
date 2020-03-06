<?php

use FastRoute\RouteCollector;

return function (RouteCollector $r)
{
    // Task routes
    $r->get('/', 'TaskController#index');
    $r->get('/tasks/create', 'TaskController#create');
    $r->post('/tasks/create', 'TaskController#create');
    $r->addRoute(['POST', 'GET'], '/tasks/edit/{id:[0-9]+}', 'TaskController#update');
    $r->get('/tasks[/{field:[a-z_]+}[/{order:asc|desc}[/{page:[0-9]+}]]]', 'TaskController#index');


    // Authentication routes
    $r->get('/auth/login', 'AuthController#login');
    $r->get('/auth/logout', 'AuthController#logout');
    $r->post('/auth/login', 'AuthController#login');
};
