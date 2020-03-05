<?php

use FastRoute\RouteCollector;

return function (RouteCollector $r)
{
    $r->get('/', 'HomeController#index');
    $r->get('/tasks', 'TaskController#index');
    $r->get('/tasks/{id:[0-9]+}', 'TaskController#show');
};
