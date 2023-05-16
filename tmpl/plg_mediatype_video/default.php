<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2015 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access.
defined('_JEXEC') or die;

if(isset($item) && $item) {
    if (isset($video) && $video && $params -> get('mt_video_show_video', 1)) {
        $doc    = JFactory::getDocument();
?>
<div class="tz_portfolio_plus_video">
    <?php
    if($video -> type == 'embed'){
        echo $video -> embed_code;
    }else{

        $video_url      = $video -> url;
        $video_width    = $params -> get('mt_video_width');
        $video_height   = $params -> get('mt_video_height');

        $video_url      = str_replace('&amp;', '&', $video_url);

        if(strpos($video_url, 'https:') === false){
            $video_url  = preg_replace('/^http:/', 'https:', $video_url);
        }
        // Replace & to ? if ? not have
        if(strpos($video_url, '?') === false && strpos($video_url, '&') !== false){
            $video_url  = preg_replace('/&/', '?', $video_url, 1);
        }

        if(!$video_width){
            $video_width    = 600;
        }
        if(!$video_height){
            if($video -> type == 'youtube') {
                $video_height   = 315;
            }
            if($video -> type == 'vimeo') {
                $video_height   = 255;
            }
        }

        if($params -> get('mt_video_enable_fluidvid',1)) {
            $doc->addScript(TZ_Portfolio_PlusUri::base(true) . '/addons/mediatype/video/js/fluidvids.min.js');
            $doc->addScriptDeclaration('
                (function($){
                    $(document).ready(function(){
                        fluidvids.init({
                            selector: [\'.tz_portfolio_plus_video iframe\'],
                            players: [\'www.youtube.com\', \'player.vimeo.com\']
                        });
                    });
                })(jQuery);');
        }
    ?>

        <iframe src="<?php echo $video_url;?>"
                width="<?php echo $video_width;?>"
                height="<?php echo $video_height;?>"
                frameborder="0" allowFullScreen itemprop="embedUrl">
        </iframe>
    <?php }
    ?>
</div>
<?php
    }
}