<?php

namespace BeeJee;

use Symfony\Component\HttpFoundation\{ Request, Session\Session };

final class Application
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Session
     */
    private $session;

    final public function __construct()
    {
        $this->checkPhpVersion();
        $this->setTimeZone(APP_TIMEZONE);
        $this->setInternalEncoding('UTF-8');
    }

    /**
     * Starts application
     *
     * @return void
     */
    final public function run(): void
    {
        $this->session = new Session();
        $this->session->start();
        $this->request = Request::createFromGlobals();
        $router        = new Router($this->request);
        $router->dispatch();
    }

    /**
     * Checks if the PHP version is valid for current app
     *
     * @return bool
     */
    final private function isPhpVersionValid(): bool
    {
        return defined('PHP_VERSION_ID') && PHP_VERSION_ID >= APP_PHP_MIN_ID;
    }

    /**
     * Exit app if php version is not valid
     *
     * @return void
     */
    final private function checkPhpVersion(): void
    {
        if (!$this->isPhpVersionValid())
        {
            exit(sprintf(
                'You are running <strong style="color: darkred">PHP %s</strong>, but <strong>PHP %s</strong> or above is required to run this app.',
                PHP_VERSION,
                APP_PHP_MIN
            ));
        }
    }

    /**
     * Sets default timezone for app
     *
     * @param string $timezone
     * @return void
     */
    final private function setTimeZone(string $timezone): void
    {
        date_default_timezone_set($timezone);
    }

    /**
     * Set internal character encoding
     *
     * @param string $encoding
     * @return void
     */
    final private function setInternalEncoding(string $encoding): void
    {
        mb_internal_encoding($encoding);
    }
}