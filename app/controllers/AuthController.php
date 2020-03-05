<?php


namespace App\Controllers;


use BeeJee\Helper;
use Symfony\Component\HttpFoundation\ParameterBag as Request;

class AuthController extends BaseController
{
    /**
     * Handle a login request to the application.
     *
     * @return void|array|string
     */
    public function login()
    {
        // Redirect user if already authenticated
        if ($this->auth->check())
        {
            Helper::redirect('/home');
        }

        if ($this->request->getMethod() === 'POST')
        {
            if ($this->validate($this->request->request))
            {
                if ($this->auth->loginAttempt($this->request->request->get('name'), $this->request->request->get('password')))
                {
                    $this->successLoginResponse();
                }
                else $this->failedLoginResponse();
            }
            else $this->emptyFieldsResponse();
        }

        $this->view->setPath('auth/login')->render();
    }

    public function showLoginForm()
    {
        // Redirect user if already authenticated
        if ($this->auth->check())
        {
            Helper::redirect('/home');
        }

        $this->view->setPath('auth/login')->render();
    }

    /**
     * Logout user from application.
     *
     * @return void
     */
    public function logout()
    {
        $this->auth->logout();
    }

    private function failedLoginResponse()
    {
        $this->setErrorMessage('User credentials are not valid');
    }

    private function emptyFieldsResponse()
    {
        $this->setErrorMessage('Fields should not be empty');
    }

    private function successLoginResponse()
    {
        $this->setSuccessMessage('User successfuly logged in');
    }

    private function validate(Request $request)
    {
        return $request->get('name') && $request->get('password');
    }
}