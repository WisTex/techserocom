<?php
/**
 * Name: CustomPage
 * Description: Add a custom page to a theme.
 * Version: 1.0
 * Depends: Core
 * Recommends: None
 * Category: CustomPage
 * Author: Randall Jaffe
*/

/**
 * * CustomPage Addon
 * This is the primary file defining the addon.
 * It defines the name of the addon and gives information about the addon to other components of Hubzilla.
*/

// Hubzilla
use Zotlabs\Lib\Apps;
use Zotlabs\Extend\Hook;
use Zotlabs\Extend\Route;
use Zotlabs\Render\Comanche;

// Addon Modules
use Zotlabs\Module\Webdesign;
use Zotlabs\Module\Hubzilla;
use Zotlabs\Module\Main;
use Zotlabs\Module\Webservices;
use Zotlabs\Module\Contentcreation;

class CustomPage {
    const _CUSTOM_PAGES = ['webdesign', 'hubzilla', 'contentcreation', 'webservices', 'main'];
    const _ENABLE_SIDEBAR = false;
    public static function loadAssets(): void {
        if (file_exists(PROJECT_BASE . '/addon/custompage/view/js/custompage.js'))
            head_add_js('/addon/custompage/view/js/custompage.js');

        if (file_exists(PROJECT_BASE . '/addon/custompage/view/css/custompage.css'))
            head_add_css('/addon/custompage/view/css/custompage.css');

        if (file_exists(PROJECT_BASE . '/addon/custompage/view/css/codestitch.css'))
            head_add_css('/addon/custompage/view/css/codestitch.css');

        if (file_exists(PROJECT_BASE . '/addon/custompage/view/css/codestitch-techsero.css'))
            head_add_css('/addon/custompage/view/css/codestitch-techsero.css');

    }

}

/**
 * * This function registers (adds) the hook handler and route.
 * The custompage_customize_header() hook handler is registered for the "page_header" hook
 * The custompage_customize_footer() hook handler is registered for the "page_end" hook
 * The "webdesign" route is created for Mod_Webdesign module 
*/
function custompage_load() {
    Hook::register('logged_in', 'addon/custompage/custompage.php', 'custompage_logged_in');
    Hook::register('module_loaded', 'addon/custompage/custompage.php', 'custompage_load_module');
    Hook::register('load_pdl', 'addon/custompage/custompage.php', 'custompage_load_pdl');
    Hook::register('page_header', 'addon/custompage/custompage.php', 'custompage_customize_header');
    Hook::register('page_end', 'addon/custompage/custompage.php', 'custompage_customize_footer');
    Hook::register('home_content', 'addon/custompage/custompage.php', 'custompage_home_redirect');
    Hook::register('home_init', 'addon/custompage/custompage.php', 'custompage_home_redirect_loggedin');
    /* You will need a route and a corresponding module for every custom URL */
	Route::register('addon/custompage/modules/Mod_Webdesign.php', 'webdesign');
    Route::register('addon/custompage/modules/Mod_Hubzilla.php', 'hubzilla');
	Route::register('addon/custompage/modules/Mod_Contentcreation.php', 'contentcreation');
    Route::register('addon/custompage/modules/Mod_Webservices.php', 'webservices');    
    Route::register('addon/custompage/modules/Mod_Main.php', 'main');    
}

// * This function unregisters (removes) the hook handler and route.
function custompage_unload() {
    Hook::unregister('logged_in', 'addon/custompage/custompage.php', 'custompage_logged_in');
    Hook::unregister('module_loaded', 'addon/custompage/custompage.php', 'custompage_load_module');
    Hook::unregister('load_pdl', 'addon/custompage/custompage.php', 'custompage_load_pdl');
	Hook::unregister('page_header', 'addon/custompage/custompage.php', 'custompage_customize_header');
    Hook::unregister('page_end', 'addon/custompage/custompage.php', 'custompage_customize_footer');
    Hook::unregister('home_content', 'addon/custompage/custompage.php', 'custompage_home_redirect');
    Hook::unregister('home_init', 'addon/custompage/custompage.php', 'custompage_home_redirect_loggedin');
    /* You will need a route and a corresponding module for every custom URL */
	Route::unregister('addon/custompage/modules/Mod_Webdesign.php', 'webdesign');
    Route::unregister('addon/custompage/modules/Mod_Hubzilla.php', 'hubzilla');
	Route::unregister('addon/custompage/modules/Mod_Contentcreation.php', 'contentcreation');
    Route::unregister('addon/custompage/modules/Mod_Webservices.php', 'webservices');    
    Route::unregister('addon/custompage/modules/Mod_Main.php', 'main');    
}

/** 
 * * This function runs when the hook handler is executed.
 * @param $user: A reference to App::$account or App::$user
*/
function custompage_logged_in(&$user) {
	goaway(z_root() . "/hq");
	killme();
}

/** 
 * * This function runs when the hook handler is executed.
 * @param $o: A reference to Home module get() output
*/
function custompage_home_redirect(&$o) {
	//header("Location: " . z_root() . "/main", true, 301);
	//killme();
    require_once('addon/custompage/modules/Mod_Main.php');
    $module = new Main();
    if (method_exists($module, 'init')) {
        $module->init();
    }
    $pdl = @file_get_contents('addon/custompage/pdl/mod_main.pdl');
    App::$comanche->parse($pdl);
    App::$pdl = $pdl;
    CustomPage::loadAssets();
    if (method_exists($module, 'get')) {
        $o = $module->get();
    }
}


/** 
 * * This function runs when the hook handler is executed.
 * @param $ret: A reference to Home module init() object
*/
function custompage_home_redirect_loggedin(&$ret) {
    //$ret['startpage'] = z_root() . "/main";
    require_once('addon/custompage/modules/Mod_Main.php');
    $module = new Main();
    $module->_moduleName = 'main';
    $pdl = @file_get_contents('addon/custompage/pdl/mod_main.pdl');
    App::$comanche = new Comanche();
    App::$comanche->parse($pdl);
    App::$pdl = $pdl;
    CustomPage::loadAssets();
    if (method_exists($module, 'get')) {
        App::$page['content'] = $module->get();
    }
    construct_page();
    killme();
}



/** 
 * * This function runs when the hook handler is executed.
 * @param $arr: A reference to current module
*/
function custompage_load_module(&$arr) {
	if (in_array($arr['module'], CustomPage::_CUSTOM_PAGES)) {
        //$type = ucfirst($arr['module']);
		//require_once('addon/custompage/modules/Mod_' . $type . '.php');
        //$arr['controller'] = new $type();
		//$arr['installed']  = true;
	}
}

/** 
 * * This function runs when the hook handler is executed.
 * @param $arr: A reference to current module and layout
*/
function custompage_load_pdl(&$arr) {
    //die(print_r($arr));
	$pdl = 'addon/custompage/pdl/mod_' . $arr['module'] . '.pdl';
    if (in_array($arr['module'], CustomPage::_CUSTOM_PAGES) && file_exists($pdl)) {
        $arr['layout'] = @file_get_contents($pdl);
	}
}

/** 
 * * This function runs when the hook handler is executed.
 * @param $content: A reference to page header content
*/
function custompage_customize_header(&$content) {
    // Replace Neuhub page header with a custom header
    if (in_array(App::$module, CustomPage::_CUSTOM_PAGES)) {
        //$content = replace_macros(get_markup_template('header_custom.tpl', 'addon/custompage'), []);
        // head_add_css('/addon/custompage/view/css/custompage.css');
        // head_add_css('/addon/custompage/view/css/codestitch.css');
        // head_add_css('/addon/custompage/view/css/codestitch-techsero.css');
        CustomPage::loadAssets();
        if (!CustomPage::_ENABLE_SIDEBAR) {
            $content = preg_replace('/<aside[^>]*>.+?<\/aside>/s', "", $content);
        }
    }
}

/** 
 * * This function runs when the hook handler is executed.
 * @param $content: A reference to page footer content
*/
function custompage_customize_footer(&$content) {
    // Replace Neuhub page footer with a custom footer
    if (in_array(App::$module, CustomPage::_CUSTOM_PAGES)) {
        $content .= replace_macros(get_markup_template('footer_custom.tpl', 'addon/custompage'), []);
    }
}

