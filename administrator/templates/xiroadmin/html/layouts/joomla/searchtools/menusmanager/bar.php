<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

 use Joomla\CMS\Factory;
defined('_JEXEC') or die;

/** @var  array  $displayData */
$data = $displayData;


if ($data['view'] instanceof MenusViewItems)
{
	// We will get the menutype filter & remove it from the form filters
	$menuTypeField = $data['view']->filterForm->getField('menutype');

	// Add the client selector before the form filters.
	$clientIdField = $data['view']->filterForm->getField('client_id');

	if ($clientIdField && (empty(Factory::getApplication()->input->getString('menutype', '')))) : ?>
	<div class="js-stools-field-filter js-stools-client_id">
		<?php echo $clientIdField->input; ?>
	</div>
	<?php endif; ?>

	<?php if (empty(Factory::getApplication()->input->getString('menutype', ''))) : ?>
	<div class="js-stools-field-filter js-stools-menutype">
		<?php echo $menuTypeField->input; ?>
	</div>
	<?php endif; ?>

	<?php
}
elseif ($data['view'] instanceof MenusViewMenus)
{
	// Add the client selector before the form filters.
	$clientIdField = $data['view']->filterForm->getField('client_id');
	?>
	<div class="js-stools-field-filter js-stools-client_id">
		<?php echo $clientIdField->input; ?>
	</div>
	<?php
}

// Display the main joomla layout
echo JLayoutHelper::render('joomla.searchtools.default.bar', $data, null, array('component' => 'none'));
