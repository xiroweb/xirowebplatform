<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_modules
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$data = $displayData['data']['view'];
$position = $displayData['selectposition'];
JLoader::register('TemplatesHelper', JPATH_ADMINISTRATOR . '/components/com_templates/helpers/templates.php');

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$clientId       = $data->clientId;
$state          = 1;
// $selectedPosition = $data->position;
$selectedPosition = $position;
$positionpre = JHtml::_('modules.positions', $clientId, $state, $selectedPosition);
$positions = array();

$app = JFactory::getApplication();
$roottemplate = $app->input->get('roottemplate', '', 'STRING');
if ($roottemplate) {
	$positions[''] =  $positionpre[''];
	$positions[$roottemplate] = $positionpre[$roottemplate];
} else {
	$positions = $positionpre;
}

$customGroupText = JText::_('COM_MODULES_CUSTOM_POSITION');


$attr = array(
	'id'          => 'filter_position',
    'list.select' => $selectedPosition,
    'list.attr'   => 'class="chzn-custom-value" '
    . 'onchange="this.form.submit();" '
	. 'data-custom_group_text="' . $customGroupText . '" '
	. 'data-no_results_text="' . JText::_('COM_MODULES_ADD_CUSTOM_POSITION') . '" '
	. 'data-placeholder="' . JText::_('COM_MODULES_TYPE_OR_SELECT_POSITION') . '" '
);

echo JHtml::_('select.groupedlist', $positions, 'filter[position]', $attr);
