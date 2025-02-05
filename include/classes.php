<?php

class mf_links
{
	var $post_type = 'mf_links';
	var $meta_prefix;
	var $no_popup_class;

	function __construct()
	{
		$this->meta_prefix = $this->post_type.'_';
		$this->no_popup_class = $this->meta_prefix.'no_popup';
	}

	function settings_links()
	{
		$options_area = __FUNCTION__;

		add_settings_section($options_area, "", array($this, $options_area."_callback"), BASE_OPTIONS_PAGE);

		$arr_settings = array(
			'setting_links_open_new_tab' => __("Open in a new tab", 'lang_links'),
		);

		if(get_option('setting_links_open_new_tab') != '')
		{
			$arr_settings['setting_links_icon'] = __("Display Icon", 'lang_links');
			$arr_settings['setting_links_title'] = __("Display Title", 'lang_links');
			$arr_settings['setting_links_confirm'] = __("Confirm Question", 'lang_links');
		}

		else
		{
			delete_option('setting_links_icon');
			delete_option('setting_links_title');
			delete_option('setting_links_confirm');
		}

		show_settings_fields(array('area' => $options_area, 'object' => $this, 'settings' => $arr_settings));
	}

	function settings_links_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);

		echo settings_header($setting_key, __("Links", 'lang_links'));
	}

	function setting_links_open_new_tab_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		$arr_data = array(
			'' => __("No", 'lang_links'),
			'external' => __("Yes", 'lang_links')." (".__("External", 'lang_links').")",
			//'all' => __("Yes", 'lang_links')." (".__("All", 'lang_links').")",
		);

		echo show_select(array('data' => $arr_data, 'name' => $setting_key, 'value' => $option, 'description' => sprintf(__("This can be ignored by adding the class %s to a link", 'lang_links'), "<code>".$this->no_popup_class."</code>")));
	}

	function setting_links_icon_callback()
	{
		global $obj_base;

		if(!isset($obj_base))
		{
			$obj_base = new mf_base();
		}

		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		echo show_select(array('data' => $obj_base->get_icons_for_select(), 'name' => $setting_key, 'value' => $option, 'description' => __("This will be displayed to the right of the link", 'lang_links')));
	}

	function setting_links_title_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'description' => __("This will be displayed when hovering the link", 'lang_links')));
	}

	function setting_links_confirm_callback()
	{
		$setting_key = get_setting_key(__FUNCTION__);
		$option = get_option($setting_key);

		echo show_textfield(array('name' => $setting_key, 'value' => $option, 'description' => __("This will display a confirmation dialog to the visitor before being sent to the new tab", 'lang_links')));
	}

	function filter_sites_table_settings($arr_settings)
	{
		/*$arr_settings['settings_links'] = array(
			'setting_links_schedule' => array(
				'type' => 'string',
				'global' => true,
				'icon' => "fas fa-download",
				'name' => __("Links", 'lang_links')." - ".__("Schedule", 'lang_links'),
			),
		);*/

		return $arr_settings;
	}

	function wp_head()
	{
		$plugin_include_url = plugin_dir_url(__FILE__);

		$setting_links_open_new_tab = get_option('setting_links_open_new_tab');

		if($setting_links_open_new_tab != '')
		{
			$setting_links_icon = get_option('setting_links_icon');
			$setting_links_title = get_option('setting_links_title');
			$setting_links_confirm = get_option('setting_links_confirm');

			if($setting_links_icon != '')
			{
				global $obj_base;

				if(!isset($obj_base))
				{
					$obj_base = new mf_base();
				}

				$plugin_base_include_url = plugins_url()."/mf_base/include/";

				$obj_base->load_font_awesome(array(
					'type' => 'public',
					'plugin_include_url' => $plugin_base_include_url,
					//'plugin_version' => $plugin_version,
				));
			}

			//mf_enqueue_style('style_links', $plugin_include_url."style.css");
			mf_enqueue_script('script_links', $plugin_include_url."script.js", array(
				'setting_links_open_new_tab' => $setting_links_open_new_tab,
				'no_popup_class' => $this->no_popup_class,
				'setting_links_icon' => $setting_links_icon,
				'setting_links_title' => $setting_links_title,
				'setting_links_confirm' => $setting_links_confirm,
			));
		}
	}
}