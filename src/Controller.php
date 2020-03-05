<?php


namespace BeeJee;

use BeeJee\View;

abstract class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }
}