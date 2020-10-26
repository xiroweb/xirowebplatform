<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
use Joomla\CMS\Menu\Node\Separator;
use Joomla\String\StringHelper;

defined('_JEXEC') or die;


/**
 * =========================================================================================================
 * IMPORTANT: The scope of this layout file is the `JAdminCssMenu` object and NOT the module context.
 * =========================================================================================================
 */
/** @var  JAdminCssMenu  $this */
$current = $this->tree->getCurrent();

$level = $current->getLevel();

if ($level == 2) {
	// Build the CSS class suffix


	// Print the item
	echo '<li>';


	// Print a link if it exists
	$linkClass     = array();
	$dataToggle    = '';
	$dropdownCaret = '';

	
	// Implode out $linkClass for rendering
	$linkClass = ' class="' . implode(' ', $linkClass) . '" ';

	// Links: component/url/heading/container
	if ($link = $current->get('link'))
	{
		
	

		echo '<a' . $linkClass . $dataToggle . ' href="' . $link . '" ' .  '>';
	

		echo '<div class="box-app-component text-center">';
		echo '<div class="icon_text">';
		echo '<span>' . JText::_($current->get('title'))[0]. '</span>';
		echo '</div>';
		echo '<div class="title">';
		echo JText::_($current->get('title'));
		echo '</div>';
		echo '</div>';


		echo  '</a>';



	}
	// Separator
	else
	{
		echo '<span>' . JText::_($current->get('title')) . '</span>';
	}


	echo "</li>\n";
}
// Recurse through children if they exist
if ($this->enabled && $current->hasChildren())
{

	// WARNING: Do not use direct 'include' or 'require' as it is important to isolate the scope for each call
	$this->renderSubmenu(__FILE__);


}


