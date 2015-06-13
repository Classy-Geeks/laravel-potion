<?php
/**
 * Copyright 2015 Classy Geeks llc. All Rights Reserved
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
     * listStyles - create a list of compiled styles for insertion into the page header
     * @param $withCacheBust
     * @return bool|string
     */
    public static function listStyles($withCacheBust = true)
    {
        $results = '';

        // Get cache
        $cache = Cache::get('potion_assets', []);

        // Cycle through all the assets and build a list of styles
        foreach($cache as $assetPath => $version) {
            if (substr(strtolower($assetPath),-4) == '.css') {
                // build an asset entry
                $results = $results . self::assetCss($assetPath, 'stylesheet', $cache)."\n";
            }
        }
        return $results;
    }



    /**
     * listScripts - create a list of compiled scripts for insertion into page (footer, best practice)
     * @param $withCacheBust
     * @return bool|string
     */
    public static function listScripts($withCacheBust = true)
    {
        $results = '';

        // Get cache
        $cache = Cache::get('potion_assets', []);

        // Cycle through all the assets and build a list of styles
        foreach($cache as $assetPath => $version) {
            if (substr(strtolower($assetPath),-3) == '.js') {
                // build an asset entry
                $results = $results . self::assetJs($assetPath, 'stylesheet', $cache)."\n";
            }
        }
        return $results;
    }



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
     * @param $rel
     * @param $version
     * @return bool|string
     */
    public static function assetCss($name, $rel = 'stylesheet', $version = false)
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
        return "<link href=\"{$url}\" rel=\"{$rel}\" type=\"text/css\" />";
    }

    /**
     * Asset Js
     * @param $name
     * @param $version
     * @return bool|string
     */
    public static function assetJs($name, $version = false)
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
        return "<script type=\"text/javascript\" src=\"{$url}\"></script>";
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
        return "<img src=\"{$url}\" />";
    }
}