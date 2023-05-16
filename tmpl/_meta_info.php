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

if($item){
    if((isset($item->event->beforeDisplayAdditionInfo) && !empty($item->event->beforeDisplayAdditionInfo))
        || $item -> params -> get('show_category_main', 1)
        || ($item -> params -> get('show_category_sec', 1)  && $item -> second_categories
            && count($item -> second_categories)) || $item -> params -> get('show_created_date', 1)
        ||$item -> params -> get('show_modified_date', 1)
        || $item -> params -> get('show_publish_date', 1)
        || $item -> params -> get('show_author', 1)
        || $item -> params -> get('show_hit',1)
        || (isset($item->event->afterDisplayAdditionInfo) && !empty($item->event->afterDisplayAdditionInfo))){
?>
<div class="tpp-module-meta muted text-muted">
    <?php
    if (isset($item->event->beforeDisplayAdditionInfo)) {
        echo $item->event->beforeDisplayAdditionInfo;
    }
    ?>

    <?php if($item -> params -> get('show_category_main', 1) || $item -> params -> get('show_category_sec', 1)){ ?>
        <div class="tpp-module-category">
            <span class="tp tp-folder-open"></span>
            <?php if($item -> params -> get('show_category_main', 1)){ ?>
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
    <?php if($item -> params -> get('show_created_date', 1)){ ?>
        <div class="tpp-module-date">
            <span class="tpr tp-clock"></span>
            <?php echo JHtml::_('date', $item -> created, JText::_('DATE_FORMAT_LC'));?>
        </div>
    <?php } ?>
    <?php if($item -> params -> get('show_modified_date', 1)){ ?>
        <div class="tpp-module-date">
            <span class="tpr tp-edit"></span>
            <?php echo JHtml::_('date', $item -> modified, JText::_('DATE_FORMAT_LC'));?>
        </div>
    <?php } ?>
    <?php if($item -> params -> get('show_publish_date', 1)){ ?>
        <div class="tpp-module-date">
            <span class="tpr tp-clock"></span>
            <?php echo JHtml::_('date', $item -> publish_up, JText::_('DATE_FORMAT_LC'));?>
        </div>
    <?php } ?>
    <?php if($item -> params -> get('show_author', 1)){ ?>
        <div class="tpp-module-date">
            <span class="tpr tp-user"></span>
            <a href="<?php echo $item -> authorLink;?>"><?php echo $item -> author;?></a>
        </div>
    <?php } ?>
    <?php if($item -> params -> get('show_hit',1)){ ?>
        <div class="tpp-module-hit">
            <span class="tpr tp-eye"></span>
            <?php echo $item->hits;?>
        </div>
    <?php }?>

    <?php
    if(isset($item -> event -> afterDisplayAdditionInfo)){
        echo $item -> event -> afterDisplayAdditionInfo;
    }
    ?>
</div>
<?php }
} ?>