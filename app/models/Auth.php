<?php


namespace App\Models;


use BeeJee\Helper;
use Symfony\Component\HttpFoundation\Session\Session;

class Auth
{
    /**
     * User Data
     *
     * @var mixed
     */
    public $user;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    private $primaryKey = 'id';

    /**
     * Indicates if the logout method has been called.
     *
     * @var bool
     */
    protected $loggedOut = false;


    protected $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return array|void|null
     */
    public function user()
    {
        if ($this->loggedOut)
        {
            return;
        }

        // If we've already retrieved the user for the current request we can just
        // return it back immediately.
        if (!is_null($this->user))
        {
            return $this->user;
        }

        $id = $this->session->get($this->getSessionIdentifier());

        // Try to load the user using the identifier in the session
        if (null !== $id)
        {
            $this->user = User::find($id);
        }

        return $this->user;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return null !== $this->user();
    }

    /**
     * Log a user into the application.
     *
     * @param $user
     * @return void
     */
    private function login($user)
    {
        $this->updateSession($user[$this->primaryKey]);

        $this->setUser($user);
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param string $name
     * @param string $password
     * @return bool|void
     */
    public function loginAttempt(string $name, string $password)
    {
        if($this->check())
        {
            return;
        }

        $user = $this->retrieveByName($name);

        if ($this->hasValidCredentials($user, $password))
        {
            $this->login($user);

            return true;
        }

        return false;
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        $this->session->clear();

        $this->user = null;

        $this->loggedOut = true;

        Helper::redirect('/');
    }

    /**
     * Set the current user.
     *
     * @param mixed $user
     * @return Auth
     */
    public function setUser($user)
    {
        $this->user = $user;

        $this->loggedOut = false;

        return $this;
    }

    /**
     * Update the session with the given ID.
     *
     * @param string $id
     * @return void
     */
    protected function updateSession($id)
    {
        $this->session->set($this->getSessionIdentifier(), $id);
    }

    /**
     * Validate a user against the given password.
     *
     * @param $user
     * @param string $password
     * @return bool
     */
    public function validatePassword($user, string $password): bool
    {
        return password_verify($password, $user['password']);
    }

    /**
     * Check if user exists and password is valid.
     *
     * @param $user
     * @param string $password
     * @return bool
     */
    private function hasValidCredentials($user, string $password)
    {
        return $user && $this->validatePassword($user, $password);
    }

    /**
     * Get user data by given credentials
     *
     * @param string $name
     * @return array|bool
     */
    private function retrieveByName(string $name)
    {
        return User::whereName($name);
    }

    private function getSessionIdentifier()
    {
        return 'admin_id';
    }
}