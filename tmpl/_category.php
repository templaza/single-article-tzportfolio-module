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

$doc    = JFactory::getDocument();

if($item && $item -> params -> get('show_category_main', 1) || $item -> params -> get('show_category_sec', 1)){ ?>
    <div class="tpp-module-category">
        <span class="tp tp-folder-open"></span>
        <?php if($item -> params -> get('show_category_main', 1) && isset($item -> category_link) && $item -> category_link){ ?>
            <a href="<?php echo $item -> category_link; ?>"><?php echo $item -> category_title;
            ?></a><?php
        }
        if($item -> params -> get('show_category_sec', 1) && $item -> second_categories
            && count($item -> second_categories)){
            foreach($item -> second_categories as $secCategory){
                ?><span class="tpp-module__carousel-separator">,</span>
                <a href="<?php echo $secCategory -> link; ?>"><?php echo $secCategory -> title; ?></a>
            <?php }
        } ?>
    </div>
<?php } ?>