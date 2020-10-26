<?php 

use Joomla\Utilities\ArrayHelper;


$value = $displayData['value'];
$i = $displayData['i'] ? $displayData['i'] : '0' ;
$prefix = $displayData['prefix'] ? $displayData['prefix'] : '';
$enabled = !is_null($displayData['enabled']) ? $displayData['enabled'] : true;
$checkbox = !empty($displayData['checkbox']) ? $displayData['checkbox'] : 'cb' ;

// grid isdefault

$states = array(
	0 => array('setDefault', '', 'JLIB_HTML_SETDEFAULT_ITEM', '', 1, 'unfeatured', 'unfeatured'),
	1 => array('unsetDefault', 'JDEFAULT', 'JLIB_HTML_UNSETDEFAULT_ITEM', 'JDEFAULT', 1, 'featured', 'featured'),
);

// grid state
if (is_array($prefix))
{
	$options = $prefix;
	$enabled = array_key_exists('enabled', $options) ? $options['enabled'] : $enabled;
	$translate = array_key_exists('translate', $options) ? $options['translate'] : $translate;
	$checkbox = array_key_exists('checkbox', $options) ? $options['checkbox'] : $checkbox;
	$prefix = array_key_exists('prefix', $options) ? $options['prefix'] : '';
}

$state = ArrayHelper::getValue($states, (int) $value, $states[0]);
$task = array_key_exists('task', $state) ? $state['task'] : $state[0];
$text = array_key_exists('text', $state) ? $state['text'] : (array_key_exists(1, $state) ? $state[1] : '');
$active_title = array_key_exists('active_title', $state) ? $state['active_title'] : (array_key_exists(2, $state) ? $state[2] : '');
$inactive_title = array_key_exists('inactive_title', $state) ? $state['inactive_title'] : (array_key_exists(3, $state) ? $state[3] : '');
$tip = array_key_exists('tip', $state) ? $state['tip'] : (array_key_exists(4, $state) ? $state[4] : false);
$active_class = array_key_exists('active_class', $state) ? $state['active_class'] : (array_key_exists(5, $state) ? $state[5] : '');
$inactive_class = array_key_exists('inactive_class', $state) ? $state['inactive_class'] : (array_key_exists(6, $state) ? $state[6] : '');

// grid action

$translate = true;

if (is_array($prefix))
		{
			$options = $prefix;
			$active_title = array_key_exists('active_title', $options) ? $options['active_title'] : $active_title;
			$inactive_title = array_key_exists('inactive_title', $options) ? $options['inactive_title'] : $inactive_title;
			$tip = array_key_exists('tip', $options) ? $options['tip'] : $tip;
			$active_class = array_key_exists('active_class', $options) ? $options['active_class'] : $active_class;
			$inactive_class = array_key_exists('inactive_class', $options) ? $options['inactive_class'] : $inactive_class;
			$enabled = array_key_exists('enabled', $options) ? $options['enabled'] : $enabled;
			$translate = array_key_exists('translate', $options) ? $options['translate'] : $translate;
			$checkbox = array_key_exists('checkbox', $options) ? $options['checkbox'] : $checkbox;
			$prefix = array_key_exists('prefix', $options) ? $options['prefix'] : '';
		}

		if ($tip)
		{
			JHtml::_('bootstrap.tooltip');

			$title = $enabled ? $active_title : $inactive_title;
			$title = $translate ? JText::_($title) : $title;
			$title = JHtml::_('tooltipText', $title, '', 0);
		}

		if ($enabled)
		{
			$html[] = '<a class="btn btn-primary-outline' . ($active_class === 'publish' ? ' active' : '') . ($tip ? ' hasTooltip' : '') . '"';
			$html[] = ' href="javascript:void(0);" onclick="return Joomla.listItemTask(\'' . $checkbox . $i . '\',\'' . $prefix . $task . '\')"';
			$html[] = $tip ? ' title="' . $title . '"' : '';
			$html[] = '>';
			$html[] = '<i class="fa fa-fw fa-circle-o fa-2x"></i>';
			$html[] = '</a>';
		}
		else
		{
			$html[] = '<a class="btn btn-warning ' . ($tip ? ' hasTooltip' : '') . '"';
			$html[] = $tip ? ' title="' . $title . '"' : '';
			$html[] = '>';

			if ($active_class === 'protected')
			{
				$html[] = '<span class="icon-lock"></span>';
			}
			else
			{
				$html[] = '<i class="fa fa-fw fa-check-circle-o fa-2x"></i>';
			}

			$html[] = '</a>';
		}

		echo implode($html);