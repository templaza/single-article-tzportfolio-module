<?php
/*------------------------------------------------------------------------

# Flipbook Gallery Addon

# ------------------------------------------------------------------------

# author    Sonny

# copyright Copyright (C) 2019 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.tzportfolio.com

# Technical Support:  Forum - https://www.tzportfolio.com/help/forum.html

-------------------------------------------------------------------------*/

// No direct access.
defined('_JEXEC') or die;

if(isset($item) && $item && isset($flipbook_gallery) && $flipbook_gallery) {
    if ($item && $flipbook_gallery && isset($flipbook_gallery->data) && count($flipbook_gallery->data)):

        if ($params->get('mt_flipbook_gallery_related_show_image', 1)):
            if ($flipbook_gallery->featured) {
                $image = $flipbook_gallery->featured;
            } else {
                $image = $flipbook_gallery->data[0];
            }
            $image_size = $params->get('mt_flipbook_gallery_related_size', 'o');
            jimport('joomla.filesystem.file');
            if ($image_size != 'o') {
                $image = 'images/tz_portfolio_plus/flipbook_gallery/' . $item->id . '/resize/'
                    . JFile::stripExt($image)
                    . '_' . $image_size . '.' . JFile::getExt($image);
            } else {
                $image = 'images/tz_portfolio_plus/flipbook_gallery/' . $item->id . '/' . $image;
            }
            ?>
            <a href="<?php echo $item->link; ?>">
                <img src="<?php echo JUri::root().$image; ?>"
                     alt="<?php echo $item->title; ?>"
                     title="<?php echo $item->title; ?>"
                     itemprop="thumbnailUrl"/>
            </a>
        <?php
        endif;
    endif;
}