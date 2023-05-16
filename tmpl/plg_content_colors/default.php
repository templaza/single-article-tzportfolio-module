<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2015 templaza.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

if(modTZ_Portfolio_PlusSingle_ArticleHelper::addonMethodIsAllowed('onContentDisplayArticleView')) {
    if (!isset($item) && isset($article)) {
        $item = $article;
    }
    if (!isset($color)) {
        $this->setVariable('color', null);
        JLoader::import('com_tz_portfolio_plus.addons.content.colors.models.article', JPATH_SITE . '/components');
        if ($__model = JModelLegacy::getInstance('Article', 'PlgTZ_Portfolio_PlusContentColorsModel',
            array('ignore_request' => true))) {
            $__model->set('article', $article);
            $__model->set('addon', $this);
            $__model->set('trigger_params', $params);

            $color = $__model->getItem();
        }
    }

    if (isset($color) && $color && isset($color->pallete)) {

        $document = JFactory::getDocument();
        $document->addStyleSheet(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/css/style.css');
        $document->addStyleSheet(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/css/ns-default.css');
        $document->addStyleSheet(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/css/ns-style-growl.css');

        $document->addScript(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/js/modernizr.custom.js');
        $document->addScript(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/js/classie.js');
        $document->addScript(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/js/notificationFx.js');
        $document->addScript(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/js/colors.js');

        $pallete = $color->pallete;
        if ($params->get('show_colors', 1)):
            ?>
            <div class="colors-addon">
                <?php if ($params->get('show_aco', 1)) : ?>
                    <a class="stats-action" href="<?php echo $color->aco; ?>"><img width="20" height="20"
                                                                                   src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMS45OTkgNTExLjk5OSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTExLjk5OSA1MTEuOTk5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTQzNC45MjcsMTkxLjQzNWwtMC43NzItMS4wNDVsLTAuMTUzLTAuMzA2bC03MC4xMS0xMDQuMDc4bC03MC4xMTEsMTA0LjA3OWwtMC4xNDYsMC4yOTJsLTAuNzc5LDEuMDU5ICAgIGMtMTEuMjUsMTUuMjM2LTE3LjE5NiwzMy4zMzctMTcuMTk2LDUyLjM0OGMwLDQ4LjY1MiwzOS41ODEsODguMjMxLDg4LjIzMSw4OC4yMzFjNDguNjUsMCw4OC4yMzEtMzkuNTgsODguMjMxLTg4LjIzMSAgICBDNDUyLjEyNCwyMjQuNzcyLDQ0Ni4xNzcsMjA2LjY2OSw0MzQuOTI3LDE5MS40MzV6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNMzYzLjg5MywzNjIuMDc3Yy02NS4yMjgsMC0xMTguMjkzLTUzLjA2Ni0xMTguMjkzLTExOC4yOTNjMC0yNS4zNTYsNy44OTktNDkuNTE3LDIyLjg0Ni02OS44OTVsNDYuMDg5LTY4LjQxOUwyNDMuNDg0LDAgICAgTDk1LjQ0OSwyMTkuNzUzYy0yMy4yNzUsMzEuNjc0LTM1LjU3NCw2OS4yMjgtMzUuNTc0LDEwOC42MzZjMCwxMDEuMjQzLDgyLjM2NywxODMuNjEsMTgzLjYxLDE4My42MSAgICBjOTUuOTI5LDAsMTc0Ljg5OS03My45NTEsMTgyLjkyNS0xNjcuODM4QzQwOC4yNTksMzU1LjUwOCwzODYuODMxLDM2Mi4wNzcsMzYzLjg5MywzNjIuMDc3eiIgZmlsbD0iIzAwMDAwMCIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo="/></a>
                <?php endif; ?>
                <?php if ($params->get('show_colors', 1)) : ?>
                    <ul class="color-chips">
                        <?php
                        for ($i = 0; $i < count($pallete); $i++) {
                            echo '<li><a href="#" title="' . $pallete[$i] . '" class="color" style="background-color: ' . $pallete[$i] . '; display: block;">' . $pallete[$i] . '</a></li>';
                        }
                        ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif;
    }
}