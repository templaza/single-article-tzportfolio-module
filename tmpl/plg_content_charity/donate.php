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

if(isset($item) && $item) {

    JLoader::import('com_tz_portfolio_plus.addons.content.charity.models.article', JPATH_SITE . '/components');
    if($__model = JModelLegacy::getInstance('Article', 'PlgTZ_Portfolio_PlusContentCharityModel',
        array('ignore_request' => true))) {
        $__model->set('article', $item);
        $__model->set('addon', $this);
        $__model->set('trigger_params', $params);

        $form = $__model->getFormDonate();
    }

    if (isset($form) && $form) {
        $doc = JFactory::getDocument();
        $doc->addStyleSheet(TZ_Portfolio_PlusUri::root(true) . '/addons/content/charity/css/charity.css');
        ?>
        <form action="<?php echo $item->link; ?>"
              method="post"
              class="form-validate form-charity">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-4 control-label"><?php echo $form->getLabel('firstname', 'value'); ?></div>
                    <div class="col-sm-8 controls"><?php echo $form->getInput('firstname', 'value'); ?></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 control-label"><?php echo $form->getLabel('lastname', 'value'); ?></div>
                    <div class="col-sm-8 controls"><?php echo $form->getInput('lastname', 'value'); ?></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 control-label"><?php echo $form->getLabel('email', 'value'); ?></div>
                    <div class="col-sm-8 controls"><?php echo $form->getInput('email', 'value'); ?></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 control-label"><?php echo $form->getLabel('address', 'value'); ?></div>
                    <div class="col-sm-8 controls"><?php echo $form->getInput('address', 'value'); ?></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 control-label"><?php echo $form->getLabel('comment', 'value'); ?></div>
                    <div class="col-sm-8 controls"><?php echo $form->getInput('comment', 'value'); ?></div>
                </div>
                <div class="center">
                    <button class="btn btn-primary radius-small" name="ok" type="submit">DONATE VIA</button>
                </div>
            </div>
            <input type="hidden" name="option" value="com_tz_portfolio_plus"/>
            <input type="hidden" name="view" value="article"/>
            <input type="hidden" name="id" value="<?php echo $item->id; ?>"/>
            <input type="hidden" name="return" value="<?php echo base64_encode($item->link); ?>"/>
            <input type="hidden" name="addon_view" value="donate"/>
            <input type="hidden" name="addon_task" value="donate.process_donation"/>
            <?php if ($addon = TZ_Portfolio_PlusPluginHelper::getPlugin($this -> _type, $this -> _name)) { ?>
                <input type="hidden" name="addon_id" value="<?php echo $addon->id; ?>"/>
            <?php } ?>
            <?php echo JHtml::_('form.token'); ?>
        </form>
        <?php
    }
}