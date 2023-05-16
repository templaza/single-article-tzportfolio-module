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

// Create shortcuts to some parameters.
$tmpl       = null;
if($item -> params -> get('show_related_article',1) && $item && $item -> related){
?>
<div class="tpp-item-related card rounded-0 mb-2">
    <?php if($params -> get('show_related_heading',1)){?>
        <?php
            if($item -> params -> get('related_heading')){
                $rlTitle  = $item -> params -> get('related_heading');
            }
            if(isset($rlTitle) && $rlTitle){
        ?>
        <h3 class="title card-header mt-0 mb-0"><?php echo $rlTitle;?></h3>
    <?php }
    } ?>
    <ul class="list-unstyled mt-3 ml-3 mr-3 mb-1">

    <?php foreach($item -> related as $i => $itemR){?>
    <li class="tpp-item-related__item<?php if($i == 0) echo ' first'; if($i == count($item -> related) - 1) echo ' last';?> mb-2">
        <?php
        if($itemR->event->onContentDisplayMediaType && !empty($itemR->event->onContentDisplayMediaType)) {
            echo $itemR->event->onContentDisplayMediaType;
        }

        if(!isset($itemR -> mediatypes) || (isset($itemR -> mediatypes) && !in_array($itemR -> type,$itemR -> mediatypes))){
            if($params -> get('show_related_title',1)){
        ?>
        <a href="<?php echo $itemR -> link;?>"
           class="TzTitle">
            <?php echo $itemR -> title;?>
        </a>
        <?php }
        }?>
    </li>

    <?php }?>
    </ul>
</div>
<?php }?>