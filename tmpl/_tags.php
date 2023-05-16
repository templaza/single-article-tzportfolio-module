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

if($item -> params -> get('show_tag', 1) && $item -> tags){
?>
    <div class="tpp-module-tag">
        <span class="tps tp-tags"></span>
        <?php foreach($item -> tags as $tag){ ?>
            <a class="badge badge-secondary" href="<?php echo $tag -> link; ?>"<?php
            if(isset($tmpl) AND !empty($tmpl)): echo ' target="_blank"'; endif;?>><?php
                echo $tag -> title;?></a>
        <?php } ?>
    </div>
<?php } ?>