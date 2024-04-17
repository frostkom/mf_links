jQuery(function($)
{
	switch(script_links.setting_links_open_new_tab)
	{
		case 'external':
			$("a").each(function()
			{
				var dom_obj = $(this),
					dom_href = (this.href || '');

				if(dom_obj.hasClass(script_links.no_popup_class))
				{
					/* Do nothing */
					console.log("This has class");
				}

				else if(dom_obj.parents("." + script_links.no_popup_class).length > 0)
				{
					console.log("Parent has class");
				}

				else if(dom_href != '' && dom_href != '#')
				{
					var a = new RegExp('/' + window.location.host + '/');

					if(!a.test(this.href))
					{
						$(this).attr({'target': '_blank'});

						if(script_links.setting_links_title != '')
						{
							$(this).attr({'title': script_links.setting_links_title});
						}

						if(script_links.setting_links_icon != '')
						{
							$(this).append("&nbsp;<i class='" + script_links.setting_links_icon + " fa-xs'></i>");
						}
					}
				}
			});

			if(script_links.setting_links_confirm != '')
			{
				$(document).on('click', "a[target='_blank']", function()
				{
					return confirm(script_links.setting_links_confirm);
				});
			}
		break;
	}
});