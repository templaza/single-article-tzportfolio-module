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

if($item && $item -> params -> get('show_created_date', 1)){ ?>
    <div class="tpp-module-date">
        <span class="tpr tp-clock"></span>
        <?php echo JHtml::_('date', $item -> created, JText::_('DATE_FORMAT_LC'));?>
    </div>
<?php } ?>