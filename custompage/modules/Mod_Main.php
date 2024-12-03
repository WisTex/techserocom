<?php

/**
 * * CustomPage Webdesign Module
 * This is a module that is part of the "CustomPage" addon.
 * This module's URL is example.com/webdesign
*/

namespace Zotlabs\Module;

use App;
use Zotlabs\Lib\Apps;
use Zotlabs\Web\Controller;
use Zotlabs\Widget\Whats_new;

// Webdesign class "controller" logic for the plugin's "webdesign" route
class Main extends Controller {

	// Class Fields
	public string $_moduleName = '';
	
	// Method executed during page initialization
	public function init(): void {
		// Set pluginName string to this class's name 
		$this->_moduleName = strtolower(trim(strrchr(__CLASS__, '\\'), '\\'));
	}
	
	// Generic handler for a HTTP POST request (e.g., a form submission)
	public function post(): void {
		// Presumably, check for a valid CSRF form token
		check_form_security_token_redirectOnErr('/' . $this->_moduleName, $this->_moduleName);

		// Trigger the get() function in this class to render content
		$this->get();
	}

	// Generic handler for a HTTP GET request (e.g., viewing the page normally)
	public function get(): string {
		require_once(PROJECT_BASE . '/widget/Whats_new/Whats_new.php');
		$whatsNewWidget = new Whats_new();
		// Create page sections, inserting template vars
        $content = replace_macros(get_markup_template($this->_moduleName . ".tpl", 'addon/custompage'), [
			'$action_url' => $this->_moduleName,
			'$form_security_token' => get_form_security_token($this->_moduleName),
			'$title' => t('Web Design'),
			'$content' => t('Page content goes here.'),
			'$submit' => t('Submit'),
			'$whatsnew' => $whatsNewWidget->widget([
				'channel_id' => 2,
				'num_posts' => 3,
				'blurb_length' => 200,
				'widget_title' => t('Inside the Buzz at Techsero. . .')
			]),
		]);
		//$footer = replace_macros(get_markup_template("footer_custom.tpl", 'addon/custompage'), []);        

		// Return/Render content in the plugin template's "content" region
		//return $content;
        //die(print_r(App::$page));
		//die(print_r(App::$pdl));
        App::$page['title'] = "TechSero Web Services";
        // App::$page['content'] = $content;
		return $content;
        //App::$page['footer'] = $footer;
	}

}




