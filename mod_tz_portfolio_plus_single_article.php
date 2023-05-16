<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Single Article Module

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Website: http://www.tzportfolio.com

# Technical Support:  Forum - https://www.tzportfolio.com/help/forum.html

# Family website: http://www.templaza.com

# Family Support: Forum - https://www.templaza.com/Forums.html

# Copyright: Copyright (C) 2011-2019 TZ Portfolio (http://www.tzportfolio.com). All Rights Reserved.

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

use TZ_Portfolio_Plus\Helper\LayoutHelper;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

JLoader::import('com_tz_portfolio_plus.libraries.helper.modulehelper', JPATH_ADMINISTRATOR.'/components');
JLoader::import('extrafields', COM_TZ_PORTFOLIO_PLUS_SITE_HELPERS_PATH);

JHtml::_('jquery.framework');

$doc    = JFactory::getDocument();

if($params -> get('enable_bootstrap', 0)  && $params -> get('enable_bootstrap_js', 1)) {
    if( $params -> get('bootstrapversion', 3) == 4) {
        $doc->addScript(TZ_Portfolio_PlusUri::base(true) . '/vendor/bootstrap/js/bootstrap.min.js',
            array('version' => 'auto'));
        $doc->addScript(TZ_Portfolio_PlusUri::base(true) . '/vendor/bootstrap/js/bootstrap.bundle.min.js',
            array('version' => 'auto'));
    }else{
        $doc -> addScript(TZ_Portfolio_PlusUri::base(true).'/bootstrap/js/bootstrap.min.js',
            array('version' => 'auto'));
    }
}

$doc -> addScript(TZ_Portfolio_PlusUri::root(true).'/js/core.min.js');

$item = modTZ_Portfolio_PlusSingle_ArticleHelper::getItem($params, $module);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

JLoader::import('com_tz_portfolio_plus.libraries.helper.layouthelper', JPATH_ADMINISTRATOR.'/components');

$layoutHtml = null;

if(class_exists('TZ_Portfolio_Plus\Helper\LayoutHelper')) {
    if(!empty($item)) {
        $layoutHtml = LayoutHelper::generateLayout(array(&$item, &$item->params, null, $module, 0, 'modules.mod_tz_portfolio_plus_single_article'));
    }
}

require TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, $params->get('layout', 'default'));
