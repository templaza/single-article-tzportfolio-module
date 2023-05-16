<?php
/**
 * Created by PhpStorm.
 * User: thuongnv
 * Date: 3/10/2016
 * Time: 12:02 PM
 */
// No direct access.
defined('_JEXEC') or die;

if(isset($item) && $item) {

    JLoader::import('com_tz_portfolio_plus.addons.content.charity.models.article', JPATH_SITE . '/components');
    if($__model = JModelLegacy::getInstance('Article', 'PlgTZ_Portfolio_PlusContentCharityModel',
        array('ignore_request' => true))) {
        $__model->set('article', $item);
        $__model->set('addon', $this);
        $__model->set('trigger_params', $params);

        $formPaypal = $__model->getNewDonate();
    }
    if (isset($formPaypal) && !empty($formPaypal)):
        echo $formPaypal;
        ?>
    <?php
    endif;
}
?>