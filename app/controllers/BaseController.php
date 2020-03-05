<?php


namespace App\Controllers;

use App\Models\Auth;
use BeeJee\Controller;
use BeeJee\Helper;

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
            'user'           => $this->user,
            'successMessage' => null,
            'errorMessage'   => null,
            'helper'         => Helper::class,
        ]);
    }

    /**
     * @param mixed $errorMessage
     */
    public function setErrorMessage($errorMessage): void
    {
        $this->view->assign([
            'errorMessage'   => $errorMessage,
            'successMessage' => null
        ]);
    }

    /**
     * @param mixed $successMessage
     */
    public function setSuccessMessage($successMessage): void
    {
        $this->view->assign([
            'errorMessage'   => null,
            'successMessage' => $successMessage
        ]);
    }
}