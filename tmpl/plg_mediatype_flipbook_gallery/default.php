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

if ($params->get('mt_flipbook_gallery_show',1)) {
    if(isset($item) && $item) {
        if (isset($flipbook_gallery) && $flipbook_gallery) {
            if (isset($flipbook_gallery->data) && count($flipbook_gallery->data)) {
                $doc            =   JFactory::getDocument();
                $gallerytype    =   $params->get('mt_flipbook_gallery_type','masonry');

                $doc -> addStyleSheet(JUri::root(true).'/components/com_tz_portfolio_plus/css/all.min.css');
                $doc -> addStyleSheet(JUri::root(true).'/components/com_tz_portfolio_plus/css/jquery.fancybox.min.css');
                $doc -> addScript(JUri::root(true).'/components/com_tz_portfolio_plus/js/jquery.fancybox.min.js');
                $doc -> addScript(TZ_Portfolio_PlusUri::base(true) . '/addons/mediatype/flipbook_gallery/js/jquery-ui-1.10.4.min.js');
                $doc -> addScript(TZ_Portfolio_PlusUri::base(true) . '/addons/mediatype/flipbook_gallery/js/jquery.easing.1.3.js');
                $doc -> addScript(TZ_Portfolio_PlusUri::base(true) . '/addons/mediatype/flipbook_gallery/js/jquery.booklet.latest.min.js');
                $doc -> addScript(TZ_Portfolio_PlusUri::base(true) . '/addons/mediatype/flipbook_gallery/js/lightbox.min.js');
                $doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true) . '/addons/mediatype/flipbook_gallery/css/style.css');

                $option         =   array();
                $option[]       =   "hashTitleText: '".JText::_('PLG_MEDIATYPE_FLIPBOOK_GALLERY_PAGE')."'";
                $option[]       =   "autoCenter: true";
                $width          =   $params->get('mt_flipbook_gallery_width','100%');
                $height         =   $params->get('mt_flipbook_gallery_height','');
                $ratio          =   $params->get('mt_flipbook_gallery_ratio','5:3');
                $direction      =   $params->get('mt_flipbook_gallery_direction','LTR');
                $paddingPage    =   $params->get('mt_flipbook_gallery_padding','2vw');
                $arrows         =   $params->get('mt_flipbook_gallery_show_arrow',1);
                $pageSelector   =   $params->get('mt_flipbook_gallery_show_page_selector',1);
                if ($width) $option[]       =   "width: '$width'";
                if ($height) $option[]      =   "height: '$height'";
                if ($ratio) {
                    list($rwidth,$rheight)  =   explode(':', $ratio);
                    $option[]   =   "rwidth: $rwidth";
                    $option[]   =   "rheight: $rheight";
                }
                if ($direction) $option[]   =   "direction: '$direction'";
                if ($paddingPage) $option[] =   "pagePadding: '$paddingPage'";
                if ($arrows) $option[]      =   "arrows: true";
                if ($pageSelector) {
                    $option[]               =   "menu: '#flipbook-gallery-menu'";
                    $option[]               =   "pageSelector: true";
                }

                $doc -> addScriptDeclaration("
	                    jQuery(function($) {
	                        $(document).ready(function () {
	                            $('.tz_portfolio_plus_flipbook_gallery').booklet({
	                                ".implode(',', $option)."
	                            });
	                        });
	                    });
	                    ");
                $lightboxopt    =   $params->get('flipbook_gallery_lightbox_option',['zoom', 'slideShow', 'fullScreen', 'thumbs', 'close']);
                if (is_array($lightboxopt)) {
                    for ($i = 0 ; $i< count($lightboxopt); $i++) {
                        $lightboxopt[$i]  =   '"'.$lightboxopt[$i].'"';
                    }
                }

                $lightboxopt=   is_array($lightboxopt) ? implode(',', $lightboxopt) : '';

                $doc -> addScriptDeclaration('var flipbook_gallery_lightbox_buttons = ['.$lightboxopt.'];');

                if ($params->get('mt_flipbook_gallery_show_page_selector',1)) {
                    echo '<div id="flipbook-gallery-menu"></div>';
                }

                echo '<div class="tz_portfolio_plus_flipbook_gallery">';
                if ($params->get('mt_flipbook_gallery_show_cover_page', 1)) :
                    ?>
                    <div class="gallery-listing"title="<?php echo $item -> title; ?>">
                        <div class="gallery-start">
                            <h2><?php echo $item -> title; ?></h2>
                        </div>
                    </div>
                <?php
                endif;
                for ($i = 0; $i<count($flipbook_gallery -> data); $i++) {
                    $image      =   $flipbook_gallery->data[$i];
                    jimport('joomla.filesystem.file');
                    $image_size =   $params->get('mt_flipbook_gallery_size','o');
                    if ($image_size != 'o') {
                        $thumb  =   'images/tz_portfolio_plus/flipbook_gallery/'.$item->id.'/resize/'
                            . JFile::stripExt($image)
                            . '_' . $image_size . '.' . JFile::getExt($image);
                    } else {
                        $thumb  =   'images/tz_portfolio_plus/flipbook_gallery/'.$item -> id.'/'.$image;
                    }

                    ?>
                    <div class="gallery-listing"<?php if ($flipbook_gallery->title[$i]) echo ' title="'.$flipbook_gallery->title[$i].'"'; ?>>
                        <div class="gallery-image">
                            <a class="gallery-zoom" data-thumb="<?php echo JUri::root().$thumb; ?>" data-id="grid<?php
                            echo $i; ?>" href="<?php echo JUri::root().'images/tz_portfolio_plus/flipbook_gallery/'
                                .$item -> id.'/'.$image; ?>"><i class="tps tp-search"></i></a>
                            <img src="<?php echo JUri::root().$thumb; ?>" />
                        </div>
                    </div>
                    <?php
                }
                echo '</div>';
            }
        }
    }
}
