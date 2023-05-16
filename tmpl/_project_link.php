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

if($item){
    $itemParam  = new Registry($item -> attribs);
    if (trim($itemParam ->get('project_link'))) :
        ?>
        <div class="tpPortfolioLink"><a href="<?php echo $itemParam ->get('project_link'); ?>" title="<?php
            echo $itemParam ->get('project_link_title');
            ?>" target="_blank" itemprop="url" class="btn btn-default btn-outline-secondary btn-block btn-large btn-lg"><?php
                echo $itemParam ->get('project_link_title'); ?></a></div>
    <?php endif; ?>
<?php } ?>
