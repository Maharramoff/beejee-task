<?php


namespace BeeJee;


final class Helper
{
    /**
     * Header Redirect
     *
     * @param string $uri URL
     * @param int $code HTTP Response status code
     * @return void
     */
    public static function redirect(string $uri, int $code = 302): void
    {
        if (false === headers_sent())
        {
            header('Location: ' . $uri, true, $code);
        }

        exit;
    }

    /**
     * Escape HTML special characters in a string.
     *
     * @param $str
     * @return string
     */
    public static function escapeHtml(string $str): string
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8', false);
    }
}