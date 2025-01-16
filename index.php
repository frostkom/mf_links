<?php
/*
Plugin Name: MF Links
Plugin URI: https://github.com/frostkom/mf_links
Description:
Version: 1.0.7
Licence: GPLv2 or later
Author: Martin Fors
Author URI: https://martinfors.se
Text Domain: lang_links
Domain Path: /lang

Depends: MF Base
GitHub Plugin URI: frostkom/mf_links
*/

if(!function_exists('is_plugin_active') || function_exists('is_plugin_active') && is_plugin_active("mf_base/index.php"))
{
	include_once("include/classes.php");

	$obj_links = new mf_links();

	if(is_admin())
	{
		register_uninstall_hook(__FILE__, 'uninstall_links');

		add_action('admin_init', array($obj_links, 'settings_links'));

		add_filter('filter_sites_table_settings', array($obj_links, 'filter_sites_table_settings'));

	}

	else
	{
		add_action('wp_head', array($obj_links, 'wp_head'), 0);
	}

	load_plugin_textdomain('lang_links', false, dirname(plugin_basename(__FILE__))."/lang/");

	function uninstall_links()
	{
		mf_uninstall_plugin(array(
			'options' => array('setting_links_open_new_tab', 'setting_links_icon', 'setting_links_title', 'setting_links_confirm'),
		));
	}
}