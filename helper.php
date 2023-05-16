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

use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

JLoader::import('com_tz_portfolio_plus.helpers.route', JPATH_SITE . '/components');
JLoader::import('com_tz_portfolio_plus.helpers.tags', JPATH_SITE . '/components');
JLoader::import('com_tz_portfolio_plus.helpers.categories', JPATH_SITE . '/components');
JLoader::import('com_tz_portfolio_plus.libraries.plugin.helper', JPATH_ADMINISTRATOR.'/components');

class modTZ_Portfolio_PlusSingle_ArticleHelper
{
    protected static $cache;

    public static function getItem(&$params, $module = null)
    {
        $storeId    = __METHOD__;
        $storeId   .= ':'.serialize($params);
        $storeId    = md5($storeId);

        if(isset(self::$cache[$storeId])){
            return self::$cache[$storeId];
        }

        if(!$params -> get('article_id')){
            return false;
        }

        // Get the dbo
        $app    = JFactory::getApplication();
        $db     = JFactory::getDbo();
        $query  = self::getListQuery($params);

        $db->setQuery($query);
        $item = $db->loadObject();

        if ($item) {
            $related    = self::getItemRelated($item -> id, $params);

            JPluginHelper::importPlugin('content');
            TZ_Portfolio_PlusPluginHelper::importPlugin('content');
            TZ_Portfolio_PlusPluginHelper::importPlugin('mediatype');

            $app -> triggerEvent('onAlwaysLoadDocument', array('modules.mod_tz_portfolio_plus_single_article'));
//            $app -> triggerEvent('onLoadData', array('modules.mod_tz_portfolio_plus_portfolio', $items, $params));

            $item -> params = clone($params);

            $app -> triggerEvent('onTPContentBeforePrepare', array('modules.mod_tz_portfolio_plus_single_article',
                &$item, &$item -> params));

            $config = JFactory::getConfig();
            $ssl    = 2;
            if($config -> get('force_ssl')){
                $ssl    = $config -> get('force_ssl');
            }
            $uri    = JUri::getInstance();
            if($uri -> isSsl()){
                $ssl    = 1;
            }

            $item->link = JRoute::_(TZ_Portfolio_PlusHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->language));
            $item->fullLink = JRoute::_(TZ_Portfolio_PlusHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->language), true, $ssl);
            $item->author_link = JRoute::_(TZ_Portfolio_PlusHelperRoute::getUserRoute($item->author_id, $params->get('usermenuitem', 'auto')));
            $item -> category_link  = JRoute::_(TZ_Portfolio_PlusHelperRoute::getCategoryRoute($item->catslug));

            $item->parent_slug	= $item->category_alias ? ($item->parent_id.':'.$item->parent_alias) : $item->parent_id;
            $item->parent_link = JRoute::_(TZ_Portfolio_PlusHelperRoute::getCategoryRoute($item->parent_slug));

            // Get second categories
            $second_categories  = TZ_Portfolio_PlusFrontHelperCategories::getCategoriesByArticleId($item -> id,
                array('main' => false, 'reverse_contentid' => false));
            $item -> second_categories  = $second_categories;

            $media      = $item -> media;
            if(!empty($media)) {
                $registry = new Registry($media);

                $media = $registry->toObject();
                $item->media = $media;
            }

            $item -> mediatypes = array();

            $item -> tags   = TZ_Portfolio_PlusFrontHelperTags::getTagsByArticleId($item -> id, array(
                    'orderby' => 'm.contentid',
                    'menuActive' => $params -> get('tagmenuitem', 'auto')
                )
            );

            $item -> event  = new stdClass();


            if ($item->params->get('show_intro', 1)) {
                $item->text = $item->introtext.' '.$item->fulltext;
            }
            elseif ($item->fulltext) {
                $item->text = $item->fulltext;
            }
            else  {
                $item->text = $item->introtext;
            }

            if ($item->params->get('show_intro', 1)) {
                $text = $item->introtext.' '.$item->fulltext;
            }
            elseif ($item->fulltext) {
                $text = $item->fulltext;
            }
            else  {
                $text = $item->introtext;
            }

            if($item -> introtext && !empty($item -> introtext)) {
                $item->text = $item->introtext;
                $results = $app -> triggerEvent('onContentPrepare', array('modules.mod_tz_portfolio_plus_single_article', &$item, &$item->params, 0));
                $results = $app -> triggerEvent('onContentAfterTitle', array('modules.mod_tz_portfolio_plus_single_article', &$item, &$item->params, 0));
                $results = $app -> triggerEvent('onContentBeforeDisplay', array('modules.mod_tz_portfolio_plus_single_article', &$item, &$item->params, 0));
                $results = $app -> triggerEvent('onContentAfterDisplay', array('modules.mod_tz_portfolio_plus_single_article', &$item, &$item->params, 0));

                $item->introtext = $item->text;
            }
            if($item -> fulltext && !empty($item -> fulltext)) {
                $item->text = $item->fulltext;
                $results = $app -> triggerEvent('onContentPrepare', array('modules.mod_tz_portfolio_plus_single_article', &$item, &$item -> params, 0));
                $results = $app -> triggerEvent('onContentAfterTitle', array('modules.mod_tz_portfolio_plus_single_article', &$item, &$item -> params, 0));
                $results = $app -> triggerEvent('onContentBeforeDisplay', array('modules.mod_tz_portfolio_plus_single_article', &$item, &$item -> params, 0));
                $results = $app -> triggerEvent('onContentAfterDisplay', array('modules.mod_tz_portfolio_plus_single_article', &$item, &$item -> params, 0));

                $item->fulltext = $item->text;
            }

            $item -> text   = $text;

            $app -> triggerEvent('onTPContentPrepare', array ('modules.mod_tz_portfolio_plus_single_article', &$item, &$item -> params, 0));

            //Call trigger in group content
            $results = $app -> triggerEvent('onContentPrepare', array ('modules.mod_tz_portfolio_plus_single_article', &$item, &$item -> params, 0));
            $item->introtext = $item->text;

            if($introtext_limit = $item -> params -> get('introtext_limit')){
                $item -> introtext  = '<p>'.JHtml::_('string.truncate', $item->introtext, $introtext_limit, true, false).'</p>';
            }

            $results = $app -> triggerEvent('onContentAfterTitle', array('modules.mod_tz_portfolio_plus_single_article',
                &$item, &$item -> params, 0, $params->get('layout', 'default'), $module));
            $item->event->afterDisplayTitle = trim(implode("\n", $results));

            $results = $app -> triggerEvent('onContentBeforeDisplay', array('modules.mod_tz_portfolio_plus_single_article',
                &$item, &$item -> params, 0, $params->get('layout', 'default'), $module));
            if(is_array($results)){
                $results    = array_unique($results);
            }
            $item->event->beforeDisplayContent = trim(implode("\n", $results));

            $results = $app -> triggerEvent('onContentAfterDisplay', array('modules.mod_tz_portfolio_plus_single_article',
                &$item, &$item -> params, 0, $params->get('layout', 'default'), $module));
            if(is_array($results)){
                $results    = array_unique($results);
            }
            $item->event->afterDisplayContent = trim(implode("\n", $results));

            // Process the tz portfolio's content plugins.
            $results    = $app -> triggerEvent('onBeforeDisplayAdditionInfo',array('modules.mod_tz_portfolio_plus_single_article',
                &$item, &$item -> params, 0, $params->get('layout', 'default'), $module));
            if(is_array($results)){
                $results    = array_unique($results);
            }
            $item -> event -> beforeDisplayAdditionInfo   = trim(implode("\n", $results));

            $results    = $app -> triggerEvent('onAfterDisplayAdditionInfo',array('modules.mod_tz_portfolio_plus_single_article',
                &$item, &$item -> params, 0, $params->get('layout', 'default'), $module));
            if(is_array($results)){
                $results    = array_unique($results);
            }
            $item -> event -> afterDisplayAdditionInfo   = trim(implode("\n", $results));

            $results    = $app -> triggerEvent('onContentDisplayAuthorAbout',array('modules.mod_tz_portfolio_plus_single_article',
            $item -> author_id, &$item -> params, &$item, 0, $params->get('layout', 'default'), $module));
            if(is_array($results)){
                $results    = array_unique($results);
            }
            $item -> event -> authorAbout   = trim(implode("\n", $results));

            $results    = $app -> triggerEvent('onContentDisplayArticleView',array('modules.mod_tz_portfolio_plus_single_article',
                &$item, &$item -> params, 0, $params->get('layout', 'default'), $module));
            if(is_array($results)){
                $results    = array_unique($results);
            }
            $item -> event -> contentDisplayArticleView   = trim(implode("\n", $results));

            //Call trigger in group tz_portfolio_plus_mediatype
            $results    = $app -> triggerEvent('onContentDisplayMediaType',array('modules.mod_tz_portfolio_plus_single_article',
                &$item, &$item -> params, 0, $params->get('layout', 'default'), $module));
            if(is_array($results)){
                $results    = array_unique($results);
            }
            if(isset($item) && $item){
                $item -> event -> onContentDisplayMediaType    = trim(implode("\n", $results));
                if($results    = $app -> triggerEvent('onAddMediaType')){
                    $mediatypes = array();
                    foreach($results as $result){
                        if(isset($result -> special) && $result -> special) {
                            $mediatypes[] = $result -> value;
                        }
                    }
                    $item -> mediatypes = $mediatypes;
                }
            }

            $item -> related    = null;
            if($related){
                foreach($related as $i => &$itemR){

                    $app -> triggerEvent('onTPContentBeforePrepare', array('modules.mod_tz_portfolio_plus_single_article',
                        &$itemR, &$item -> params, 0, 'related'));

                    $itemR -> link   = JRoute::_(TZ_Portfolio_PlusHelperRoute::getArticleRoute($itemR -> slug, $itemR -> catid));

                    $media      = $itemR -> media;
                    $registry   = new JRegistry;
                    $registry -> loadString($media);

                    $media              = $registry -> toObject();
                    $itemR -> media     = $media;

                    $itemR -> event = new stdClass();
                    $results    = $app -> triggerEvent('onContentDisplayMediaType',array('modules.mod_tz_portfolio_plus_single_article',
                        &$itemR, &$item -> params, 0, 'related'));

                    if($itemR) {
                        $itemR->event->onContentDisplayMediaType = trim(implode("\n", $results));

                        $itemR->mediatypes = $mediatypes;
                    }else{

                        unset($related[$i]);
                    }

                    $app -> triggerEvent('onTPContentAfterPrepare', array('modules.mod_tz_portfolio_plus_single_article',
                        &$itemR, &$item -> params, 0, 'related'));
                }
                $item -> related    = $related;
            }

            $app -> triggerEvent('onTPContentAfterPrepare', array('modules.mod_tz_portfolio_plus_single_article',
                &$item, &$item -> params, 0, $params->get('layout', 'default'), $module));

            self::$cache[$storeId]  = $item;
            return $item;
        }
        return false;
    }

    public static function addonMethodIsAllowed($method, array $trace = null, $index = 1){

        if(!$method){
            return false;
        }

        // Create an exception
        $ex = new Exception();

        // Call getTrace() function
        $trace = $ex->getTrace();

        $index      = 2;

        $isAllowed  = false;
        if($trace && isset($trace[$index]) && isset($trace[$index]['function'])
            && $trace[$index]['function'] == $method) {
            $isAllowed = true;
        }

        return $isAllowed;
    }

    protected static function getItemRelated($articleId, &$params){

        $storeId    = __METHOD__;
        $storeId   .= ':'.$articleId;
        $storeId   .= ':'.serialize($params);
        $storeId    = md5($storeId);

        if(isset(self::$cache[$storeId])){
            return self::$cache[$storeId];
        }

        if(!$articleId){
            return false;
        }

//        $article    = $this -> getItem($pk);
//        $params     = $article -> params;

        $limit      = $params -> get('related_limit',5);

        $orderBy    = null;

        switch($params -> get('related_orderby','rdate')){
            default:
            case 'rdate':
                $orderBy    = 'c.created DESC';
                break;
            case 'date':
                $orderBy    = 'c.created ASC';
                break;
            case 'hits':
                $orderBy    = 'c.hits DESC';
                break;
            case 'rhits':
                $orderBy    = 'c.hits ASC';
                break;
        }

        $db     = JFactory::getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('DISTINCT c.*, cc.id AS catid,CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as slug');
        $query -> select('CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug');
        $query -> from($db -> quoteName('#__tz_portfolio_plus_content').' AS c');
        $query -> join('INNER', '#__tz_portfolio_plus_content_category_map AS m ON m.contentid = c.id AND m.main = 1');
        $query -> join('LEFT',$db -> quoteName('#__tz_portfolio_plus_categories').' AS cc ON cc.id = m.catid');

        $query -> where('c.state = 1');
        $query -> where('NOT c.id='.$articleId);
//        $query -> where('cc.id='.$article -> catid);

        if(!$params -> get('show_related_featured', 1)){
            $query -> where('c.featured <> 1');
        }elseif($params -> get('show_related_featured', 1) == 2){
            $query -> where('c.featured = 1');
        }

        if($params -> get('related_article_by', 'tag') == 'tag'){
            $query -> join('INNER', '#__tz_portfolio_plus_tag_content_map AS tm ON tm.contentid = c.id');
            $query -> join('INNER', '#__tz_portfolio_plus_tags AS t ON t.id = tm.tagsid');

            $subquery   = $db -> getQuery(true);

            $subquery -> select('t2.id');
            $subquery -> from('#__tz_portfolio_plus_tags AS t2');
            $subquery -> join('INNER', '#__tz_portfolio_plus_tag_content_map AS tm2 ON tm2.tagsid = t2.id');
            $subquery -> join('INNER', '#__tz_portfolio_plus_content AS c2 ON c2.id = tm2.contentid');
            $subquery -> where('c2.id = '. $articleId);

            $query -> where('t.id IN('.(string) $subquery.')');
        }


//        // Filter by language
//        if ($this->getState('filter.language'))
//        {
//            $query->where('c.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
//        }

        if($orderBy) {
            $query->order($orderBy);
        }

        $db -> setQuery($query,0,$limit);

        $items  = $db -> loadObjectList();
        self::$cache[$storeId]  = $items;

        return $items;
    }

    protected static function getListQuery($params){
        $db         = JFactory::getDbo();
        $user       = JFactory::getUser();
        $query      = $db -> getQuery(true);
        $articleId  = $params -> get('article_id');

        $query -> select('c.*, c.id as content_id');
        $query -> select('CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as slug');
        $query -> select('CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug');
        $query -> select('CASE WHEN CHAR_LENGTH(c.fulltext) THEN c.fulltext ELSE null END as readmore');

        $query -> from($db -> quoteName('#__tz_portfolio_plus_content').' AS c');

        $query -> join('INNER',$db -> quoteName('#__tz_portfolio_plus_content_category_map').' AS m ON m.contentid=c.id');

        $query->select('cc.id AS catid, cc.title AS category_title, cc.alias AS category_alias, cc.access AS category_access');
        $query -> join('LEFT',$db -> quoteName('#__tz_portfolio_plus_categories').' AS cc ON cc.id=m.catid');

        // Join over the categories to get parent category titles
        $query -> select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias');
        $query -> join('LEFT', '#__tz_portfolio_plus_categories as parent ON parent.id = cc.parent_id');

//        if($params -> get('related_article_by', 'tag') == 'tag'){
//            $query -> join('INNER', '#__tz_portfolio_plus_tag_content_map AS tm ON tm.contentid = c.id');
//            $query -> join('INNER', '#__tz_portfolio_plus_tags AS t ON t.id = tm.tagsid');
//
//            $subquery   = $db -> getQuery(true);
//
//            $subquery -> select('t2.id');
//            $subquery -> from('#__tz_portfolio_plus_tags AS t2');
//            $subquery -> join('INNER', '#__tz_portfolio_plus_tag_content_map AS tm2 ON tm2.tagsid = t2.id');
//            $subquery -> join('INNER', '#__tz_portfolio_plus_content AS c2 ON c2.id = tm2.contentid');
//            $subquery -> where('c2.id = '. $articleId);
//
//            $query -> where('t.id IN('.(string) $subquery.')');
//        }

        $query -> select('u.id AS author_id, u.name AS author, u.params AS author_params, u.email AS author_email');
        $query -> join('LEFT',$db -> quoteName('#__users').' AS u ON u.id=c.created_by');

        $query -> where('c.state = 1');

        $nullDate = $db->Quote($db->getNullDate());
        $nowDate = $db->Quote(JFactory::getDate()->toSQL());

        $query->where('(c.publish_up = ' . $nullDate . ' OR c.publish_up <= ' . $nowDate . ')');
        $query->where('(c.publish_down = ' . $nullDate . ' OR c.publish_down >= ' . $nowDate . ')');

        // Filter by article
        if($articleId){
            $query->where('c.id ='.$articleId);
        }

//        if($params -> get('show_noauth', 0)){
//            $groups	= implode(',', $user -> getAuthorisedViewLevels());
//
//            $query -> where('c.access IN ('.$groups.')');
//            $query -> where('cc.access IN ('.$groups.')');
//        }
//
//        // Filter by categories
//        $catids = $params -> get('catid', array());
//        if(is_array($catids)){
//            $catids = array_filter($catids);
//            if(count($catids)){
//                $query -> where('m.catid IN('.implode(',',$catids).')');
//            }
//        }
//        elseif(!empty($catids)){
//            $query -> where('m.catid IN('.$catids.')');
//        }
//
//        // Filter by media types
//        if($types = $params -> get('media_types',array())){
//            $types  = array_filter($types);
//            if(count($types)) {
//                $media_conditions   = array();
//                foreach($types as $type){
//                    $media_conditions[] = 'c.type='.$db -> quote($type);
//                }
//                if(count($media_conditions)){
//                    $query -> andWhere($media_conditions);
//                }
//            }
//        }
//
//        switch ($params -> get('orderby_sec', 'rdate')){
//            default:
//                $orderby    = 'c.id DESC';
//                break;
//            case 'rdate':
//                $orderby    = 'c.created DESC';
//                break;
//            case 'date':
//                $orderby    = 'c.created ASC';
//                break;
//            case 'alpha':
//                $orderby    = 'c.title ASC';
//                break;
//            case 'ralpha':
//                $orderby    = 'c.title DESC';
//                break;
//            case 'author':
//                $orderby    = 'u.name ASC';
//                break;
//            case 'rauthor':
//                $orderby    = 'u.name DESC';
//                break;
//            case 'hits':
//                $orderby    = 'c.hits DESC';
//                break;
//            case 'rhits':
//                $orderby    = 'c.hits ASC';
//                break;
//            case 'order':
//                $orderby    = 'c.ordering ASC';
//                break;
//        }
//
//        $query -> order($orderby);

//        $query -> group('c.id');

        return $query;
    }
}
