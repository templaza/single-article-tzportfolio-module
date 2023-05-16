<?php
/*------------------------------------------------------------------------

# Music Addon

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2016 tzportfolio.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Website: http://www.tzportfolio.com

# Technical Support:  Forum - http://tzportfolio.com/forum

# Family website: http://www.templaza.com

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

if(modTZ_Portfolio_PlusSingle_ArticleHelper::addonMethodIsAllowed('onContentDisplayArticleView')) {
    if (!isset($songs)) {
        if ($__model = $this->getModel('Music', 'PlgTZ_Portfolio_PlusContentModel',
            array('ignore_request' => true))) {
            $__model->setState('filter.contentid', $item->id);
            $__model->setState('list.music_order', $params->get('music_order', 'rdate'));

            $songs = $__model->getItems();
        }
    }

    if ($params->get('music_show_article', 1) && isset($songs) && $songs) {

        if(count($songs) && (!isset($song) || !isset($playlist))){
            $playlist = array();
            foreach ($songs as $i => $_song) {
                if ($_song->value && !empty($_song->value)) {
                    $playlist[$i] = array();
                    $playlist[$i]['title'] = $_song->value->title;
                    if (isset($_song->value->thumbnail) && $_song->value->thumbnail) {
                        $playlist[$i]['poster'] = JUri::root(true) . '/' . $_song->value->thumbnail;
                    }
                    if (isset($_song->value->description) && $_song->value->description) {
                        $playlist[$i]['description'] = $_song->value->description;
                    }else{
                        $playlist[$i]['description'] = '';
                    }
                    if ($listfiles = $_song->value->file_names) {
                        foreach ($listfiles as $file) {
                            $ext = JFile::getExt($file);
                            if($ext == 'webm'){
                                $playlist[$i]['webmv'] = JUri::root() . $file;
                            }else {
                                $playlist[$i][$ext] = JUri::root() . $file;
                            }
                        }
                    }
                }
            }
            if(count($playlist) == 1){
                $song   = $playlist[0];
            }
        }

        $doc = JFactory::getDocument();
        $doc->addStyleSheet(TZ_Portfolio_PlusUri::base(true) . '/addons/content/music/css/style.css');
        $doc->addScript(TZ_Portfolio_PlusUri::base(true) . '/addons/content/music/libraries/jplayer-2.9.2/js/jquery.jplayer.min.js');
        $doc->addScript(TZ_Portfolio_PlusUri::base(true) . '/addons/content/music/libraries/jplayer-2.9.2/add-on/jplayer.playlist.min.js');

        if ($params->get('music_enable_glyphicon', 1)) {
            $doc->addStyleSheet(TZ_Portfolio_PlusUri::base(true) . '/addons/content/music/css/glyphicons.css');
        }

        $mlayout = 'default';
        if ($layout && strpos($layout, ':') !== false) {
            list($prefix, $mlayout) = explode(':', $layout);
        }

        if (count($songs) == 1) {
            if (($__msinglePath = TZ_Portfolio_PlusModuleHelper::getAddOnModuleLayout('content', 'music', 'mod_tz_portfolio_plus_single_article', $mlayout . '_single', $params))
                && strrpos($__msinglePath, $mlayout . '_single.php') !== false) {
                require $__msinglePath;
            }
        } elseif (count($songs) > 1) {
            if (($__mplaylistPath = TZ_Portfolio_PlusModuleHelper::getAddOnModuleLayout('content', 'music', 'mod_tz_portfolio_plus_single_article', $mlayout . '_playlist', $params))
                && strrpos($__mplaylistPath, $mlayout . '_playlist.php') !== false) {
                require $__mplaylistPath;
            }
        }
    }
}
