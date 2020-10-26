<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$form = $displayData->getForm();

$title = $form->getField('title') ? 'title' : ($form->getField('name') ? 'name' : '');

?>
<div class="form-inline form-inline-header-a">
	<?php
	echo $title ? $form->renderField($title) : '';
	?>
</div>
<div class="form-inline-bottom">
	<?php
	echo $form->renderField('alias');
	?>
</div>
