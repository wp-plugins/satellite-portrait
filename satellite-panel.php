<?php
/*
 * Plugin Name: Satellite Panel
 * Plugin URI: http://c-pr.es/satellite/examples/satellite-portrait
 * Author: C- Pres
 * Author URI: http://c-pr.es
 * Description: Display Panels in innovative ways using Satellite
 * License: GPL2
 * Version: 0.1
 */

/**
 * New Views for displaying portraits of people
 * @param gallery html $out
 */
if (!defined('SPNL_PLUGIN_BASENAME'))
    define('SPNL_PLUGIN_BASENAME', plugin_basename(__FILE__));
if (!defined('SPNL_PLUGIN_NAME'))
    define('SPNL_PLUGIN_NAME', trim(dirname(SPNL_PLUGIN_BASENAME), '/'));
if (!defined('SPNL_PLUGIN_DIR'))
    define('SPNL_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . SPNL_PLUGIN_NAME);
if (!defined('SPNL_PLUGIN_URL'))
    define('SPNL_PLUGIN_URL', WP_PLUGIN_URL . '/' . SPNL_PLUGIN_NAME);

class SatellitePanelPlugin
{
    // Should be unique to this plugin
    var $pre = 'STLPNL';

    // Keep as Satellite
    var $basename = 'Satellite';

    function __construct()
    {
        $this->initialize_options();
        add_action('wp_enqueue_scripts', array('SatellitePanelPlugin', 'enqueue_scripts'));
        add_filter('satl_add_theme_view', array('SatellitePanelPlugin', 'addViews'));
        add_filter('satl_add_menu', array('SatellitePanelPlugin', 'add_menu'));
        add_filter('satl_render_view', array('SatellitePanelPlugin', 'addRender'), 10);
    }

    public static function addViews($themes)
    {
        $themes[] = array("id" => "panel", "title" => "Satellite Panel");
        return $themes;
    }

    public static function addRender($params)
    {
      error_log('panel render');
        if (is_array($params)) {
            list($view, $slides) = $params;
            $SatellitePanelPlugin = new SatellitePanelPlugin();
            return $SatellitePanelPlugin->render($view, array('slides' => $slides, 'frompost' => 'false'), false);
        } else {
            return $params;
        }
    }

    public function add_menu($menus)
    {
        add_meta_box('paneldiv', 'Panel Settings', array('SatellitePanelPlugin', 'settings_panel'), $menus, 'normal', 'core');
    }

    public function settings_panel()
    {
        $SatellitePanelPlugin = new SatellitePanelPlugin();
        $SatellitePanelPlugin->render('settings-panel', false, true);
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
        wp_register_script(SPNL_PLUGIN_NAME . '_js', SPNL_PLUGIN_URL . '/js/panel.js', array('jquery'));
        wp_enqueue_script(SPNL_PLUGIN_NAME . '_js');

        wp_register_style(SPNL_PLUGIN_NAME . '_css', SPNL_PLUGIN_URL . '/css/panel.css');
        wp_enqueue_style(SPNL_PLUGIN_NAME . '_css');
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
            'bootstrap' => false
        );
        $this->add_option('Panel', $settings);
    }


}

$SatellitePanelPlugin = new SatellitePanelPlugin();