<?php

use FastRoute\RouteCollector;

return function (RouteCollector $r)
{
    // Task routes
    $r->get('/', 'TaskController#index');
    $r->get('/tasks', 'TaskController#index');
    $r->get('/tasks/{id:[0-9]+}', 'TaskController#show');
    $r->get('/tasks/create', 'TaskController#create');
    $r->post('/tasks/create', 'TaskController#create');
    $r->addRoute(['POST', 'GET'], '/tasks/edit/{id:[0-9]+}', 'TaskController#update');

    // Authentication routes
    $r->get('/auth/login', 'AuthController#login');
    $r->get('/auth/logout', 'AuthController#logout');
    $r->post('/auth/login', 'AuthController#login');
};
