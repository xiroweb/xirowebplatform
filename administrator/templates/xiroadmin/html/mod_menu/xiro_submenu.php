<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
use Joomla\CMS\Menu\Node\Separator;

defined('_JEXEC') or die;

/**
 * =========================================================================================================
 * IMPORTANT: The scope of this layout file is the `JAdminCssMenu` object and NOT the module context.
 * =========================================================================================================
 */
/** @var  JAdminCssMenu  $this */
$current = $this->tree->getCurrent();

$uri = clone JUri::getInstance();
$urlactive = htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8');
// Build the CSS class suffix
$class     = array();
if (!$this->enabled)
{
	$class[] = 'disabled';
}
elseif ($current instanceOf Separator)
{
	$class[] = $current->get('title') ? 'menuitem-group' : 'divider';
}
elseif ($current->hasChildren())
{
	if ($current->getLevel() == 1)
	{
		$class[] = 'treeview';
	}
	elseif ($current->get('class') == 'scrollable-menu')
	{
		$class[] = 'treeview';
	}
	else
	{
		$class[] = 'treeview';
	}
}
else
{
	$class[] = '';
}

// get active
$active = $current->get('active');
if ($active) {
	$class[] = 'active';
}



$class = ' class=" ' . implode(' ', $class) . '" ';
// Print the item
echo '<li' . $class . '>';

// Print a link if it exists
$linkClass     = array();
$dataToggle    = '';
$dropdownCaret = '';

if ($current->hasChildren())
{
	$linkClass[] = 'itemmenu-admin';
	$dataToggle  = '';

	if ($current->getLevel() > 0 )
	{
		$dropdownCaret = '  <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i></span>';
	}
}
else
{
	$linkClass[] = '';
}

$iconfa = '';
if (!($current instanceof Separator))
{
	$iconClass = $this->tree->getIconClass();

	if (trim($iconClass))
	{
		$iconfa = '<i class="'. $iconClass .'"></i> ';
	} else {
		$iconfa = '<i class="fa fa-circle-o"></i> ';
	}
	
}

// Implode out $linkClass for rendering
$linkClass = ' class="' . implode(' ', $linkClass) . '" ';

// Links: component/url/heading/container
if ($link = $current->get('link'))
{
	$icon = $current->get('icon');

	if ($icon)
	{
		if (substr($icon, 0, 6) == 'class:')
		{
			$icon = '<span class="' . substr($icon, 6) . '"></span>';
		}
		elseif (substr($icon, 0, 6) == 'image:')
		{
			$icon = JHtml::_('image', substr($icon, 6), null, null, true);
		}
		else
		{
			$icon = JHtml::_('image', $icon, null);
		}
	}

	$target = $current->get('target') ? 'target="' . $current->get('target') . '"' : '';

	echo '<a' . $linkClass . $dataToggle . ' href="' . $link . '" ' . $target . '>' . $iconfa . '<span>'.JText::_($current->get('title')) . '</span>' . $dropdownCaret . '</a>';
}
// Separator
else
{
	echo '<span>' . JText::_($current->get('title')) . '</span>';
}

// Recurse through children if they exist
if ($this->enabled && $current->hasChildren())
{
	if ($current->getLevel() > 1)
	{
		$id = $current->get('id') ? ' id="menu-' . strtolower($current->get('id')) . '"' : '';

		echo '<ul' . $id . ' class="treeview-menu">' . "\n";
	}
	else
	{
		echo '<ul class="treeview-menu">' . "\n";
	}

	// WARNING: Do not use direct 'include' or 'require' as it is important to isolate the scope for each call
	$this->renderSubmenu(__FILE__);

	echo "</ul>\n";
}

echo "</li>\n";
