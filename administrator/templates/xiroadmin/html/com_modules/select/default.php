<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_modules
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.popover');
$document = JFactory::getDocument();

$app = JFactory::getApplication();

$tmpl = $app->input->get('tmpl', '', 'string');

$templateStyle = $app->input->getInt('templateStyle',0);
$roottemplate = $app->input->get('roottemplate', '', 'STRING');
// send to plugin module admin
if ($templateStyle) {
	$app->setUserState('com_modules.module.templatestyle', $templateStyle);
} else {
	$app->setUserState('com_modules.module.templatestyle', 0);
}
// send to form edit
if ($roottemplate) {
	$app->setUserState('com_modules.module.roottemplate', $roottemplate);
} else {
	$app->setUserState('com_modules.module.roottemplate', 0);
}

?>

<h2><?php echo JText::_('COM_MODULES_TYPE_CHOOSE'); ?></h2>
<ul id="new-modules-list" class="">
<?php foreach ($this->items as &$item) : ?>
	<?php // Prepare variables for the link. ?>
	<?php $link       = 'index.php?option=com_modules&task=module.add&eid=' . $item->extension_id; ?>
	<?php
		if ($tmpl) {
			$link       .= '&tmpl=' . $tmpl;
		}
	 ?>
	<?php $name       = $this->escape($item->name); ?>
	<?php $desc       = JHtml::_('string.truncate', $this->escape(strip_tags($item->desc)), 200); ?>
	<?php $short_desc = JHtml::_('string.truncate', $this->escape(strip_tags($item->desc)), 90); ?>
	<li>
		<div class="module-select-box">
			<a  href="<?php echo JRoute::_($link); ?>" class="btn btn-primary pull-right"><i class="fa fa-fw fa-plus-square"></i></a>
			<a href="<?php echo JRoute::_($link); ?>">
				<strong><?php echo $name; ?></strong></a>
			<small class="hasPopover" data-placement="bottom" title="<?php echo $name; ?>" data-content="<?php echo $desc; ?>"><?php echo $short_desc; ?></small>

		</div>
	</li>
<?php endforeach; ?>
</ul>
<div class="clr"></div>
