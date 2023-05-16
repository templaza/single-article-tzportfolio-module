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

if(modTZ_Portfolio_PlusSingle_ArticleHelper::addonMethodIsAllowed('onAfterDisplayAdditionInfo') && isset($item) && $item):
    if($params -> get('show_comment_count', 1) && isset($item -> commentCount)):
?>
<div class="TzPortfolioCommentCount muted" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
    <i class="tpr tp-comments"></i>
    <span itemprop="commentCount"><?php echo $item -> commentCount;?></span>
</div>
<?php endif;
endif;
