<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');


JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user      = JFactory::getUser();
$clientId = (int) $this->state->get('client_id', 0);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$colSpan = $clientId === 1 ? 5 : 6;

// reset when return from edit
$app = JFactory::getApplication('administrator');
$app->setUserState('com_modules.modules.client_id', '0');

?>

<div class="bs4row">
	<div class="bs4col-12 text-right">
		<a href="https://www.xiroweb.com/template" target="_blank" class="btn btn-warning"><i class="fa fa-fw fa-cloud-download"></i> <?php echo JText::_('TPL_XIROADMIN_COM_TEMPLATES_TEMPLATE_MORE_LINK'); ?></a>
		
	</div>
</div>

<form action="<?php echo JRoute::_('index.php?option=com_templates&view=styles'); ?>" method="post" name="adminForm" id="adminForm">






	<div id="j-main-container" class="span12 <?php echo $clientId ? 'supperadmin' : '' ?>">

		<?php if ($clientId) : ?>
			<div class="alert alert-error">
				<h4><?php echo JText::_('TPL_XIROADMIN_COM_TEMPLATES_SUPPERADMIN_CLIENT_TITLE'); ?></h4>
				<?php echo JText::_('TPL_XIROADMIN_COM_TEMPLATES_SUPPERADMIN_CLIENT_DESC'); ?>
			</div>
		<?php endif; ?>
		<?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('selectorFieldName' => 'client_id'))); ?>
		<?php if ($this->total > 0) : ?>
			<div class="templates-list">
				<div class="bs4row">
				<tbody>
					<?php foreach ($this->items as $i => $item) :
						$canCreate = $user->authorise('core.create',     'com_templates');
						$canEdit   = $user->authorise('core.edit',       'com_templates');
						$canChange = $user->authorise('core.edit.state', 'com_templates');
					?>
					<div class="bs4col-6 bs4col-md-4">
						
						<div class="card card-xiro">
								<div class="hidden"><?php echo JHtml::_('grid.id', $i, $item->id); ?></div>
									<?php // echo JHtml::_('templates.thumb', $item->template, $item->client_id); ?>
									<?php echo JLayoutHelper::render('xiroadmin.com_templates.thumb', array('template'=> $item->template, 'client_id' => $item->client_id   )); ?>
								<div class="card-body text-center">
									<h2><?php echo $this->escape($item->title); ?></h2>
									<p><?php echo ucfirst($this->escape($item->template)); ?></p>
									<?php if ($clientId === 0) : ?>
										<div class="small">
											<?php if ($item->home == '1') : ?>
												<?php echo JText::_('COM_TEMPLATES_STYLES_PAGES_ALL'); ?>
											<?php elseif ($item->home != '0' && $item->home != '1') : ?>
												<?php echo JText::sprintf('COM_TEMPLATES_STYLES_PAGES_ALL_LANGUAGE', $this->escape($item->language_title)); ?>
											<?php elseif ($item->assigned > 0) : ?>
												<?php echo JText::sprintf('COM_TEMPLATES_STYLES_PAGES_SELECTED', $this->escape($item->assigned)); ?>
											<?php else : ?>
												<?php echo JText::_('COM_TEMPLATES_STYLES_PAGES_NONE'); ?>
											<?php endif; ?>
										</div>
									<?php endif; ?>

									<div class="text-center">
										<?php if ($item->home == '0' || $item->home == '1') : ?>
											<?php //  echo JHtml::_('jgrid.isdefault', $item->home != '0', $i, 'styles.', $canChange && $item->home != '1'); ?>
											<?php  echo JLayoutHelper::render('xiroadmin.jgridisdefault', array('value'=> ($item->home != '0'), 'i' => $i, 'prefix' => 'styles.', 'enabled' => ($canChange && $item->home != '1'))); ?>
										<?php elseif ($canChange) : ?>
											<a class="btn btn-default" href="<?php echo JRoute::_('index.php?option=com_templates&task=styles.unsetDefault&cid[]=' . $item->id . '&' . JSession::getFormToken() . '=1'); ?>">
												<?php if ($item->image) : ?>
													<?php echo JHtml::_('image', 'mod_languages/' . $item->image . '.gif', $item->language_title, array('title' => JText::sprintf('COM_TEMPLATES_GRID_UNSET_LANGUAGE', $item->language_title)), true); ?>
												<?php else : ?>
													<span class="label" title="<?php echo JText::sprintf('COM_TEMPLATES_GRID_UNSET_LANGUAGE', $item->language_title); ?>"><?php echo $item->language_sef; ?></span>
												<?php endif; ?>
											</a>
										<?php else : ?>
											<?php if ($item->image) : ?>
												<?php echo JHtml::_('image', 'mod_languages/' . $item->image . '.gif', $item->language_title, array('title' => $item->language_title), true); ?>
											<?php else : ?>
												<span class="label" title="<?php echo $item->language_title; ?>"><?php echo $item->language_sef; ?></span>
											<?php endif; ?>
										<?php endif; ?>
									</div>
								</div>
							<div class="card-footer">
								<?php if ($this->preview && $item->client_id == '0') : ?>
									<?php
										$selector_viewsite = 'ModalSelectViewSite-'.$item->id;
										$layoutData_viewsite = array(
											'selector' => $selector_viewsite,
											'params'   => array(
												'title'       => JText::_('COM_TEMPLATES_TEMPLATE_PREVIEW'). ' ' . $this->escape($item->title),
												'url'         => JUri::root() . 'index.php?templateStyle=' . (int) $item->id,
												'modalxiro'  => true											
											)
										);
										echo JLayoutHelper::render('xiroadmin.xiromodalbutton',array(
											'selector' => $selector_viewsite,
											'class'	=> 'btn btn-primary',
											'icon' => 'fa fa-eye',
											'title' => JText::_('COM_TEMPLATES_TEMPLATE_PREVIEW')
										));
										echo JLayoutHelper::render('xiroadmin.xiromodal', $layoutData_viewsite); ?>
									<?php
										$selector_viewlayout = 'ModalSelectviewlayout-'.$item->id;
										$layoutData_viewlayout = array(
											'selector' => $selector_viewlayout,
											'params'   => array(
												'title'       => JText::_('TPL_XIROADMIN_COM_TEMPLATES_TEMPLATE_VIEW_LAYOUT'). ' ' . $this->escape($item->title),
												'url'         => JUri::root() . 'index.php?tp=1&positionmodal=1&templateStyle=' . (int) $item->id,
												'modalxiro'  => true	
											)
										);
										echo JLayoutHelper::render('xiroadmin.xiromodalbutton',array(
											'selector' => $selector_viewlayout,
											'class'	=> 'btn btn-primary',
											'icon' => 'fa fa-fw fa-object-group',
											'title' => JText::_('TPL_XIROADMIN_COM_TEMPLATES_TEMPLATE_VIEW_LAYOUT')
										));
										echo JLayoutHelper::render('xiroadmin.xiromodal', $layoutData_viewlayout); ?>
									
								<?php elseif ($item->client_id == '1') : ?>
									
								<?php else: ?>
									
								<?php endif; ?>

								<?php if ($canEdit) : ?>
								<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_templates&task=style.edit&id=' . (int) $item->id); ?>">
									<i class="fa fa-fw fa-pencil-square-o"></i>
									<?php echo JText::_('TPL_XIROADMIN_COM_TEMPLATES_TEMPLATE_EDIT'); ?></a>
								<?php else : ?>
									<?php echo $this->escape($item->title); ?>
								<?php endif; ?>
																						
								
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</tbody>
				</div>
			</div>

			

		<?php endif; ?>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
