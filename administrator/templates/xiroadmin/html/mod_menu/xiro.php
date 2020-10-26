<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$doc       = JFactory::getDocument();
$direction = $doc->direction == 'rtl' ? 'pull-right' : '';
$class     = $enabled ? 'sidebar-menu ' . $direction : 'sidebar-menu disabled ' . $direction;

// Recurse through children of root node if they exist
$menuTree = $menu->getTree();

// more
$children = $menuTree->getCurrent()->getChildren();

$uri = clone JUri::getInstance();
$urlactive = htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8');

foreach ($children as $child)
{
    foreach ($child->getChildren() as $itemmenu) {
		// menu item level 3
		if ($itemmenu->hasChildren()) {
            foreach ($itemmenu->getChildren() as $itemmenulevel3) {
				$link3 = $itemmenulevel3->get('link');
				$link3 = str_replace('index.php', '', $link3);
				if (!empty($link3) && strpos($urlactive, $link3)) {
					$itemmenulevel3->setActive(true);
					$itemmenulevel3->getParent()->setActive(true);
					$itemmenulevel3->getParent()->getParent()->setActive(true);
				}
            }
		}
		// menu item level 2
        $link = $itemmenu->get('link');
        $link = str_replace('index.php', '', $link);
        if (!empty($link) && strpos($urlactive, $link)) {
			$itemmenu->setActive(true);
			$itemmenu->getParent()->setActive(true);
        }
    }
}

$root     = $menuTree->reset();

if ($root->hasChildren())
{
	echo '<ul id="menuxiroadmin" class="' . $class . ' "  data-widget="tree" >' . "\n";

	// WARNING: Do not use direct 'include' or 'require' as it is important to isolate the scope for each call
	$menu->renderSubmenu(JModuleHelper::getLayoutPath('mod_menu', 'xiro_submenu'));

	echo "</ul>\n";

	echo '<ul id="nav-empty" class="dropdown-menu nav-empty hidden-phone"></ul>';


	if ($css = $menuTree->getCss())
	{
		$doc->addStyleDeclaration(implode("\n", $css));
	}
}
