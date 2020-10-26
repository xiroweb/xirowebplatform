<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_title
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if (!empty($title)) : ?>
	<?php echo $title; ?>
<?php else : ?>
	
	<h1 class="page-title">
	<i class="fa fa-fw fa-paper-plane-o"></i>
	<?php echo '&nbsp;'; ?></h1>
<?php endif; ?>
