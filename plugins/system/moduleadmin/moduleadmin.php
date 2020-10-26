<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  System.Xiroweb
 *
 * @copyright   Copyright (C) 2020 XiroWeb. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Component\ComponentHelper;

class plgSystemModuleadmin extends JPlugin
{

	protected $autoloadLanguage = true;

	function __construct(&$subject, $config = array()) 
	{
		// call parent constructor
		parent::__construct($subject, $config);

		$app = Factory::getApplication();
		if ($app->input->getBool('positionmodal', 0))
		{
			ComponentHelper::getParams('com_templates')->set('template_positions_display',1);
		}

	}

	public function onContentPrepareForm(Form $form, $data)
	{

		$name = $form->getName();

		if (!in_array($name, array('com_modules.module')))
		{
			return true;
		}

		FormHelper::addFieldPath(__DIR__ . '/fields');
		FormHelper::addRulePath(__DIR__ . '/rules');
		Form::addFormPath(__DIR__ . '/form');
		$form->loadFile('module',true);

		return true;
	}

	public function onRenderModule($module, &$attribs)
	{

		$app = Factory::getApplication();
		
		if ($app->input->getBool('positionmodal'))
		{
			include_once __DIR__ . '/helper/modulechrome.php';

			$attribs['style'] = str_replace('outline', 'outlinemodal', $attribs['style']);

		}

		return true;

	}
        
}
