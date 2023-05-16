<?php
/*------------------------------------------------------------------------

# Grid Gallery Addon

# ------------------------------------------------------------------------

# author    Sonny

# copyright Copyright (C) 2019 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.tzportfolio.com

# Technical Support:  Forum - https://www.tzportfolio.com/help/forum.html

-------------------------------------------------------------------------*/

// No direct access.
defined('_JEXEC') or die;

if ($params->get('mt_grid_gallery_show',1)) {
	if(isset($item) && $item) {
		if (isset($grid_gallery) && $grid_gallery) {
            if (isset($grid_gallery->data) && count($grid_gallery->data)) {

                $doc    = JFactory::getDocument();
                $doc -> addStyleSheet('components/com_tz_portfolio_plus/css/all.min.css');
                $doc -> addStyleSheet('components/com_tz_portfolio_plus/css/jquery.fancybox.min.css');
                $doc -> addScript('components/com_tz_portfolio_plus/js/jquery.fancybox.min.js');
                $doc -> addScript(TZ_Portfolio_PlusUri::base(true) . '/addons/mediatype/grid_gallery/js/lightbox.min.js');
                $doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true) . '/addons/mediatype/grid_gallery/css/style.css');
                $width          =   $params->get('mt_grid_gallery_width','400');
                $height         =   $params->get('mt_grid_gallery_height','250');
                $gallerytype    =   $params->get('mt_grid_gallery_type','masonry');
                if ($gallerytype == 'grid') {
                    $doc -> addStyleDeclaration('.tz_portfolio_plus_grid_gallery.grid-container{grid-template-columns: repeat(auto-fill, minmax('.$width.'px, 1fr));}.tz_portfolio_plus_grid_gallery.grid-container .gallery-listing{height:'.$height.'px;}');
                } elseif ($gallerytype == 'masonry') {
                    $doc->addScript('components/com_tz_portfolio_plus/js/tz_portfolio_plus.min.js');
                    $doc->addScript('components/com_tz_portfolio_plus/js/jquery.isotope.min.js');
                    $doc->addStyleSheet('components/com_tz_portfolio_plus/css/isotope.min.css');
                    $doc->addStyleSheet('components/com_tz_portfolio_plus/css/tzportfolioplus.min.css');
                    $doc->addScriptDeclaration('
							jQuery(function($){
							    $(document).ready(function(){
							        $(".tz_portfolio_plus_grid_gallery.masonry-container").tzPortfolioPlusIsotope({
							            "containerElementSelector"  : ".tz_portfolio_plus_grid_gallery.masonry-container",
							            "params"                    : {
							                "tz_column_width"       : "' . $width . '"
							            },
							            
										"isotope_options"                   : {
										            "core"  : {
										                sortBy : "original-order"
										            }
										}
							        });
							    });
							});
							');
                } elseif ($gallerytype == 'horizontal_masonry') {
                    $style  =   '.tz_portfolio_plus_grid_gallery.horizontal_masonry-container .gallery-listing{height:'.$height.'px;}';
                    for ($i = 0; $i<count($grid_gallery -> data); $i++) {
                        $style      .=   '.tz_portfolio_plus_grid_gallery.horizontal_masonry-container .gallery-listing:nth-child('.($i+1).') {width: '.(rand(150,500)).'px;}';
                    }
                    $doc -> addStyleDeclaration($style);
                }

                $lightboxopt    =   $params->get('grid_gallery_lightbox_option',['zoom', 'slideShow', 'fullScreen', 'thumbs', 'close']);
                if (is_array($lightboxopt)) {
                    for ($i = 0 ; $i< count($lightboxopt); $i++) {
                        $lightboxopt[$i]  =   '"'.$lightboxopt[$i].'"';
                    }
                }

                $lightboxopt=   is_array($lightboxopt) ? implode(',', $lightboxopt) : '';

                $doc -> addScriptDeclaration('var grid_gallery_lightbox_buttons = ['.$lightboxopt.'];');

                $gallerytype    =   $params->get('mt_grid_gallery_type','masonry');
	            echo '<div class="tz_portfolio_plus_grid_gallery '.$gallerytype.'-container">';
                for ($i = 0; $i<count($grid_gallery -> data); $i++) {
                    $image      =   $grid_gallery->data[$i];
	                jimport('joomla.filesystem.file');
	                $image_size =   $params->get('mt_grid_gallery_size','o');
	                if ($image_size != 'o') {
		                $thumb  =   'images/tz_portfolio_plus/grid_gallery/'.$item->id.'/resize/'
			                . JFile::stripExt($image)
			                . '_' . $image_size . '.' . JFile::getExt($image);
	                } else {
		                $thumb  =   'images/tz_portfolio_plus/grid_gallery/'.$item -> id.'/'.$image;
	                }

	                ?>
                    <div class="gallery-listing element" data-date data-hits data-title>
                        <div class="gallery-inner">
                            <div class="gallery-image">
                                <a class="gallery-title" data-thumb="<?php echo JUri::root().$thumb; ?>" data-id="grid<?php echo $i; ?>" href="<?php echo JUri::root().'images/tz_portfolio_plus/grid_gallery/'.$item -> id.'/'.$image; ?>"><i class="tps tp-search"></i></a>
                                <img src="<?php echo JUri::root().$thumb; ?>" />
                            </div>
                        </div>
                    </div>
	                <?php
                }
                echo '</div>';
            }
		}
	}
}
