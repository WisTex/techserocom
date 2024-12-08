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

// Webdesign class "controller" logic for the plugin's "webdesign" route
class Hubzilla extends Controller {

	// Class Fields
	private string $_moduleName = '';
	
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
	public function get(): void {
		// Create page sections, inserting template vars
		$content = replace_macros(get_markup_template($this->_moduleName . ".tpl", 'addon/custompage'), [
			'$action_url' => $this->_moduleName,
			'$form_security_token' => get_form_security_token($this->_moduleName),
			'$title' => t('Hubzilla'),
			'$content' => t('Page content goes here.'),
			'$submit' => t('Submit')
		]);
		//$footer = replace_macros(get_markup_template("footer_custom.tpl", 'addon/custompage'), []);        

		// Set page metadata
		$thisUrl = z_root() . "/" . $this->_moduleName;
        App::$page['title'] = "Managed Hubzilla - TechSero";
		App::$meta->set('description', 'Hubzilla without the hassle. We take care of the hosting, technical aspects, and automatic updates. You just focus on your content and social life.');
		head_add_link(['rel' => 'canonical', 'href' => $thisUrl]);
		App::$meta->set('og:type', 'website');
		App::$meta->set('og:title', App::$page['title']);
        App::$meta->set('og:url', $thisUrl);
        App::$meta->set('og:description', App::$meta->get_field('description'));
		App::$meta->set('og:image', z_root() . '/addon/custompage/images/techsero-logo-plain-reverse.png');

		// Return/Render content in the plugin template's "content" region
		//return $content;
        //die(print_r(App::$page));
        App::$page['content'] = $content;
        //App::$page['footer'] = $footer;
	}

}




