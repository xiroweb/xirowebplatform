<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_modules
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$clientId   = (int) $this->state->get('client_id', 0);
$user		= JFactory::getUser();
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$saveOrder	= ($listOrder == 'a.ordering');
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_modules&task=modules.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'moduleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$colSpan = $clientId === 1 ? 8 : 10;

$app =  JFactory::getApplication();
$input = $app->input;
$tmpl = $input->get('tmpl', '', 'string');

$templateStyle = $input->getInt('templateStyle',0);
$roottemplate = $input->get('roottemplate', '', 'STRING');

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
<form action="<?php echo JRoute::_('index.php?option=com_modules'. ($tmpl ? '&tmpl=' . $tmpl : ''). ($roottemplate ? '&roottemplate=' . $roottemplate : '')); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2 <?php echo $clientId ? 'supperadmin' : '' ?>">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10 <?php echo $clientId ? 'supperadmin' : '' ?>">
<?php else : ?>
	<div id="j-main-container" class="<?php echo $clientId ? 'supperadmin' : '' ?>">
<?php endif;?>
		<?php if ($clientId) : ?>
			<div class="alert alert-error">
				<h4><?php echo JText::_('TPL_XIROADMIN_COM_TEMPLATES_SUPPERADMIN_CLIENT_TITLE'); ?></h4>
				<?php echo JText::_('TPL_XIROADMIN_COM_TEMPLATES_SUPPERADMIN_CLIENT_DESC'); ?>
				</div>
		<?php endif; ?>
		<?php echo JLayoutHelper::render('joomla.searchtools.modulesmanager', array('view' => $this)); ?>
		<?php if ($this->total > 0) : ?>
				<?php if (!$tmpl) : ?>
					<ul class="toolbar-action-list">
						<li class="nowrapl btn">
							<?php echo JText::_('TPL_XIROADMIN_COM_MODULES_SELECT_ALL'); ?> <?php echo JHtml::_('grid.checkall'); ?> 
						</li>
						
					</ul>
				<?php endif; ?>
			<table class="table" id="moduleList">
				<thead>

				</thead>
				<tfoot>
					<tr>
						<td colspan="<?php echo $colSpan; ?>">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate  = $user->authorise('core.create',     'com_modules');
					$canEdit	= $user->authorise('core.edit',		  'com_modules.module.' . $item->id);
					$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $user->get('id')|| $item->checked_out == 0;
					$canChange  = $user->authorise('core.edit.state', 'com_modules.module.' . $item->id) && $canCheckin;
				?>
					<tr class="row<?php echo $i % 2; ?> published-<?php echo $item->published; ?>" sortable-group-id="<?php echo $item->position ?: 'none'; ?>">
						<td class="order nowrap center ">
							<?php
							$iconClass = '';
							if (!$canChange)
							{
								$iconClass = ' inactive';
							}
							elseif (!$saveOrder)
							{
								$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::_('tooltipText', 'JORDERINGDISABLED');
							}
							?>
							<span class="sortable-handler<?php echo $iconClass; ?>">
								<span class="icon-menu"></span>
							</span>
							<?php if ($canChange && $saveOrder) : ?>
								<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order" />
							<?php endif; ?>
						</td>
						

						<td class="title-type-module ">
							<?php echo $item->name; ?>: 
						
							
								<?php if ($item->checked_out) : ?>
									<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'modules.', $canCheckin); ?>
								<?php endif; ?>
								<?php if ($canEdit) : ?>
									<a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_modules&task=module.edit&id=' . (int) $item->id. ($tmpl ? '&tmpl=' . $tmpl : '')); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
										<?php echo $this->escape($item->title); ?></a>
								<?php else : ?>
									<?php echo $this->escape($item->title); ?>
								<?php endif; ?>

								<?php if (!empty($item->note)) : ?>
									<div class="small">
										<?php echo JText::sprintf('JGLOBAL_LIST_NOTE', $this->escape($item->note)); ?>
									</div>
								<?php endif; ?>
							
						</td>

						<td class="small ">
							<?php if ($item->position) : ?>
								<span class="label label-info">
									<?php echo $item->position; ?>
								</span>
							<?php else : ?>
								<span class="label">
									<?php echo JText::_('JNONE'); ?>
								</span>
							<?php endif; ?>
						</td>

						<td class="modules-list-info">

							<div class="grid_id">
								<?php if ($item->enabled > 0) : ?>
									<?php echo JHtml::_('grid.id', $i, $item->id); ?>
								<?php endif; ?>
							</div>

							<?php if ($clientId === 0) : ?>
							<div class="small ">
								<i class="menu-menus fa fa-sitemap"></i>
								<?php echo $item->pages; ?>
							</div>
							<?php endif; ?>
							<div class="small ">
								<i class="menu-levels fa fa-user-secret"></i>
								<?php echo $this->escape($item->access_level); ?>
							</div>
							<?php if ($clientId === 0) : ?>
							<div class="small ">
								<i class="menu-language fa fa-language"></i>
								<?php echo JLayoutHelper::render('joomla.content.language', $item); ?>
							</div>
							<?php elseif ($clientId === 1 && JModuleHelper::isAdminMultilang()) : ?>
								<div class="small ">
									<i class="menu-language fa fa-language"></i>
									<?php if ($item->language == ''):?>
										<?php echo JText::_('JUNDEFINED'); ?>
									<?php elseif ($item->language == '*'):?>
										<?php echo JText::alt('JALL', 'language'); ?>
									<?php else:?>
										<?php echo $this->escape($item->language); ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<div class="">
								ID: <?php echo (int) $item->id; ?>
							</div>
							<div class="pull-right">
								<div class="btn-group">
								<?php // Check if extension is enabled ?>
								<?php if ($item->enabled > 0) : ?>
									<?php echo JHtml::_('jgrid.published', $item->published, $i, 'modules.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
									<?php // Create dropdown items and render the dropdown list.
									if ($canCreate)
									{
										JHtml::_('actionsdropdown.duplicate', 'cb' . $i, 'modules');
									}
									if ($canChange)
									{
										JHtml::_('actionsdropdown.' . ((int) $item->published === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'modules');
									}
									if ($canCreate || $canChange)
									{
										echo JHtml::_('actionsdropdown.render', $this->escape($item->title));
									}
									?>
								<?php else : ?>
									<?php // Extension is not enabled, show a message that indicates this. ?>
									<button class="btn btn-micro hasTooltip" title="<?php echo JText::_('COM_MODULES_MSG_MANAGE_EXTENSION_DISABLED'); ?>">
										<span class="icon-ban-circle" aria-hidden="true"></span>
									</button>
								<?php endif; ?>
								</div>
							</div>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>

		<?php // Load the batch processing form. ?>
		<?php if ($user->authorise('core.create', 'com_modules')
			&& $user->authorise('core.edit', 'com_modules')
			&& $user->authorise('core.edit.state', 'com_modules')) : ?>
			<?php echo JHtml::_(
				'bootstrap.renderModal',
				'collapseModal',
				array(
					'title'  => JText::_('COM_MODULES_BATCH_OPTIONS'),
					'footer' => $this->loadTemplate('batch_footer'),
				),
				$this->loadTemplate('batch_body')
			); ?>
		<?php endif; ?>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
