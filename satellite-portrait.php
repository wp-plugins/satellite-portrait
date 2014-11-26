<?php
/*
 * Plugin Name: Satellite Portrait
 * Plugin URI: http://c-pr.es/satellite/examples/satellite-portrait
 * Author: C- Pres
 * Author URI: http://c-pr.es
 * Description: Display Portraits in innovative ways using Satellite
 * License: GPL2
 * Version: 0.1
 */

/**
 * New Views for displaying portraits of people
 * @param gallery html $out
 */
if (!defined('SPPL_PLUGIN_BASENAME'))
    define('SPPL_PLUGIN_BASENAME', plugin_basename(__FILE__));
if (!defined('SPPL_PLUGIN_NAME'))
    define('SPPL_PLUGIN_NAME', trim(dirname(SPPL_PLUGIN_BASENAME), '/'));
if (!defined('SPPL_PLUGIN_DIR'))
    define('SPPL_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . SPPL_PLUGIN_NAME);
if (!defined('SPPL_PLUGIN_URL'))
    define('SPPL_PLUGIN_URL', WP_PLUGIN_URL . '/' . SPPL_PLUGIN_NAME);

class SatellitePortraitPlugin
{
    // Should be unique to this plugin
    var $pre = 'STLPTRT';

    // Keep as Satellite
    var $basename = 'Satellite';

    function __construct()
    {
        $this->initialize_options();
        add_action('wp_enqueue_scripts', array('SatellitePortraitPlugin', 'enqueue_scripts'));
        add_filter('satl_add_theme_view', array('SatellitePortraitPlugin', 'addViews'));
        add_filter('satl_add_menu', array('SatellitePortraitPlugin', 'add_menu'));
        add_filter('satl_render_view', array('SatellitePortraitPlugin', 'addRender'), 10);
    }

    public static function addViews($themes)
    {
        $themes[] = array("id" => "portrait", "title" => "Satellite Portrait");
        return $themes;
    }

    public static function addRender($params)
    {

        if (is_array($params)) {
            list($view, $slides) = $params;
            $SatellitePortraitPlugin = new SatellitePortraitPlugin();
            return $SatellitePortraitPlugin->render($view, array('slides' => $slides, 'frompost' => 'false'), false);
        } else {
            return $params;
        }
    }

    public function add_menu($menus)
    {
        add_meta_box('portraitdiv', 'Portrait Settings', array('SatellitePortraitPlugin', 'settings_portrait'), $menus, 'normal', 'core');
    }

    public function settings_portrait()
    {
        $SatellitePortraitPlugin = new SatellitePortraitPlugin();
        $SatellitePortraitPlugin->render('settings-portrait', false, true);
    }

    public function render($file = '', $params = array(), $output = true)
    {
        if (!empty($file)) {
            $filename = $file . '.php';
            $filepath = $this->plugin_base() . '/views/';
            $filefull = $filepath . $filename;
            if (file_exists($filefull)) {
                if (!empty($params)) {
                    foreach ($params as $pkey => $pval) {
                        ${$pkey} = $pval;
                    }
                }
                if ($output == false) {
                    ob_start();
                }
                include($filefull);
                if ($output == false) {
                    $data = ob_get_clean();
                    return $data;
                } else {
                    flush();
                    return true;
                }
            } else {
                return array($file, $params['slides']);
            }
        }
        return false;

    }

    public static function enqueue_scripts()
    {
        wp_register_script(SPPL_PLUGIN_NAME . '_js', SPPL_PLUGIN_URL . '/js/portrait.js', array('jquery'));
        wp_enqueue_script(SPPL_PLUGIN_NAME . '_js');

        wp_register_style(SPPL_PLUGIN_NAME . '_css', SPPL_PLUGIN_URL . '/css/portrait.css');
        wp_enqueue_style(SPPL_PLUGIN_NAME . '_css');
    }

    function plugin_base()
    {
        return rtrim(dirname(__FILE__), '/');
    }

    function add_option($name = '', $value = '')
    {
        if (add_option($this->basename . $this->pre . $name, $value)) {
            return true;
        }
        return false;
    }

    function update_option($name = '', $value = '')
    {
        if (update_option($this->basename . $this->pre . $name, $value)) {
            return true;
        }
        return false;
    }

    function get_option($name = '', $stripslashes = true)
    {
        if ($option = get_option($this->basename . $this->pre . $name)) {
            if (!is_array($option) && @unserialize($option) !== false) {
                return unserialize($option);
            }
            if ($stripslashes == true) {
                $option = stripslashes_deep($option);
            }
            return $option;
        } elseif ($option = get_option($this->basename . $name)) {
            if (!is_array($option) && @unserialize($option) !== false) {
                return unserialize($option);
            }
            if ($stripslashes == true) {
                $option = stripslashes_deep($option);
            }
            return $option;
        }
        return false;
    }

    public function initialize_options()
    {
        $settings = array(
            'width' => '160',
            'height' => '180',
            'crop' => true,
            'bootstrap' => false,
            'bootstrap-css' => 'col-md-3 col-sm-4 col-xs-6'
        );
        $this->add_option('Portrait', $settings);
    }


}

$SatellitePortraitPlugin = new SatellitePortraitPlugin();