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

        $html = '<ul class="pagination pagination-sm justify-content-end">';

        if ($page != 1)
        {
            $html .= '<li class="page-item"><a class="page-link" href="' . $uri . '/1">1</a></li>';
        }
        else
        {
            $html .= '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">1</a></li>';
        }

        $in  =-3;
        $out = 3;

        for ($i = $in; $i <= $out; $i++)
        {
            $pageNum = $page + $i;

            if ($pageNum > 1 && $pageNum < $maxPages)
            {
                if ($in == $i && $pageNum > 2)
                {
                    $html .= '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1"> ..</a></li>';
                }
                if ($i != 0)
                {
                    $html .= '<li class="page-item"><a class="page-link" href="' . $uri . '/' . $pageNum . '">' . $pageNum . '</a></li>';
                }
                else
                {
                    $html .= '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">' . $pageNum . '</a></li>';
                }

                if ($i == $out && $pageNum < $maxPages - 1)
                {
                    $html .= '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1"> ..</a></li>';
                }
            }
        }

        if ($page != $maxPages)
        {
            $html .= '<li class="page-item"><a class="page-link" href="' . $uri . '/' . $maxPages . '">' . $maxPages . '</a></li>';
        }
        elseif ($maxPages > 1)
        {
            $html .= '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">' . $maxPages . '</a></li>';
        }

        $html .= '</ul>';

        return $html;
    }
}