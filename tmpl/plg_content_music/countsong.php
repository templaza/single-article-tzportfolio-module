<?php
/*------------------------------------------------------------------------

# Music Addon

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2016 tzportfolio.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Website: http://www.tzportfolio.com

# Technical Support:  Forum - http://tzportfolio.com/forum

# Family website: http://www.templaza.com

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

if(isset($item) && $item && $params -> get('music_show_countsong', 1)){
JLoader::import('content.music.libraries.music', COM_TZ_PORTFOLIO_PLUS_ADDON_PATH);

$num_song = TZMusic::getNumberSong($item->id);
?>
<div class="music-num-song">
    <?php
    echo ($num_song > 1) ? JText::sprintf('PLG_CONTENT_MUSIC_SONG_N', $num_song) : JText::sprintf('PLG_CONTENT_MUSIC_SONG_1', $num_song); ?>
</div>
<?php } ?>