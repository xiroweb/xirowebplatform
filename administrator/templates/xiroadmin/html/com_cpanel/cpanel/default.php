<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_cpanel
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

$user = JFactory::getUser();
?>
	<div class="row-bs3">
		<div class="col-xs-12">
		<?php $cpanel2 = JModuleHelper::getModules('cpanel2');
			if ($cpanel2) : ?>			
						<?php
						// Display the submenu position modules
						foreach ($cpanel2 as $module)
						{
							echo JModuleHelper::renderModule($module, array('style' => 'xhtml'));
						}
						?>
				
			<?php endif; ?>
		</div>
	</div>
	<div class="row-bs3">
		<?php $cpanel3 = JModuleHelper::getModules('cpanel3');
			if ($cpanel3) : ?>			
				<?php
				// Display the submenu position modules
				foreach ($cpanel3 as $module)
				{
					echo '<div class="col-xs-12 col-md-6">';
					echo JModuleHelper::renderModule($module, array('style' => 'well'));
					echo '</div>';
				}
				?>		
			<?php endif; ?>	
	</div>
	<div class="row-bs4">
		<?php $cpanel4 = JModuleHelper::getModules('cpanel4');
			if ($cpanel4) : ?>			
				<?php
				// Display the submenu position modules
				foreach ($cpanel4 as $module)
				{
					echo '<div class="col-xs-12 col-md-12">';
					echo JModuleHelper::renderModule($module, array('style' => 'xhtml'));
					echo '</div>';
				}
				?>		
			<?php endif; ?>	
	</div>



	<?php $iconmodules = JModuleHelper::getModules('icon');
	if ($iconmodules) : ?>
				<?php
				// Display the submenu position modules
				foreach ($iconmodules as $iconmodule)
				{
					JModuleHelper::renderModule($iconmodule);
				}
				?>
	<?php endif; ?>
