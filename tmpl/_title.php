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

if($item) {
    if ($item->params->get('show_title', 1)) { ?>
        <h2 class="tpp-item-title">
            <?php echo $item->title; ?>
        </h2>
    <?php }

    //Call event onContentAfterTitle on plugin
    echo $item->event->afterDisplayTitle;
}
?>