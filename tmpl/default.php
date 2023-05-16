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

if($item){
?>

<div id="module__<?php echo $module -> id;?>" class="tpp-module__single-article<?php echo $moduleclass_sfx;?>">
    <?php if($layoutHtml){
        echo $layoutHtml;
    }else{ ?>
        <?php
        // Display html of title
        require TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_title'); ?>

        <?php
        $__catPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_category');
        $__createPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_created_date');
        $__modifiedPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_modified_date');
        $__publishedPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_published_date');
        $__hitPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_hits');

        if(($__catPath && strrpos($__catPath, '_category.php') !== false) ||
            ($__createPath && strrpos($__createPath, '_created_date.php') !== false) ||
            ($__modifiedPath && strrpos($__modifiedPath, '_modified_date.php') !== false) ||
            ($__publishedPath && strrpos($__publishedPath, '_published_date.php') !== false) ||
            ($__hitPath && strrpos($__hitPath, '_hits.php') !== false) ||
            (isset($item->event->beforeDisplayAdditionInfo) && !empty($item->event->beforeDisplayAdditionInfo)) ||
            (isset($item->event->afterDisplayAdditionInfo) && !empty($item->event->afterDisplayAdditionInfo)) ){ ?>
        <div class="tpp-module-meta muted text-muted">
            <?php
            if (isset($item->event->beforeDisplayAdditionInfo)) {
                echo $item->event->beforeDisplayAdditionInfo;
            }
            ?>
            <?php
            // Display html of category
            require $__catPath; ?>
            <?php
            // Display html of created date
            require $__createPath; ?>
            <?php
            // Display html of created date
            require $__modifiedPath; ?>
            <?php
            // Display html of created date
            require $__publishedPath; ?>
            <?php
            // Display html of created date
            require $__hitPath; ?>

            <?php
            if(isset($item -> event -> afterDisplayAdditionInfo)){
                echo $item -> event -> afterDisplayAdditionInfo;
            }
            ?>
        </div>
        <?php } ?>

        <?php
        // Display html of media
        $__mediaPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_media');
        if($__mediaPath && strrpos($__mediaPath, '_media.php') !== false){
            require $__mediaPath;
        } ?>

        <?php
        // Display html of introtext
        $__introtextPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_introtext');
        if($__introtextPath && strrpos($__introtextPath, '_introtext.php') !== false){
            require $__introtextPath;
        } ?>

        <?php
        // Display html of fulltext
        $__fulltextPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_fulltext');
        if($__fulltextPath && strrpos($__fulltextPath, '_fulltext.php') !== false){
            require $__fulltextPath;
        } ?>

        <?php
        // Display html of tags
        $__tagsPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_tags');
        if($__tagsPath && strrpos($__tagsPath, '_tags.php') !== false){
            require $__tagsPath;
        } ?>

        <?php
        // Display html of about author
        $__author_aboutPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_author_about');
        if($__author_aboutPath && strrpos($__author_aboutPath, '_author_about.php') !== false){
            require $__author_aboutPath;
        } ?>

        <?php
        // Display html of related article
        $__relatedPath = TZ_Portfolio_PlusModuleHelper::getTZLayoutPath($module, '_related');
        if($__relatedPath && strrpos($__relatedPath, '_related.php') !== false){
            require $__relatedPath;
        } ?>

        <?php
        //Call event onContentAfterDisplayArticleView on plugin
        echo $item->event->contentDisplayArticleView;
        ?>
    <?php } ?>

    <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
    <?php echo $item->event->afterDisplayContent; ?>
</div>
<?php } ?>