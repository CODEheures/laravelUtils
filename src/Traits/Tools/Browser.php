<?php

namespace Codeheures\LaravelUtils\Traits\Tools;


trait Browser
{
    /**
     *
     * Return the name of client browser
     *
     * @return string
     */
    public static function getBrowserName() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'opera';
        elseif (strpos($user_agent, 'Edge')) return 'edge';
        elseif (strpos($user_agent, 'Chrome')) return 'chrome';
        elseif (strpos($user_agent, 'Safari')) return 'safari';
        elseif (strpos($user_agent, 'Firefox')) return 'firefox';
        elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'internet explorer';

        return 'Other';
    }
}