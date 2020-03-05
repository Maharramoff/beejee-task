<?php


namespace BeeJee;

use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    protected $view;
    protected $request;

    public function __construct()
    {
        $this->view = new View();
        $this->request = Request::createFromGlobals()->request;
    }
}