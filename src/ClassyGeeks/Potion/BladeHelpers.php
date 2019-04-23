<?php
/**
 * Copyright 2016 Matthew R. Miller via Classy Geeks llc. All Rights Reserved
 * http://classygeeks.com
 * MIT License:
 * http://opensource.org/licenses/MIT
 */

/**
 * Namespace
 */
namespace ClassyGeeks\Potion;

use Illuminate\Support\Facades\Cache;

/**
 * Class BladeHelpers
 * @package ClassyGeeks\Potion
 */
class BladeHelpers
{
    /**
     * Asset url
     * @param $name
     * @param $version
     * @return bool|string
     */
    public static function assetUrl($name, $version = false)
    {
        // Global app
        global $app;

        // Get cache
        $cache = Cache::get('potion_assets', []);

        // Check for asset
        if (!isset($cache[$name])) {
            return false;
        }

        // Get config
        $config = (isset($app['config']['potion']) ? $app['config']['potion'] : false);

        // Get Url
        $ret = rtrim($config['base_url'], '/');

        // Add name
        $name = ltrim($name, '/');
        $ret .= "/{$name}";

        // Version?
        if ($version) {
            $ret .= "?v={$cache[$name]}";
        }

        return $ret;
    }

    /**
     * Asset Css
     * @param $name
     * @param $version
     * @param $rel
     * @return bool|string
     */
    public static function assetCss($name, $version = false, $rel = 'stylesheet')
    {
        // Get cache
        $cache = Cache::get('potion_assets', []);

        // Check for asset
        if (!isset($cache[$name])) {
            return false;
        }

        // Url
        $url = self::assetUrl($name, $version);

        // Return
        return "<link href=\"{$url}\" rel=\"{$rel}\" type=\"text/css\" />\n";
    }

    /**
     * Asset Js
     * @param $name
     * @param $version
     * @param $defer
     * @return bool|string
     */
    public static function assetJs($name, $version = false, $defer = FALSE)
    {
        // Get cache
        $cache = Cache::get('potion_assets', []);

        // Check for asset
        if (!isset($cache[$name])) {
            return false;
        }

        // Url
        $url = self::assetUrl($name, $version);

        // Deferred ?
        $defer = $defer ? 'defer' : '';

        // Return
        return "<script type=\"text/javascript\" src=\"{$url}\" $defer></script>\n";
    }

    /**
     * Asset Img
     * @param $name
     * @param $version
     * @return bool|string
     */
    public static function assetImg($name, $version = false)
    {
        // Get cache
        $cache = Cache::get('potion_assets', []);

        // Check for asset
        if (!isset($cache[$name])) {
            return false;
        }

        // Url
        $url = self::assetUrl($name, $version);

        // Return
        return "<img src=\"{$url}\" />\n";
    }
}
