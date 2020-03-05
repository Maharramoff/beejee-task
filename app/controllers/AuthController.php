<?php


namespace App\Controllers;


use BeeJee\Helper;
use Symfony\Component\HttpFoundation\ParameterBag;

class AuthController extends BaseController
{
    /**
     * Handle a login request to the application.
     *
     * @return void
     */
    public function login()
    {
        // Redirect user if already authenticated
        if ($this->auth->check())
        {
            Helper::redirect('/');
        }

        if ($this->request->getMethod() === 'POST')
        {
            switch (true)
            {
                case !$this->validate($this->parameterBag):
                    $this->emptyFieldsResponse();
                    break;

                case !$this->auth->loginAttempt($this->parameterBag->get('name'), $this->parameterBag->get('password')):
                    $this->failedLoginResponse();
                    break;

                default:
                    $this->successLoginResponse();
            }
        }

        $this->view->setPath('auth/login')->render();
    }

    public function showLoginForm()
    {
        // Redirect user if already authenticated
        if ($this->auth->check())
        {
            Helper::redirect('/');
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
        $this->setErrorMessage('Неправильное имя и/или пароль');
    }

    private function successLoginResponse()
    {
        $this->setSuccessMessage('Вы успешно авторизовались на сайте! <br/><a href="/" class="alert-link">Для продолжения использования сайтом нажмите сюда</a>');
    }

    private function validate(ParameterBag $parameterBag)
    {
        return $parameterBag->get('name') && $parameterBag->get('password');
    }
}