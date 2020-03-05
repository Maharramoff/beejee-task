<?php


namespace App\Controllers;

use App\Models\Auth;
use BeeJee\Controller;

class BaseController extends Controller
{
    protected $auth;
    protected $user = null;

    public function __construct()
    {
        parent::__construct();

        $this->auth = new Auth();
        $this->user = $this->auth->user();

        // Global variables for all views
        $this->view->assign([
            'user'  => $this->user,
        ]);
    }
}