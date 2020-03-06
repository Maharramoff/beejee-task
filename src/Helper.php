<?php


namespace BeeJee;


final class Helper
{
    /**
     * Header Redirect
     *
     * @param string $uri URL
     * @param int $code HTTP Response status code
     * @param int $seconds
     * @return void
     */
    public static function redirect(string $uri, int $seconds = 0, int $code = 302): void
    {
        if (false === headers_sent())
        {
            if ($seconds > 0)
            {
                header("refresh:" . $seconds . "; url=" . $uri, true, $code);
                exit;
            }

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

    public static function paginate($uri, $maxPages, $totalRows, $limit, $page)
    {
        if ($totalRows <= $limit) return null;

        $html = '<div class="padtop_m"><div>';

        $html .= '</div><div class="padtop_m">';

        if ($page != 1)
        {
            $html .= '<a class="page" href="' . $uri . '/1">1</a>';
        }
        else
        {
            $html .= '<b class="current">&#160;1&#160;</b>';
        }

        if ($page != $maxPages)
        {
            $html .= '<a class="page" href="' . $uri . '/' . $maxPages . '">' . $maxPages . '</a>';
        }
        elseif ($maxPages > 1)
        {
            $html .= '<b class="current">&#160;' . $maxPages . '&#160;</b>';
        }

        $html .= '</div></div>';

        return $html;
    }
}